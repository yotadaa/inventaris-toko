<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    //
    public function show() {
        if (!(auth()->check())) {
            return redirect()->route('login');
        }
        $items = Items::where('email', '=', auth()->user()->email)->get();
        return view('content.daftar-item', ['user' => auth()->user(), 'items' => $items]);
    }

    public function tambah() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        return view('content/items/tambah', ['user' => $user]);
    }

}
