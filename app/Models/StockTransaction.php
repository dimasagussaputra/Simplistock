<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model {
    protected $fillable = [
        'product_id', 'user_id', 'type', 'quantity', 'note'
    ];

    // Relasi: transaksi belongs to produk
    public function product() {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    // Relasi: transaksi belongs to user
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
