<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Menampilkan riwayat transaksi.
     */
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(10);
        return view('transaksi.index', compact('transactions'));
    }

    /**
     * Menampilkan detail satu transaksi.
     */
    public function show(Transaction $transaksi)
    {
        $transaksi->load('details.product', 'user');
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Proses simpan transaksi (Checkout).
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment' => 'required|numeric|min:0',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $total = 0;
                $items = [];

                // 1. Validasi Stok dan Hitung Total
                foreach ($request->cart as $item) {
                    $product = Product::lockForUpdate()->find($item['id']);
                    
                    if ($product->stock < $item['qty']) {
                        throw new \Exception("Stok produk '{$product->name}' tidak mencukupi (Tersisa: {$product->stock})");
                    }

                    $subtotal = $product->price * $item['qty'];
                    $total += $subtotal;

                    $items[] = [
                        'product_id' => $product->id,
                        'qty' => $item['qty'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                        'product_model' => $product // Simpan model untuk update stok nanti
                    ];
                }

                if ($request->payment < $total) {
                    throw new \Exception("Uang pembayaran tidak cukup.");
                }

                // 2. Simpan Header Transaksi
                $transaction = Transaction::create([
                    'user_id' => auth()->id(),
                    'total' => $total,
                    'payment' => $request->payment,
                    'change' => $request->payment - $total,
                ]);

                // 3. Simpan Detail dan Update Stok
                foreach ($items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Kurangi Stok
                    $item['product_model']->decrement('stock', $item['qty']);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil disimpan!',
                    'data' => [
                        'transaction_id' => $transaction->id,
                        'total' => $total,
                        'change' => $transaction->change
                    ]
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
