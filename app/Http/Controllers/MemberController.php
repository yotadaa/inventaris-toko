<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Files;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Intervention\Image\Facades\Image;

class MemberController extends Controller
{
    public function index() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $members = DB::table('members')->where('root', $user->email)->get();
        return view('content.member.index', ['user' => $user, 'members' => $members]);
    }

    public function login(Request $request) {
        return view('content.member.login');
    }
    function logout() {
        Auth::guard('member')->logout();
        return redirect()->route('login');
    }

    public function create(Request $request) {
        Session::flash('nama-member', $request->name);
        Session::flash('email-member', $request->email);


        if (!auth()->guard('web')->check()) {
            return redirect()->route('login');
        }


        $existingUser = DB::table('members')->whereRaw('email = ? AND root = ? ', [$request->email, auth()->guard('web')->user()->email])->first();

        if ($existingUser) {
            return redirect()->route('tambah-member')->withErrors(['error' => "$request->email Email sudah terdaftar"]);
        }

        if ($request->confirmationPassword != $request->password) {
            return redirect()->route('tambah-member')->withErrors(['error' => 'Periksa kembali password']);
        }

        if ($request->email == auth()->guard('web')->user()->email) {
            return redirect()->route('tambah-member')->withErrors(['error' => "$request->email sudah terdaftar!"]);
        }

        
        // if (!$request->hasFile('file')) {
        //     echo 'cannot detect the file';
        // }
        $path = '/assets/img/product-3.jpg';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $tujuan_upload = 'assets/img/users/';
            $file_name = $request->email.$request->root.'.'.$file->getClientOriginalExtension();
            $image =Image::make($file)
            ->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->orientate()
            ->encode($file->getClientOriginalExtension(), 40);
            $path = $tujuan_upload.$file_name;
            $image->save(public_path($path));
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto_profile' => $path,
            'role' => $request->role_member,
            'root' => auth()->guard('web')->user()->email,
        ];

        $user = DB::table('members')->insert($data);

        if ($user) {
            return redirect()->route('member');
        }
        else {
            return redirect()->route('tambah-member')->withErrors(['error' => 'Gagal membuat member!']);
        }
    }

    public function tambah() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $members = DB::table('members')->where('root', $user->email)->get();
        return view('content.member.tambah', ['user' => $user]);
    }

    public function delete(Request $request) {
        $userToDelete = DB::table('members')->whereRaw('email = ? AND root = ?', [$request->email, $request->root])->first();
        if ($userToDelete) {
            DB::table('members')->whereRaw('email = ? AND root = ?', [$request->email, $request->root])->delete();
            return response()->json(['success' => true, 'message' => 'Berhasil Menghapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal Menghapus']);
        }
    }
}
