<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk    = Product::count();
        $totalTransaksi = StockTransaction::count();
        $totalKategori  = Category::count();

        // Produk dengan stok kritis (<= 3) yang masih aktif
        $lowStock = Product::where('stock', '<=', 3)
                           ->whereNull('deleted_at')
                           ->orderBy('stock')
                           ->get();

        // 5 transaksi terbaru
        $recentTransactions = StockTransaction::with('product')
                                              ->latest()
                                              ->take(5)
                                              ->get();

        return view('dashboard', compact(
            'totalProduk',
            'totalTransaksi',
            'totalKategori',
            'lowStock',
            'recentTransactions'
        ));
    }
}
