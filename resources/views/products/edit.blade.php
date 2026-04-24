@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<h4><i class='bi bi-pencil'></i> Edit Produk</h4>
@if($errors->any())
    <div class='alert alert-danger'><ul class='mb-0'>
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul></div>
@endif
<div class='card mt-3'><div class='card-body'>
    <form method='POST' action='{{ route("products.update", $product->id) }}'>
        @csrf @method('PUT')
        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Nama Produk *</label>
                <input type='text' name='name' class='form-control' value='{{ old('name', $product->name) }}' required>
            </div>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Kategori *</label>
                <select name='category_id' class='form-select' required>
                    @foreach($categories as $cat)
                        <option value='{{ $cat->id }}' {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Harga (Rp) *</label>
                <input type='number' name='price' class='form-control' value='{{ old('price', $product->price) }}' min='0' required>
            </div>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Stok *</label>
                <input type='number' name='stock' class='form-control' value='{{ old('stock', $product->stock) }}' min='0' required>
            </div>
            <div class='col-12 mb-3'>
                <label class='form-label fw-bold'>Deskripsi</label>
                <textarea name='description' class='form-control' rows='3'>{{ old('description', $product->description) }}</textarea>
            </div>
        </div>
        <div class='d-flex gap-2'>
            <button type='submit' class='btn btn-warning'>Update</button>
            <a href='{{ route("products.index") }}' class='btn btn-secondary'>Batal</a>
        </div>
    </form>
</div></div>
@endsection
