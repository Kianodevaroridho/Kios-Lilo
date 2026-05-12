<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Tampilkan daftar stok produk.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter stok menipis (default < 10 atau sesuai input)
        if ($request->has('status') && $request->status == 'low') {
            $query->where('stock', '<=', 10);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(10);
        return view('stok.index', compact('products'));
    }

    /**
     * Proses restock produk secara manual.
     */
    public function restock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->find($request->product_id);
                $stockBefore = $product->stock;
                $stockAfter = $stockBefore + $request->qty;

                // Update Stok Produk
                $product->increment('stock', $request->qty);

                // Catat Log
                StockLog::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'in',
                    'qty' => $request->qty,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'description' => $request->description ?? 'Restock manual',
                ]);

                return redirect()->back()->with('success', "Stok produk '{$product->name}' berhasil ditambah.");
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Gagal menambah stok: " . $e->getMessage());
        }
    }

    /**
     * Tampilkan riwayat perubahan stok.
     */
    public function logs(Request $request)
    {
        $query = StockLog::with(['product', 'user']);

        if ($request->has('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $logs = $query->latest()->paginate(20);
        return view('stok.logs', compact('logs'));
    }
}
