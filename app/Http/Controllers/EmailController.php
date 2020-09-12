<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //emails need to access the logo
    public function getPicture($filename){
        $path = public_path() . '//img//' . $filename;

        if(!File::exists($path)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    //test emails with url
    public function testEmail($mail, $send = false) {
        //to see preview:   /test_mails/Confirmation
        //to send:          /test_mails/Confirmation/send
        if(config('app.debug')) {
            $user = Auth::user();
            $mailClass = '\\App\\Mail\\'.$mail;
            if($send){
                Mail::to($user)->queue(new $mailClass($user->name));
                return response("Email sent.");
            } else {
                return new $mailClass($user->name);
            }
        } else {
            abort(404);
        }
    }
}
