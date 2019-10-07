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

    public function getUsersMacAddresses(Request $request)
    {
        $paginator = TabulatorPaginator::from(Auth::user()->macAddresses())
            ->sortable(['mac_address', 'comment', 'state'])->paginate();

        $paginator->getCollection()->transform(function ($data) {
            switch ($data->state) {
                case 'APPROVED':
                    $data->state = __('internet.approved');
                    break;
                case 'REJECTED':
                    $data->state = __('internet.rejected');
                    break;
                case 'REQUESTED':
                    $data->state = __('internet.requested');
                    break;
            }
            return $data;
        });

        return $paginator;
    }

    public function deleteMacAddress(Request $request, $id)
    {
        $macAddress = MacAddress::findOrFail($id);

        if (!Auth::user()->isAdmin() && $macAddress->user->id != Auth::user()->id) {
            throw new AuthorizationException();
        }

        $macAddress->delete();
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
        $macAddress->comment = $request->input('comment');
        $macAddress->mac_address = str_replace('-', ':', strtoupper($request->input('mac_address')));
        $macAddress->save();

        return redirect()->back();
    }
}
