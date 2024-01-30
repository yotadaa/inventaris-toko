<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\ImageOptimizer\Optimizers\Pngquant;

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

    public function store(Request $request) {
        if (!auth()->user()) return redirect()->route('index');
        $user = auth()->user();
        $kode = Items::where('email','=',$user->email)->count();

        if (!$request->hasFile('file')) {
            $path = '/assets/img/product-3.jpg';
        } else {
            $file = $request->file('file');
            $tujuan_upload = 'assets/img/items';
            $file_name = $kode.'.'.$file->getClientOriginalName();
            $path = $file->move($tujuan_upload,$file_name);
        }
        $item = [
            'foto' => $path,
            'nama' => $request->nama_brg,
            'desk' => $request->desk_brg,
            'kategori' => $request->kategori_brg,
            'stok' => $request->stok_brg,
            'harga_awal' => $request->hrg_awl_brg,
            'harga_jual' => $request->hrg_jual_brg,
            'email' => $user->email,
            'kode' => $kode
        ];

        // echo "\nUsing var_dump:\n";
        // var_dump($item);
        Items::create($item);

        $optimizer = new OptimizerChain();
        $optimizer->setTimeout(10);
        $optimizer->addOptimizer((new Pngquant([
            '--all-progressive',
        ]))->setBinaryPath($path));
        return redirect()->route('items');

    }

    public function delete(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('index');
        }
        $user = auth()->user();
        $itemToDelete = Items::whereRaw('email = ? AND kode = ?', [$request->confirmedEmail, $request->confirmedKode])->first();
        $itemToDelete->delete();
        return response()->json(['success' => true, 'message' => 'barang berhasil dihapus']);
    }

}
