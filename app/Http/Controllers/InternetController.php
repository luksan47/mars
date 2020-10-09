<?php

namespace App\Http\Controllers;

use App\Models\EventTrigger;
use App\Models\InternetAccess;
use App\Models\MacAddress;
use App\Models\Role;
use App\Models\User;
use App\Models\WifiConnection;
use App\Utils\TabulatorPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InternetController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:internet.internet');
    }

    public function index()
    {
        $internetAccess = Auth::user()->internetAccess;

        return view('internet.app', ['internet_access' => $internetAccess]);
    }

    public function admin()
    {
        $activationDate = EventTrigger::internetActivationDeadline();
        $users_over_threshold = $this->usersOverWifiThreshold();

        return view('admin.internet.app', ['activation_date' => $activationDate, 'users' => User::all(), 'users_over_threshold' => $users_over_threshold]);
    }

    public function getUsersMacAddresses(Request $request)
    {
        $paginator = TabulatorPaginator::from(Auth::user()->macAddresses())
            ->sortable(['mac_address', 'comment', 'state'])->paginate();

        $paginator->getCollection()->transform($this->translateStates());

        return $paginator;
    }

    public function getUsersMacAddressesAdmin(Request $request)
    {
        $this->authorize('viewAny', MacAddress::class);

        $paginator = TabulatorPaginator::from(MacAddress::join('users as user', 'user.id', '=', 'user_id')
            ->join('internet_accesses as internet', 'internet.user_id', '=', 'user.id')
            ->select('mac_addresses.*', 'internet.wifi_username')->with('user'))
            ->sortable(['mac_address', 'comment', 'state', 'user.name', 'created_at', 'wifi_username'])
            ->filterable(['mac_address', 'comment', 'user.name', 'state', 'created_at', 'wifi_username'])
            ->paginate();

        $paginator->getCollection()->transform($this->translateStates());

        return $paginator;
    }

    public function getInternetAccessesAdmin()
    {
        $this->authorize('viewAny', InternetAccess::class);

        $paginator = TabulatorPaginator::from(InternetAccess::join('users as user', 'user.id', '=', 'user_id')->select('internet_accesses.*')->with('user'))
            ->sortable(['auto_approved_mac_slots', 'has_internet_until', 'user.name'])
            ->filterable(['auto_approved_mac_slots', 'has_internet_until', 'user.name'])
            ->paginate();

        return $paginator;
    }

    public function deleteMacAddress(Request $request, $id)
    {
        $macAddress = MacAddress::findOrFail($id);

        $this->authorize('delete', MacAddress::class);

        $macAddress->delete();

        $this->autoApproveMacAddresses($macAddress->user);
    }

    public function resetWifiPassword(Request $request)
    {
        $internetAccess = Auth::user()->internetAccess;
        $internetAccess->wifi_password = Str::random(8);
        $internetAccess->save();

        return redirect()->back();
    }

    public function editMacAddress(Request $request, $id)
    {
        $macAddress = MacAddress::findOrFail($id);

        $this->authorize('update', $macAddress);

        if ($request->has('state')) {
            $macAddress->state = $request->input('state');
        }

        $macAddress->save();

        $this->autoApproveMacAddresses($macAddress->user);

        $macAddress = $macAddress->refresh(); // auto approve maybe modified this

        return $this->translateStates()($macAddress);
    }

    public function editInternetAccess(Request $request, $id)
    {
        $internetAccess = InternetAccess::findOrFail($id);

        $this->authorize('update', $internetAccess);

        if ($request->has('has_internet_until')) {
            $internetAccess->has_internet_until = $request->input('has_internet_until');
        }

        if ($request->has('auto_approved_mac_slots')) {
            $internetAccess->auto_approved_mac_slots = min(0, $request->input('auto_approved_mac_slots'));
        }

        $internetAccess->save();

        $this->autoApproveMacAddresses(User::find($internetAccess->user_id));

        return InternetAccess::join('users as user', 'user.id', '=', 'user_id')
            ->select('internet_accesses.*')->with('user')
            ->where('user_id', '=', $internetAccess->user_id)->first();
    }

    public static function extendUsersInternetAccess(User $user)
    {
        $internetAccess = $user->internetAccess;
        if ($internetAccess != null) {
            $internetAccess->has_internet_until = EventTrigger::internetActivationDeadline();
            $internetAccess->save();

            return $internetAccess->has_internet_until;
        } else {
            return null;
        }
    }

    public function addMacAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:1000',
            'mac_address' => ['required', 'regex:/((([a-fA-F0-9]{2}[-:]){5}([a-fA-F0-9]{2}))|(([a-fA-F0-9]{2}:){5}([a-fA-F0-9]{2})))/i'],
        ]);
        $validator->validate();

        if ($validator->fails()) {
            return back()->withErros($validator)->withInput();
        }

        $macAddress = new MacAddress();
        $macAddress->user_id = Auth::user()->id;
        if (Auth::user()->can('accept', $macAddress) && $request->has('user_id')) {
            $request->validate([
                'user_id' => 'integer|exists:users,id',
            ]);
            $macAddress->user_id = $request->input('user_id');
            $macAddress->state = MacAddress::APPROVED;
        }
        $macAddress->comment = $request->input('comment');
        $macAddress->mac_address = str_replace('-', ':', strtoupper($request->input('mac_address')));
        $macAddress->save();

        $this->autoApproveMacAddresses(Auth::user());

        return redirect()->back()->with('message', __('general.successfully_added'));
    }

    private function autoApproveMacAddresses($user)
    {
        DB::statement('UPDATE mac_addresses SET state = \'APPROVED\' WHERE user_id = ? ORDER BY FIELD(state,\'APPROVED\',\'REQUESTED\',\'REJECTED\'), updated_at DESC limit ?;', [$user->id, $user->internetAccess->auto_approved_mac_slots]);
    }

    public function getWifiConnectionsAdmin()
    {
        $this->authorize('viewAny', WifiConnection::class);

        $paginator = TabulatorPaginator::from(WifiConnection::join('internet_accesses as i', 'i.wifi_username', 'wifi_connections.wifi_username')
            ->join('users as user', 'user.id', '=', 'i.user_id')
            ->select('wifi_connections.*')->with('user'))
            ->sortable(['user.name', 'wifi_username', 'mac_address'])
            ->filterable(['user.name', 'wifi_username', 'mac_address'])
            ->paginate();

        return $paginator;
    }

    public function translateStates(): \Closure
    {
        return function ($data) {
            $data->state = strtoupper($data->state);
            $data->_state = $data->state;
            switch ($data->state) {
                case MacAddress::APPROVED:
                    $data->state = __('internet.approved');
                    break;
                case MacAddress::REJECTED:
                    $data->state = __('internet.rejected');
                    break;
                case MacAddress::REQUESTED:
                    $data->state = __('internet.requested');
                    break;
            }

            return $data;
        };
    }

    public function usersOverWifiThreshold()
    {
        $users = Role::getUsers(Role::INTERNET_USER);
        foreach ($users as $user) {
            if (! $user->internetAccess->reachedWifiConnectionLimit()) {
                $users = $users->except([$user->id]);
            }
        }

        return $users;
    }

    public function approveWifiConnections($user)
    {
        $this->authorize('approveAny', WifiConnection::class);

        $user = User::findOrFail($user);

        $user->internetAccess->increment('wifi_connection_limit');

        return redirect()->back()->with('message', __('general.successful_modification'));
    }

    public function showCheckout()
    {
        $users = User::where('verified', false)->get();

        return view('admin.checkout', ['users' => $users]);
    }
}
