<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    //
    public function index() {
        return view('sesi.login');
    }

    public function login(Request $request) {
        Session::flash('email', $request->email);
        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infoLogin)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'value' => 'email dan password tidak valid', 'get' => $infoLogin]);
        }
    }

    function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register() {
        return view('sesi.register', ['error' => false, 'msg' => '']);
    }

    public function create(Request $request) {
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            return response()->json(['status' => false, 'msg' => 'Email sudah terdaftar']);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profile' => 'foto123',
        ];

        // return response()->json(['status' => true, 'user' => $data]);

        $user = User::create($data);

        Session::flash('nama', $request->nama);
        Session::flash('email', $request->email);

        $infoLogin = [
            'email' => $request->email,
            'password' => $request->password
        ];


        if (Auth::attempt($infoLogin)) {
            return response()->json(['status' => true, 'user' => $user]);
        } else {
            return response()->json(['status' => false, 'value' => 'email dan password tidak valid']);
        }
        // return response()->json(['status' => false, 'value' => 'email dan password tidak valid', 'get' => $existingUser]);
    }




}
