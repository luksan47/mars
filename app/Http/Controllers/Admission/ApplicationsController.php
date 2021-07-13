<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications;
use App\Models\Permissions;
use App\Models\Uploads;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Gate;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        $user_id = auth()->user()->id;
        $permissions = Permissions::where('user_id',$user_id)->get();

        $permission_workshop_accesses = array_filter($permissions, function($permission){
            return isset( Permissions::WORKSHOP_PERMISSIONS[$permission] );
        });

        return $permission_workshop_accesses;
    }*/

    public function indexWorkshop($workshop_url){
        $workshop_code = Permissions::cast_workshop_url_to_code($workshop_url);

        if(Gate::allows('hasPermission',[$workshop_code])){
            $applications = Applications::where('status',Applications::STATUS_FINAL)->where('misc_workshops','like','%'.$workshop_code.'%')->get();
            //return ['applications' => $applications];
            return view('applications.list_end')->with(['applications' => $applications, 'workshop_name' => Permissions::WORKSHOPS[$workshop_code]['name']]);
        } else{
            return redirect()->back()->with('error','A szükséges engedély nincs ehez a fiókhozrendelve.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exeminer_user_id = auth()->user()->id;
        $exeminer_permissions = Permissions::where('user_id',$exeminer_user_id)->get(); // string[]
        $application = Applications::where('id',$id)->get(['status', 'misc_workshops'])[0];

        // is finalised? or has permission for view unfinished applications
        /*if( $application['status'] != Applications::STATUS_FINAL || )
            return redirect()->back()->with('error','Nincs még véglegesítve a jelentkezés!');*/

        $possible_permissions = $application['misc_workshops']; // string

        $has_permission = false;
        foreach($exeminer_permissions as $permission){
            if( strpos($possible_permissions,$permission['permission']) !== false ){
                $has_permission = true;
                break;
            }
        }

        // list permissions
        if( $application['status'] != Applications::STATUS_FINAL && Gate::allows('hasPermission',[ Permissions::PERMISSION_LIST_FINAL_APPLICATIONS ]) ){
            $has_permission = true;
        }
        if( $application['status'] != Applications::STATUS_UNFINAL && Gate::allows('hasPermission',[ Permissions::PERMISSION_LIST_INPROGRESS_APPLICATIONS ]) ){
            $has_permission = true;
        }

        if($has_permission){
            $application = Applications::find_id_prepare($id);
            $uploads = Uploads::where('applications_id',$id)->get();

            return view('applications.show_end')->with(['application' => $application, 'uploads' => $uploads]);
        } else {
            return redirect()->back()->with('error','Nincs hozzáférésed a jelentkezéshez!');
        }
    }



}
