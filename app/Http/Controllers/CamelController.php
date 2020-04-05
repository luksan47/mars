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

    public function send_shepherds(Request $request){
        return response()->json($shepherds = DB::table('shepherds')->get());
    }

    public function add_shepherd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:shepherds',
            'id' => 'required|numeric|min:0|unique:shepherds',
            'camels' => ''
        ]);

        DB::table('shepherds')->insert(
            [
                'name' => $validatedData['name'],
                'id' => $validatedData['id'],
                'camels' => $validatedData['camels'] ?? 0,
                'min_camels' => env('CAMEL_MIN', -500),
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

    public function add_camels(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:shepherds',
            'camels' => 'required|numeric|min:0',
        ]);
        if($validatedData['id'] != 0){ //not visitor
            $old_camels = DB::table('shepherds')->where('id', $validatedData['id'])->value('camels');

            DB::table('shepherds')
                ->where('id', $validatedData['id'])
                ->update(['camels' => $old_camels + $validatedData['camels']]);

            return redirect()->back()->with('success', '');
        }else{
            return back()
                ->withErrors(['id' => 'Vendég nem adhat hozzá tevéket!'])
                ->withInput();
        }
    }

    public function change_herd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'camel_count' => 'required|numeric|min:0',
        ]);

        DB::table('herds')
            ->where('name', $validatedData['name'])
            ->update(['camel_count' => $validatedData['camel_count']]);


        return redirect()->back()->with('success', '');
    }
    //TODO change_shepherd

    public function shepherding(Request $request)
    {
        //TODO visitor shepherdings
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:shepherds',
            'herds' => 'required',
        ]);

        $all_camels = 0;
        foreach($validatedData['herds'] as $herd){
            $camels = DB::table('herds')->where('name', $herd)->value('camel_count');
            $all_camels += $camels;
        }
        $shepherd_s_camels = DB::table('shepherds')->where('id', $validatedData['id'])->value('camels');
        $new_camels = $shepherd_s_camels - $all_camels;

        if ($new_camels < env('CAMEL_MIN', -500) && $validatedData['id'] != 0) { //not visitor and have enough camels
            return back()
                ->withErrors(['herds'=> 'Nincs ennyi tevéd!'])
                ->withInput();
        }
        foreach($validatedData['herds'] as $herd){
            DB::table('shepherding')->insert(
                [
                    'shepherd'=> $validatedData['id'],
                    'herd'=> $herd,
                    'created_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
        if($validatedData['id'] != 0){ //not visitor
            DB::table('shepherds')->where('id', $validatedData['id'])->update(['camels' => $new_camels]);
        }

        return redirect()->back()->with('success', '');
    }

    public function history(Request $request)
    {
        $data = DB::table('shepherding')->select('shepherd','herd')->get();

        return response()->json(array(
                'success' => true,
                'data'   => $data
            )); 
    }
}
