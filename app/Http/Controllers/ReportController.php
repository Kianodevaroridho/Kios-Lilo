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

        $transactions = Transaction::with(['user', 'details'])
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

    /**
     * Export daily report as CSV (Excel compatible)
     */
    public function dailyExcel(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();
        $transactions = Transaction::with(['user', 'details'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();
        $csvLines = [];
        $csvLines[] = ['Transaction ID', 'User', 'Total', 'Created At'];
        foreach ($transactions as $t) {
            $csvLines[] = [
                $t->id,
                $t->user ? $t->user->name : 'Admin',
                $t->total,
                $t->created_at->format('Y-m-d H:i:s')
            ];
        }
        $csvContent = '';
        foreach ($csvLines as $row) {
            $csvContent .= implode(",", $row) . "\n";
        }
        $filename = 'laporan_harian_' . $date->format('Y_m_d') . '.csv';
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    /**
     * Export monthly report as CSV (Excel compatible)
     */
    public function monthlyExcel(Request $request)
    {
        $month = $request->month ?: date('m');
        $year = $request->year ?: date('Y');
        $date = Carbon::createFromDate($year, $month, 1);
        // Transactions summary
        $transactions = Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();
        // Best selling products
        $bestSellingProducts = TransactionDetail::select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_amount'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();
        $csvLines = [];
        $csvLines[] = ['Month', $month, 'Year', $year];
        $csvLines[] = [];
        $csvLines[] = ['Transaction ID', 'User', 'Total', 'Created At'];
        foreach ($transactions as $t) {
            $csvLines[] = [
                $t->id,
                $t->user ? $t->user->name : 'Admin',
                $t->total,
                $t->created_at->format('Y-m-d H:i:s')
            ];
        }
        $csvLines[] = [];
        $csvLines[] = ['Best Selling Products'];
        $csvLines[] = ['Product ID', 'Name', 'Quantity Sold', 'Total Amount'];
        foreach ($bestSellingProducts as $p) {
            $csvLines[] = [
                $p->product_id,
                $p->product ? $p->product->name : 'Deleted',
                $p->total_qty,
                $p->total_amount
            ];
        }
        $csvContent = '';
        foreach ($csvLines as $row) {
            $csvContent .= implode(",", $row) . "\n";
        }
        $filename = 'laporan_bulanan_' . $year . '_' . $month . '.csv';
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}
