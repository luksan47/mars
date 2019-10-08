<?php

namespace App\Http\Controllers;

use App\MacAddress;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\TabulatorPaginator;

class InternetController extends Controller
{
    public function index()
    {
        return view('internet.app');
    }


    public function admin()
    {
        return view('admin.internet.app');
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
        $paginator = TabulatorPaginator::from(MacAddress::join('users as user', 'user.id', '=', 'user_id')->select('mac_addresses.*')->with('user'))
            ->sortable(['mac_address', 'comment', 'state', 'user.name'])
            ->filterable(['mac_address', 'comment', 'user.name', 'state'])
            ->paginate();

        $paginator->getCollection()->transform($this->translateStates());

        return $paginator;
    }

    public function deleteMacAddress(Request $request, $id)
    {
        $macAddress = MacAddress::findOrFail($id);

        if (!Auth::user()->isAdmin() && $macAddress->user->id != Auth::user()->id) { // TODO: use gate
            throw new AuthorizationException();
        }

        $macAddress->delete();
    }

    public function editMacAddress(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) { // TODO: use gate
            throw new AuthorizationException();
        }

        $macAddress = MacAddress::findOrFail($id);
        if($request->has('state')) {
            $macAddress->state = $request->input('state');
        }

        $macAddress->save();

        return $this->translateStates()($macAddress);
    }

    public function addMacAddress(Request $request)
    {
        $request->validate(
            [
                'comment' => 'required|max:1000',
                'mac_address' => ['required', 'regex:/((([a-zA-z0-9]{2}[-:]){5}([a-zA-z0-9]{2}))|(([a-zA-z0-9]{2}:){5}([a-zA-z0-9]{2})))/i'],
            ]
        );

        $macAddress = new MacAddress();
        $macAddress->user_id = Auth::user()->id;
        if (Auth::user()->isAdmin() && $request->has('user_id')) { // TODO: use gate
            $request->validate([
                'user_id' => 'integer|exists:users,id',
            ]);
            $macAddress->user_id = $request->input('user_id');
            $macAddress->state = MacAddress::APPROVED;
        }
        $macAddress->comment = $request->input('comment');
        $macAddress->mac_address = str_replace('-', ':', strtoupper($request->input('mac_address')));
        $macAddress->save();

        return redirect()->back();
    }

    public function translateStates(): \Closure
    {
        return function ($data) {
            $data->state = strtoupper($data->state);
            switch ($data->state) {
                case MacAddress::APPROVED:
                    $data->_state = $data->state;
                    $data->state = __('internet.approved');
                    break;
                case MacAddress::REJECTED:
                    $data->_state = $data->state;
                    $data->state = __('internet.rejected');
                    break;
                case MacAddress::REQUESTED:
                    $data->_state = $data->state;
                    $data->state = __('internet.requested');
                    break;
            }
            return $data;
        };
    }
}
