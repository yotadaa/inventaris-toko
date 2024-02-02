<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Belanja;
use App\Models\RencanaBelanja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BelanjaController extends Controller
{
    //
    public function index(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $period = $request->query('period', 'default_value_if_not_provided');
        $user = auth()->user();
        $items = Items::where('email', $user->email)->get();
        $result = DB::table('belanja')
            ->join('items', 'belanja.kode', '=', 'items.kode')
            ->select('belanja.qty', 'belanja.created_at','belanja.group', 'items.foto', 'items.nama', 'items.desk', 'items.kategori','items.stok', 'items.harga_awal', 'items.harga_jual', 'belanja.email', 'items.kode')
            ->get();
        switch ($period) {
            case 'day':
                $filteredResults = $result->filter(function ($item) {
                    return Carbon::parse($item->created_at)->isToday();
                });
                $periode = 'Hari ini';
                break;

            case 'week':
                $filteredResults = $result->filter(function ($item) {
                    return Carbon::parse($item->created_at)->isSameWeek(Carbon::now());
                });
                $periode = 'Minggu ini';
                break;

            case 'month':
                $filteredResults = $result->filter(function ($item) {
                    return Carbon::parse($item->created_at)->isSameMonth(Carbon::now());
                });
                $periode = 'Bulan ini';
                break;

            default:
                $filteredResults = $result;
                $periode = '';
                break;
        }
        return view('content.belanja.index', ['user'=>$user, 'belanja' => $filteredResults->where('email', $user->email), 'periode' => $periode, 'items' => $items]);
    }

    public function add(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $items = $request->input('transactionItems');
        $grup = Belanja::whereRaw('email = ?', [$user->email])->count('group')+1;
        foreach ($items as $item) {
            if ($item['count'] > 0) {
                Belanja::create([
                    'kode' => $item['kode'],
                    'qty' => $item['count'],
                    'email' => $user->email,
                    'created_at' => now(),
                    'group' => $grup
                ]);
            }
        }
        return response()->json(['success'=> true, 'items' => $items]);
    }

    public function test(Request $request) {
        return response()->json(['value' => $request->input('test')]);
    }

    public function rencana() {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $items = Items::where('email', $user->email)->get();
        $rencana = DB::table('table_rencana_belanja')
        ->join('items', 'table_rencana_belanja.kode', '=', 'items.kode')
        ->select('table_rencana_belanja.qty','table_rencana_belanja.checked','table_rencana_belanja.status', 'table_rencana_belanja.group','table_rencana_belanja.id','table_rencana_belanja.created_at', 'items.foto', 'items.nama', 'items.desk', 'items.kategori','items.stok', 'items.harga_awal', 'items.harga_jual', 'table_rencana_belanja.email', 'items.kode')
        ->get();
        return view('content.belanja.rencana', ['user' => $user, 'rencana' => $rencana, 'items'=>$items]);
    }

    public function addRencana(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $rencanaItem = $request->input('rencanaItem');
        $group = DB::table('table_rencana_belanja')->where('email', $user->email)->count()+1;
        foreach($rencanaItem as $item) {
            if ($item['qty'] > 0) {
                DB::table('table_rencana_belanja')->insert([
                    'group' => $group,
                    'kode' => $item['kode'],
                    'qty' => $item['qty'],
                    'email' => $user->email,
                    'created_at' => now(),
                    'status' => 0,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Berhasil mencatat rencana belanja!']);
    }

    public function submitRencana(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $kode = $request->input('kode');
        $itemsFromRencana = DB::table('table_rencana_belanja')->where('group', $kode)->get();
        $grup = DB::table('belanja')->whereRaw('email = ?', [$user->email])->count('group')+1;
        foreach($itemsFromRencana as $item) {
            DB::table('belanja')->insert([
                'group' => $grup,
                'kode' => $item->kode,
                'qty' => $item->qty,
                'email' => $user->email,
                'created_at'=>now(),
                'checked' => 0
            ]);
            $itemToUpdate = DB::table('items')->where('kode', $item->kode)->first();
            if ($itemToUpdate) {
            DB::table('items')
                ->where('kode', $item->kode)
                ->update([
                    'stok' => $itemToUpdate->stok + $item->qty,
                ]);
            }
        }

        DB::table('table_rencana_belanja')->where('group', $kode)->update([
            'status'=> 1,
        ]);

        return response()->json(['status' => true, 'message' => 'Berhasil mensubmit rencana']);
    }

    public function updateCheck(Request $request) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
        $item = DB::table('table_rencana_belanja')->whereRaw('email = ? AND id = ?', [$user->email, $request->input('id')])->first();
        if ($item) {
            DB::table('table_rencana_belanja')
                ->where('id', $item->id)
                ->update([
                    'checked' => !$item->checked
                ]);
        } else {
            return response()->json(['status' => false, 'message' => 'item tidak ditemukan']);
        }
        return response()->json(['status' => true, 'message' => 'berhasil mengubah status']);
    }
}