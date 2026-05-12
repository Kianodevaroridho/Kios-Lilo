<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Laporan Penjualan Harian
     */
    public function daily(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $transactions = Transaction::with(['user', 'details.product'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total');
        $totalTransactions = $transactions->count();

        return view('laporan.harian', compact('transactions', 'totalRevenue', 'totalTransactions', 'date'));
    }

    /**
     * Laporan Penjualan Bulanan
     */
    public function monthly(Request $request)
    {
        $month = $request->month ?: date('m');
        $year = $request->year ?: date('Y');
        
        $date = Carbon::createFromDate($year, $month, 1);

        // Ringkasan Bulanan
        $transactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $totalRevenue = $transactions->sum('total');
        $totalTransactions = $transactions->count();

        // Produk Terlaris Bulan Ini
        $bestSellingProducts = TransactionDetail::select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_amount'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Data Grafik Penjualan Harian di Bulan tersebut
        $dailySales = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->get();

        return view('laporan.bulanan', compact(
            'totalRevenue', 
            'totalTransactions', 
            'bestSellingProducts', 
            'dailySales', 
            'date'
        ));
    }
}
