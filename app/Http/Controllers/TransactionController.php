<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    public function riwayat(Request $request) {
        if (!auth()->guard('web')->check() && !auth()->guard('member')->check()) {
            return redirect()->route('login');
        }
        $user = auth()->guard('web')->check() ? auth()->guard('web')->user() : auth()->guard('member')->user();
        $period = $request->query('period', 'default_value_if_not_provided');
        $items = Items::where('email', $user->root)->get();
        $result = DB::table('transactions')
            ->join('items', 'transactions.id_brg', '=', 'items.kode')
            ->select('transactions.qty','transactions.host', 'transactions.created_at', 'items.foto', 'items.nama', 'items.desk', 'items.kategori','items.stok', 'items.harga_awal', 'items.harga_jual', 'transactions.email', 'items.kode')
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
        return view('content.transaksi.catat', ['user'=>$user, 'transactions' => $filteredResults->where('email', $user->root), 'periode' => $periode, 'items' => $items]);
    }

    public function riwayatBy($period) {
        if (!auth()->guard('web')->check() && !auth()->guard('member')->check()) {
            return redirect()->route('login');
        }
        $user = auth()->guard('web')->check() ? auth()->guard('web')->user() : auth()->guard('member')->user();
        $result = DB::table('transactions')
            ->join('items', 'transactions.id_brg', '=', 'items.kode')
            ->select('transactions.qty', 'transactions.created_at', 'items.*')
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
                    return Carbon::parse($item->created_at)->isLastWeek();
                });
                $periode = 'Minggu ini';
                break;

            case 'month':
                $filteredResults = $result->filter(function ($item) {
                    return Carbon::parse($item->created_at)->isThisMonth();
                });
                $periode = 'Bulan ini';
                break;

            default:
                $filteredResults = $result;
                $periode = '';
                break;
        }
        echo $period;
        //return view('content.transaksi.catat', ['user'=>$user, 'transactions' => $filteredResults->where('email', $user->root), 'periode' => $periode]);
    }

    public function add(Request $request) {
        if (!auth()->guard('web')->check() && !auth()->guard('member')->check()) {
            return redirect()->route('login');
        }
        $user = auth()->guard('web')->check() ? auth()->guard('web')->user() : auth()->guard('member')->user();
        $items = $request->input('transactionItems');
        foreach ($items as $item) {
            $itemToUpdate = Items::whereRaw('kode = ? AND email = ?', [$item['kode'], $user->root])->first();
            if ($item['count'] > $itemToUpdate->stok) {
                return response()->json(['success' => false,
                    'message' => 'Terdapat stok barang yang kurang: '.$item['kode'].' '.Items::whereRaw('kode = ? AND email = ?', [$item['kode'], $user->root])->first()->nama,
                ]);
            } else {
                if ($item['count'] > 0) {
                    Transaction::create([
                        'id_brg' => $item['kode'],
                        'qty' => $item['count'],
                        'email' => $user->root,
                        'created_at' => now(),
                        'host' => $user->email,
                    ]);
                    $itemToUpdate->update([
                        'stok' => $itemToUpdate->stok - $item['count'],
                    ]);
                    $itemToUpdate->save();
                }
            }
        }
        return response()->json(['success'=> true, 'items' => $items]);
    }
}
