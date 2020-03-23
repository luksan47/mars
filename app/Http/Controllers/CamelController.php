<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CamelController extends Controller
{
    public function index()
    {
        $shepherds = DB::table('shepherds')->get();
        $herds = DB::table('herds')->get();
        $shepherdings = DB::table('shepherding')->get();

        return view('camel_breeder.app', ['shepherds' => $shepherds, 'herds' => $herds, 'shepherdings' => $shepherdings]);
    }

    public function editIndex()
    {
        $shepherds = DB::table('shepherds')->get();
        $herds = DB::table('herds')->get();
        $shepherdings = DB::table('shepherding')->get();

        return view('camel_breeder.edit', ['shepherds' => $shepherds, 'herds' => $herds, 'shepherdings' => $shepherdings]);
    }

    public function add_shepherd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:shepherds',
            'id' => 'required|numeric|min:0|unique:shepherds',
        ]);

        DB::table('shepherds')->insert(
            [
                'name' => $validatedData['name'],
                'id' => $validatedData['id'],
                'camels' => 0,
            ]
        );

        return redirect()->back()->with('success', '');
    }

    public function add_herd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:herds',
            'camel_count' => 'required|numeric|min:0',
        ]);

        DB::table('herds')->insert(
            [
                'name' => $validatedData['name'],
                'camel_count' => $validatedData['camel_count'],
            ]
        );

        return redirect()->back()->with('success', '');
    }

    public function shepherding(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:shepherds',
            'name' => 'required|exists:herds',
        ]);

        $camels = DB::table('herds')->where('name', $validatedData['name'])->value('camel_count');

        DB::table('shepherding')->insert(
            [
                'shepherd'=> $validatedData['id'],
                'herd'=> $validatedData['name'],
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );

        $shepherd_s_camels = DB::table('shepherds')->where('id', $validatedData['id'])->value('camels');
        $new_camels = $shepherd_s_camels-$camels;
        if($new_camels >= env('CAMEL_MIN',-500)){
            DB::table('shepherds')->where('id',$validatedData['id'])->update(['camels' => $new_camels]);
            return redirect()->back()->with('success', '');
        }else{
            return redirect()->back()->with('failure', '');
        }
    }
}
