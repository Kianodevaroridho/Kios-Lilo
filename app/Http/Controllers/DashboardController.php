<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats
        $today = Carbon::today();
        $transactionsToday = Transaction::whereDate('created_at', $today)->get();
        $totalRevenueToday = $transactionsToday->sum('total');
        $totalTransactionsToday = $transactionsToday->count();
        
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 10)->count();

        // 2. Chart Data (Last 7 Days)
        $salesData = [];
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Transaction::whereDate('created_at', $date)->sum('total');
            $salesData[] = $revenue;
            $days[] = $date->isoFormat('ddd'); // Sen, Sel, etc.
        }

        // 3. Top Products (This Month)
        $topProducts = TransactionDetail::select('product_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_amount'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // 4. Recent Transactions
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRevenueToday',
            'totalTransactionsToday',
            'totalProducts',
            'lowStockCount',
            'salesData',
            'days',
            'topProducts',
            'recentTransactions'
        ));
    }
}
