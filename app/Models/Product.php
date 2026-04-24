<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'stock'
    ];

    // Relasi: produk belongs to kategori
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Relasi: produk memiliki banyak transaksi stok
    public function transactions() {
        return $this->hasMany(StockTransaction::class);
    }
}
