@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')
<h4><i class='bi bi-plus-circle'></i> Tambah Transaksi Stok</h4>
<div class='card mt-3'><div class='card-body'>
    <form method='POST' action='{{ route("transactions.store") }}'>
        @csrf
        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Produk *</label>
                <select name='product_id' class='form-select' required>
                    <option value=''>-- Pilih Produk --</option>
                    @foreach($products as $prod)
                        <option value='{{ $prod->id }}'>
                            {{ $prod->name }} (Stok: {{ $prod->stock }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class='col-md-3 mb-3'>
                <label class='form-label fw-bold'>Tipe Transaksi *</label>
                <select name='type' class='form-select' required>
                    <option value='masuk'>Stok Masuk</option>
                    <option value='keluar'>Stok Keluar</option>
                </select>
            </div>
            <div class='col-md-3 mb-3'>
                <label class='form-label fw-bold'>Jumlah *</label>
                <input type='number' name='quantity' class='form-control' min='1' required>
            </div>
            <div class='col-12 mb-3'>
                <label class='form-label fw-bold'>Catatan</label>
                <textarea name='note' class='form-control' rows='2' placeholder='Opsional...'></textarea>
            </div>
        </div>
        <div class='d-flex gap-2'>
            <button type='submit' class='btn btn-primary'>Simpan Transaksi</button>
            <a href='{{ route("transactions.index") }}' class='btn btn-secondary'>Batal</a>
        </div>
    </form>
</div></div>
@endsection
