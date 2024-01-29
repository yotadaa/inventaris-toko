<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    //
    public function show() {
        $items = Items::where('email', '=', auth()->user()->email)->get();
        return view('content.daftar-item', ['user' => auth()->user(), 'items' => $items]);
    }

}
