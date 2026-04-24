<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    // READ: Tampilkan semua kategori (termasuk filter pencarian)
    public function index(Request $request) {
        $query = Category::withTrashed(); // Tampilkan juga yang soft deleted
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $categories = $query->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    // CREATE: Tampilkan form tambah kategori
    public function create() {
        return view('categories.create');
    }

    // STORE: Simpan kategori baru ke database
    public function store(Request $request) {
        $request->validate([
            'name'        => 'required|unique:categories,name|max:100',
            'description' => 'nullable|max:500',
        ]);
        Category::create($request->only('name', 'description'));
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // UPDATE: Tampilkan form edit kategori
    public function edit(Category $category) {
        return view('categories.edit', compact('category'));
    }

    // UPDATE: Simpan perubahan kategori
    public function update(Request $request, Category $category) {
        $request->validate([
            'name'        => 'required|unique:categories,name,' . $category->id . '|max:100',
            'description' => 'nullable|max:500',
        ]);
        $category->update($request->only('name', 'description'));
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diubah!');
    }

    // SOFT DELETE: Hapus kategori secara soft delete
    public function destroy(Category $category) {
        $category->delete(); // Soft delete: mengisi kolom deleted_at
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diarsipkan (soft delete)!');
    }

    // RESTORE: Pulihkan kategori dari soft delete
    public function restore($id) {
        Category::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil dipulihkan!');
    }

    // HARD DELETE: Hapus kategori secara permanen
    public function forceDelete($id) {
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil dihapus permanen!');
    }
}