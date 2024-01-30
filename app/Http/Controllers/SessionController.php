<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

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
            if ($request->remember) {
                Cookie::make('remember', $request->email, 525600);
            }
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'value' => 'email dan password tidak valid', 'get' => $infoLogin, 'remember' => $request->remember]);
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
            'foto_profile' => '/assets/img/users/user_default.png',
        ];

        // return response()->json(['status' => true, 'user' => $data]);

        $user = User::create($data);
        Files::create([
            'path' => 'assets/img/users/user_default.png',
            'email' => auth()->user()->email
        ]);

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

    public function update(Request $request) {

    }

    public function changePassword(Request $request) {
        if (!(auth()->check())) {
            return redirect()->route('login');
        }

        if ($request->newpassword != $request->renewpassword) {
            return response()->json(['status' => false, 'message' => 'Periksa kembali password!']);
        }

        $user = auth()->user();
        if (Hash::check($request->newpassword,$user->password)) {
            return response()->json(['status' => false, 'message' => 'Password masih sama!']);
        }
        if (!Hash::check($request->password,$user->password)) {
            return response()->json(['status' => false, 'message' => 'Password invalid!']);
        }
        $user->password = Hash::make($request->renewpassword);
        User::where('email', '=', $user->email)->update(['password' => $user->password]);
    }



}
