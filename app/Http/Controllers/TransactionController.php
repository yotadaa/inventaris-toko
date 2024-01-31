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
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $period = $request->query('period', 'default_value_if_not_provided');
        $user = auth()->user();
        $items = Items::where('email', $user->email)->get();
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
        return view('content.transaksi.catat', ['user'=>$user, 'transactions' => $filteredResults->where('email', $user->email), 'periode' => $periode, 'items' => $items]);
    }

    public function riwayatBy($period) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $user = auth()->user();
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
        //return view('content.transaksi.catat', ['user'=>$user, 'transactions' => $filteredResults->where('email', $user->email), 'periode' => $periode]);
    }
}
