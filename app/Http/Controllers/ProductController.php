<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller {

    // READ: Tampilkan semua produk dengan fitur pencarian
    public function index(Request $request) {
        $query = Product::with('category')->withTrashed();
        // FITUR PENCARIAN
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
        $products = $query->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // CREATE: Form tambah produk
    public function create() {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // STORE: Simpan produk baru
    public function store(Request $request) {
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
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // UPDATE: Simpan perubahan produk
    public function update(Request $request, Product $product) {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|max:200',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil diubah!');
    }

    // SOFT DELETE: Arsipkan produk
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil diarsipkan!');
    }

    // RESTORE: Pulihkan produk dari soft delete
    public function restore($id) {
        Product::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dipulihkan!');
    }

    // HARD DELETE: Hapus produk secara permanen
    public function forceDelete($id) {
        Product::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus permanen!');
    }
}
