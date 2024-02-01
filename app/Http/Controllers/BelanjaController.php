<?php

namespace App\Http\Controllers;

use App\Models\Items;
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
            ->select('belanja.qty', 'belanja.created_at', 'items.foto', 'items.nama', 'items.desk', 'items.kategori','items.stok', 'items.harga_awal', 'items.harga_jual', 'belanja.email', 'items.kode')
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
}
