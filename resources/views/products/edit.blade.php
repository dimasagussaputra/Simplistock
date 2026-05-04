@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
        <li class="breadcrumb-item active">Edit: {{ $product->name }}</li>
    </ol>
</nav>

<h4><i class='bi bi-pencil'></i> Edit Produk</h4>

<div class='card mt-3'><div class='card-body'>
    <form method='POST' action='{{ route("products.update", $product->id) }}' id='productForm'>
        @csrf @method('PUT')
        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Nama Produk *</label>
                <input type='text' name='name' id='name'
                       class='form-control @error("name") is-invalid @enderror'
                       value='{{ old("name", $product->name) }}' required>
                @error('name')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Kategori *</label>
                <select name='category_id' id='category_id'
                        class='form-select @error("category_id") is-invalid @enderror' required>
                    @foreach($categories as $cat)
                        <option value='{{ $cat->id }}'
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Harga (Rp) *</label>
                <input type='number' name='price' id='price'
                       class='form-control @error("price") is-invalid @enderror'
                       value='{{ old("price", $product->price) }}' min='0' required>
                @error('price')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Stok *</label>
                <input type='number' name='stock' id='stock'
                       class='form-control @error("stock") is-invalid @enderror'
                       value='{{ old("stock", $product->stock) }}' min='0' required>
                @error('stock')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            <div class='col-12 mb-3'>
                <label class='form-label fw-bold'>Deskripsi</label>
                <textarea name='description' id='description'
                          class='form-control @error("description") is-invalid @enderror'
                          rows='3'>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class='d-flex gap-2'>
            <button type='submit' class='btn btn-warning' id='submitBtn'>
                <i class='bi bi-save me-1'></i>Update
            </button>
            <a href='{{ route("products.index") }}' class='btn btn-secondary' id='cancelBtn'>
                <i class='bi bi-x-circle me-1'></i>Batal
            </a>
        </div>
    </form>
</div></div>

@push('scripts')
<script>
document.getElementById('productForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';
});

let formDirty = false;
document.querySelectorAll('#productForm input, #productForm select, #productForm textarea')
    .forEach(el => el.addEventListener('input', () => formDirty = true));
document.getElementById('productForm').addEventListener('submit', () => formDirty = false);
document.getElementById('cancelBtn').addEventListener('click', function(e) {
    if (formDirty && !confirm('Perubahan belum disimpan. Yakin ingin keluar?')) {
        e.preventDefault();
    }
});
</script>
@endpush

@endsection
