<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        return view('content.member.index', ['user' => $user]);
    }
}
