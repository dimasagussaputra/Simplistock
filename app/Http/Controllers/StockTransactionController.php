<?php
namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller {

    // READ: Tampilkan transaksi dengan QUERY JOIN 3 TABEL
    // JOIN: stock_transactions + products + categories + users
    public function index(Request $request) {
        $query = DB::table('stock_transactions')
            ->join('products', 'stock_transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('users', 'stock_transactions.user_id', '=', 'users.id')
            ->select(
                'stock_transactions.id',
                'stock_transactions.type',
                'stock_transactions.quantity',
                'stock_transactions.note',
                'stock_transactions.created_at',
                'products.name as product_name',
                'products.stock as current_stock',
                'categories.name as category_name',
                'users.name as user_name'
            );
        // FITUR PENCARIAN
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('products.name', 'like', '%' . $request->search . '%')
                  ->orWhere('categories.name', 'like', '%' . $request->search . '%')
                  ->orWhere('users.name', 'like', '%' . $request->search . '%')
                  ->orWhere('stock_transactions.type', 'like', '%' . $request->search . '%');
            });
        }
        $transactions = $query->orderByDesc('stock_transactions.created_at')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    // CREATE: Form tambah transaksi
    public function create() {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    // STORE: Simpan transaksi + update stok produk
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:masuk,keluar',
            'quantity'   => 'required|integer|min:1',
            'note'       => 'nullable|max:500',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validasi stok tidak boleh minus
        if ($request->type === 'keluar' && $product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi! Stok saat ini: ' . $product->stock);
        }

        // Simpan transaksi
        StockTransaction::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(),
            'type'       => $request->type,
            'quantity'   => $request->quantity,
            'note'       => $request->note,
        ]);

        // Update stok produk
        if ($request->type === 'masuk') {
            $product->increment('stock', $request->quantity);
        } else {
            $product->decrement('stock', $request->quantity);
        }

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil dicatat!');
    }

    // HARD DELETE: Hapus transaksi
    public function destroy($id) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        StockTransaction::findOrFail($id)->delete();
        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil dihapus!');
    }
}
