<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) abort(403, 'Akses ditolak.');

        $deletedProducts = Product::onlyTrashed()->with('category')->latest()->get();
        $deletedCategories = Category::onlyTrashed()->latest()->get();

        return view('trash.index', compact('deletedProducts', 'deletedCategories'));
    }
}
