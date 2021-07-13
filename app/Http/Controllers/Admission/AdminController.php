<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications;
use App\Models\Permissions;
use App\Models\Uploads;
use App\Mail\RegisteredUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function userIndex()
    {
        $users = User::all();

        return view('admin.user.list_end')->with(['users' => $users]);
    }

    public function userShow($id)
    {
        $user = User::find($id);
        $permissions = Permissions::where('user_id', $user['id'])->get();

        // return ['user' => $user,'permissions' => $permissions];

        return view('admin.user.select_end')->with(['user' => $user, 'permissions' => $permissions]);
    }

    public function userUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'user_role' => ['required', Rule::in(User::ROLES)],
        ]);

        $user = User::findOrFail($id);

        $user->role = $request->input('user_role');

        $user->save();

        return redirect()->back()->with('success', 'Sikeresen mentésre kerültek a változtatások.');
    }

    public function userPermissionsAdd(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'permission' => 'required',
        ]);

        //return $request;
        if ( !(Permissions::id_permission_code_exist($request->input('permission'))) ) {
            //!key_exists($request->input('permission'), Permissions::PERMISSIONS_NAMES)) {
            // invalid permission
            return redirect()->back()->with('error', 'Invalid engedély kód!');
        }

        Permissions::create([
            'user_id' => $request->input('user_id'),
            'permission' => $request->input('permission'),
        ]);

        return redirect()->back()->with('success', 'Engedély hozzá adva');
    }

    public function userPermissionsRevoke(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'permission' => 'required',
        ]);

        Permissions::where('user_id', $request->input('user_id'))->where('permission', $request->input('permission'))->delete();

        return redirect()->back()->with('success', 'Engedély visszavonva');
    }


    public function applicationIndex()
    {
        $applications = Applications::all();

        return view('admin.application.list_end')->with(['applications' => $applications]);
        return $applications;
    }

    public function applicationShow($id)
    {
        $application = Applications::find_id_prepare($id);
        $uploads = Uploads::where('applications_id', $application['id'])->get();
        $user = User::where('id', $application['user_id'])->get()[0];

        //return ['user' => $user , 'application' => $application, 'uploads' => $uploads];

        return view('admin.application.select_end')->with(['user' => $user, 'application' => $application, 'uploads' => $uploads]);
    }

    public function applicationActionFinalise(Request $request)
    {
        $this->validate($request, [
            'application_id' => 'required|numeric',
        ]);

        $application = Applications::find($request->input('application_id'));

        $application->status = Applications::STATUS_FINAL;
        $application->save();

        return redirect()->back()->with('success', 'Véglegesítésre került!');
    }

    public function applicationActionUnfinilise(Request $request)
    {
        $this->validate($request, [
            'application_id' => 'required|numeric',
        ]);

        $application = Applications::find($request->input('application_id'));

        $application->status = Applications::STATUS_UNFINAL;
        $application->save();

        return redirect()->back()->with('success', 'Véglegesítés visszavonva!');
    }

    public function applicationActionBanish(Request $request)
    {
        $this->validate($request, [
            'application_id' => 'required|numeric',
        ]);

        $application = Applications::find($request->input('application_id'));

        $application->status = Applications::STATUS_BANISHED;
        $application->save();

        return redirect()->back()->with('success', 'A felvételi a HLas tó, halai sorsára jutott!');
    }


    public function registerEdit()
    {
        return view('admin.register.register_end');
    }

    public function registerRegister(Request $request)
    {
        $this->validate($request, [
            'register_data' => 'required',
            'perimission_ids' => 'nullable'
        ]);

        // interpret register_data
        // NAME ; EMAIL

        $register_data_lines = explode("\n", $request->input('register_data'));

        // validate line format
        // ?has ';' in line
        foreach ($register_data_lines as $line) {
            if (strpos($line, ';') === false) {
                // invalid line
                return redirect()->back()->with([
                    'prev_submit' => [
                        'register_data' => $request->input('register_data'),
                        'perimission_ids' => $request->input('perimission_ids'),
                    ],
                ])->with('error', 'Hibba a sorban: "' . trim($line) . '"');
            }
        }


        $register_data_extracted = [];
        foreach ($register_data_lines as $line) {
            $splited_line = explode(";", $line);
            $register_data_extracted[] = [
                'name' => trim($splited_line[0]),
                'email' => trim($splited_line[1]),
            ];
        }

        $permission_codes = $request->input('perimission_ids');

        $error_datas = [];

        foreach ($register_data_extracted as $data) {
            $user = new User;
            $new_password = 'tmp_' . Str::random(6);

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($new_password);
            $user->role = User::ROLE_USER;
            $user->pass_reset_req = true;

            try {
                $user->save();

                Mail::to(['email' => $data['email']])->queue(new RegisteredUser(
                    [
                        'name' => $data['name'],
                        'email' => $data['email'],
                    ],
                    $new_password,
                ));

                foreach ($permission_codes as $permission_code) {
                    Permissions::create([
                        'user_id' => $user->id,
                        'permission' => $permission_code,
                    ]);
                }
            } catch (\Throwable $th) {
                $error_datas[] = $data;

                continue;
            }
        }
        //return $error_datas; //TODO: maybe return somehow this as well

        return redirect()->back()->with(['success' => 'Felhasználók hozzáadásra kerültek!']);

        // return [$register_data_extracted, $request->input('perimission_ids'), $error_datas];


    }
}
