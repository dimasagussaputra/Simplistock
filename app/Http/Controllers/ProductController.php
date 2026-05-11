<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller {

    // READ: Tampilkan semua produk dengan fitur pencarian
    public function index(Request $request) {
        $query = Product::with('category');
        // FITUR PENCARIAN
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // FILTER STOK RENDAH
        if ($request->filter == 'low_stock') {
            $query->where('stock', '<=', 3);
        }
        $products = $query->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // CREATE: Form tambah produk
    public function create() {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // SHOW: Tampilkan detail produk
    public function show(Product $product) {
        return view('products.show', compact('product'));
    }

    // STORE: Simpan produk baru
    public function store(Request $request) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:200',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
        Product::create($request->all());
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    // EDIT: Form ubah produk
    public function edit(Product $product) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // UPDATE: Simpan perubahan produk
    public function update(Request $request, Product $product) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:200',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
        $product->update($request->all());
        
        $redirect = $request->from == 'dashboard' ? route('dashboard') : route('products.index');
        
        return redirect($redirect)
                         ->with('success', 'Produk berhasil diubah!');
    }

    // SOFT DELETE: Hapus produk
    public function destroy(Product $product) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        $product->delete();
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }

    // RESTORE: Pulihkan produk dari soft delete
    public function restore($id) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        Product::withTrashed()->findOrFail($id)->restore();
        return redirect()->back()
                         ->with('success', 'Produk berhasil dipulihkan!');
    }

    // HARD DELETE: Hapus produk secara permanen
    public function forceDelete($id) {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');
        Product::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()
                         ->with('success', 'Produk berhasil dihapus permanen!');
    }
}
