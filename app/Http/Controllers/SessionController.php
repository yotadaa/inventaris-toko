<?php

namespace App\Http\Controllers;

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

    public function __construct() {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('guest:web')->except('logout');
        // $this->middleware('guest:member')->except('logout');
    }
    public function index() {
        return view('sesi.login');
    }

    public function login(Request $request) {
        Session::flash('email', $request->email);

        $credential1 = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $credential2 = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $guard = $request->has('role') ? 'member' : 'web';
        $credentials = $request->has('role') ? $credential2 : $credential1;

        if (Auth::guard($guard)->attempt($credentials,  $request->get('remember'))) {
            $request->session()->regenerate();
            return response()->json(['status' => true, 'user' => Auth::guard($guard)->user(), 'statuses' => auth()->guard($guard)->check()]);
        } else {
            return response()->json(['status' => false, 'value' => 'email dan password tidak valid']);
        }
    }


    function logout() {
        if (auth()->guard('web')->check()) {
            Auth::guard('web')->logout();
        } else {
            Auth::guard('member')->logout();
        }
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
            'role' => 'super',
            'root' => $request->email
        ];

        $user = User::create($data);

        if ($user) return response()->json(['status' => true, 'user' => $user]);
        else return response()->json(['status' => false, 'msg' => 'Gagal membuat akun']);


        // if (Auth::attempt($infoLogin)) {
        //     return response()->json(['status' => true, 'user' => $user]);
        // } else {
        //     return response()->json(['status' => false, 'value' => 'email dan password tidak valid']);
        // }
        // return response()->json(['status' => false, 'value' => 'email dan password tidak valid', 'get' => $existingUser]);
    }

    public function update(Request $request) {

    }

    public function changePassword(Request $request) {
        if (!(auth()->guard('web')->check() && auth()->guard('member')->check())) {
            return redirect()->route('login');
        }
        $user = auth()->guard('web')->check() ? auth()->guard('web')->user() : auth()->guard('member')->user();
        
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
