<?php

namespace App\Http\Controllers;

use App\Models\Belanja;
use App\Models\Items;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ItemsController extends Controller
{
    //

    public function index() {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    $user = auth()->user();
    $items = Items::where('email', $user->email)->get();
    $result = Transaction::join('items', 'transactions.id_brg', '=', 'items.kode')
    ->select('transactions.qty', 'transactions.created_at', 'items.foto', 'items.nama', 'items.desk', 'items.kategori','items.stok', 'items.harga_awal', 'items.harga_jual', 'transactions.email', 'items.kode')
    ->get();
    $belanja = DB::table('belanja')
    ->join('items', 'belanja.kode', '=', 'items.kode')
    ->select('belanja.qty', 'belanja.created_at','belanja.group', 'items.foto', 'items.nama', 'items.desk', 'items.kategori','items.stok', 'items.harga_awal', 'items.harga_jual', 'belanja.email', 'items.kode')
    ->get();
    return view('content.main', ['user' => $user, 'items' => $items, 'transactions' => $result->where('email',$user->email), 'belanja' => $belanja]);
    }
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
            $tujuan_upload = 'assets/img/items/';
            $file_name = $kode.'.'.$file->getClientOriginalExtension();
            $image =Image::make($file)
            ->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->orientate()
            ->encode($file->getClientOriginalExtension(), 40);
            $path = $tujuan_upload.$file_name;
            $image->save(public_path($path));
            // $path = $file->move($tujuan_upload,$file_name);
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
        return redirect()->route('items');

    }

    public function delete(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $itemToDelete = Items::whereRaw('email = ? AND kode = ?', [$request->confirmedEmail, $request->confirmedKode])->first();
        $itemToDelete->delete();
        return redirect()->route('items');
    }

    public function editView(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $item = Items::whereRaw('email = ? AND kode = ?', [$request->email, $request->kode])->first();
        $user = auth()->user();
        return view('content.items.edit', ['user' => $user, 'item' => $item]);
    }

    public function update(Request $request) {
        $item = Items::whereRaw('email = ? AND kode = ?', [$request->email, $request->kode])->first();
        if (!auth()->user()) return redirect()->route('index');
        $user = auth()->user();
        $kode = Items::where('email','=',$user->email)->count();

        if (!$request->hasFile('file')) {
            $path = $request->foto;
        } else {
            $file = $request->file('file');
            $tujuan_upload = 'assets/img/items/';
            $file_name = $kode.'.'.$file->getClientOriginalExtension();
            $image =Image::make($file)
            ->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->orientate()
            ->encode($file->getClientOriginalExtension(), 40);
            $path = $tujuan_upload.$file_name;
            $image->save(public_path($path));
            // $path = $file->move($tujuan_upload,$file_name);
        }
        if ($item) {
            $item->update([
                'foto' => $path,
                'nama' => $request->nama_brg,
                'desk' => $request->desk_brg,
                'kategori' => $request->kategori_brg,
                'stok' => $request->stok_brg,
                'harga_awal' => $request->hrg_awl_brg,
                'harga_jual' => $request->hrg_jual_brg,
            ]);
            $item->save();
            return redirect()->route('items');
        } else {
            return redirect()->route('items');
        }

    }

}
