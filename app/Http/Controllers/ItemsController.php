<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    //
    public function show() {
        return view('content.daftar-item', ['user' => auth()->user(), 'items' => Items::all()]);
    }
}
