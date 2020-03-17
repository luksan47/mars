<?php

namespace App\Http\Controllers;

use App\InternetAccess;
use App\MacAddress;
use App\User;
use App\Utils\TabulatorPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $activationDate = env('INTERNET_ACTIVATION_DATE'); //TODO: get date for current semester
        return view('admin.internet.app', ['activation_date' => $activationDate, 'users' => User::all()]);
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
            ->sortable(['auto_approved_mac_slots', 'has_internet_until', 'user.name', 'wifi_username'])
            ->filterable(['auto_approved_mac_slots', 'has_internet_until', 'user.name', 'wifi_username'])
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
            $internetAccess->auto_approved_mac_slots = $request->input('auto_approved_mac_slots');
        }

        $internetAccess->save();

        $this->autoApproveMacAddresses(User::find($internetAccess->user_id));

        return InternetAccess::join('users as user', 'user.id', '=', 'user_id')
            ->select('internet_accesses.*')->with('user')
            ->where('user_id', '=', $internetAccess->user_id)->first();
    }

    public function addMacAddress(Request $request)
    {
        $request->validate(
            [
                'comment' => 'required|max:1000',
                'mac_address' => ['required', 'regex:/((([a-fA-F0-9]{2}[-:]){5}([a-fA-F0-9]{2}))|(([a-fA-F0-9]{2}:){5}([a-fA-F0-9]{2})))/i'],
            ]
        );

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

        return redirect()->back();
    }

    private function autoApproveMacAddresses($user)
    {
        DB::statement('UPDATE mac_addresses SET state = \'APPROVED\' WHERE user_id = ? ORDER BY FIELD(state,\'APPROVED\',\'REQUESTED\',\'REJECTED\'), updated_at DESC limit ?;', [$user->id, $user->internetAccess->auto_approved_mac_slots]);
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
}
