<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CamelController extends Controller
{
    public function index()
    {
        return view('camel_breeder.app');
    }

    public function password(Request $request)
    {
        $hashedPassword = DB::table('farmer')->first()->password;
        $shepherdings = DB::table('shepherding')->get();
        if (Hash::check($request->input('password'), $hashedPassword)) {
            return back()->with('edit', '');
        } else {
            return back()->with('message', 'Rossz jelszó! :(');
        }
    }

    public function send_shepherds(Request $request)
    {
        $data = DB::table('shepherds')->get();

        return response()->json($data);
    }

    public function send_herds(Request $request)
    {
        $data = DB::table('herds')->get();

        return response()->json($data);
    }

    public function send_shepherdings(Request $request)
    {
        $data = DB::table('shepherding')
            ->join('shepherds', 'shepherds.id', '=', 'shepherding.shepherd')
            ->select('shepherds.name as name', 'shepherd as id', 'herd', 'created_at')
            ->get();

        return response()->json($data);
    }

    public function shepherding(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:shepherds',
            'herds' => 'required',
        ]);

        $all_camels = 0;
        foreach ($validatedData['herds'] as $herd) {
            $camels = DB::table('herds')->where('name', $herd)->value('camel_count');
            $all_camels += $camels;
        }
        if ($validatedData['id'] == 0) { //if visitor
            //store in shepherdings
            foreach ($validatedData['herds'] as $herd) {
                DB::table('shepherding')->insert(
                    [
                        'shepherd'=> $validatedData['id'],
                        'herd'=> $herd,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]
                );
            }
        } else {
            $shepherd_s_camels = DB::table('shepherds')->where('id', $validatedData['id'])->value('camels');
            $new_camels = $shepherd_s_camels - $all_camels;
            $min_camels = DB::table('shepherds')->where('id', $validatedData['id'])->value('min_camels');

            if ($new_camels < $min_camels) { //shepherd does have enough camels assigned to himself/herself
                return back()
                    ->withErrors(['herds'=> 'Nincs ennyi tevéd!'])
                    ->withInput()
                    ->with('message', 'Nincs ennyi tevéd!');
            }
            //store in shepherdings
            foreach ($validatedData['herds'] as $herd) {
                DB::table('shepherding')->insert(
                    [
                        'shepherd'=> $validatedData['id'],
                        'herd'=> $herd,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]
                );
            }
            //change sheperd's assigned camels
            DB::table('shepherds')->where('id', $validatedData['id'])->update(['camels' => $new_camels]);
        }

        return redirect()->back()->with('message', 'Sikeres tevézés!');
    }

    public function add_shepherd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:shepherds',
            'id' => 'required|numeric|min:0|unique:shepherds',
        ]);
        $def_min_camels = DB::table('farmer')->first()->def_min_camels;

        DB::table('shepherds')->insert(
            [
                'name' => $validatedData['name'],
                'id' => $validatedData['id'],
                'camels' => $request->input('camels') ?? 0,
                'min_camels' => $def_min_camels,
            ]
        );

        return redirect()->back()->with('message', 'Sikeres módosítás!')->with('edit', '');
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

        return redirect()->back()->with('message', 'Sikeres módosítás!')->with('edit', '');
    }

    public function add_camels(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:shepherds',
            'camels' => 'required|numeric|min:0',
        ]);
        if ($validatedData['id'] != 0) { //not visitor
            $old_camels = DB::table('shepherds')->where('id', $validatedData['id'])->value('camels');

            DB::table('shepherds')
                ->where('id', $validatedData['id'])
                ->update(['camels' => $old_camels + $validatedData['camels']]);

            return redirect()->back()->with('message', 'Sikeres módosítás!');
        } else {
            return redirect()->back()->with('message', 'Vendég nem adhat hozzá tevéket!');
        }
    }

    public function change_herd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|exists:herds',
            'camel_count' => 'required|numeric|min:0',
        ]);

        DB::table('herds')
            ->where('name', $validatedData['name'])
            ->update(['camel_count' => $validatedData['camel_count']]);

        return redirect()->back()->with('message', 'Sikeres módosítás!');
    }

    public function change_shepherd(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:shepherds',
            'min_camels' => 'required|numeric',
        ]);

        DB::table('shepherds')
            ->where('id', $validatedData['id'])
            ->update(['min_camels' => $validatedData['min_camels']]);

        return redirect()->back()->with('message', 'Sikeres módosítás!');
    }

    public function change_password(Request $request)
    {
        $hashedPassword = DB::table('farmer')->first()->password;
        if (Hash::check($request->input('old_password'), $hashedPassword)) {
            DB::table('farmer')
                ->update(['password' => Hash::make($request->input('new_password'))]);

            return redirect()->back()->with('message', 'Sikeres módosítás!')->with('edit', '');
        } else {
            return redirect()->back()->with('message', 'Rossz jelszó! :(');
        }
    }

    public function change_def_min_camels(Request $request)
    {
        DB::table('farmer')->update(['def_min_camels' => $request->input('def_min_camels')]);

        return redirect()->back()->with('message', 'Sikeres módosítás!')->with('edit', '');
    }
}
