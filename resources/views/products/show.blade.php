@extends('layouts.app')
@section('title', 'Detail Produk')
@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Produk</a></li>
        <li class="breadcrumb-item active">Detail Produk</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold text-dark"><i class='bi bi-box-seam me-2'></i> Detail Produk</h4>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 fw-bold text-primary">Informasi Produk</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="row g-4">
                    {{-- Nama Produk --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light h-100">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Nama Produk</small>
                            <span class="fs-5 fw-semibold">{{ $product->name }}</span>
                        </div>
                    </div>
                    
                    {{-- Kategori --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light h-100">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Kategori</small>
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">{{ $product->category->name ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light h-100">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Harga Satuan</small>
                            <span class="fs-4 fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Stok --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light h-100">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Persediaan Stok</small>
                            <div class="d-flex align-items-center mt-1">
                                <span class="fs-4 fw-bold me-2">{{ $product->stock }} <small class="text-muted fw-normal">unit</small></span>
                                <span class="badge {{ $product->stock <= 3 ? 'bg-danger' : 'bg-success' }} px-3 py-2">
                                    {{ $product->stock <= 3 ? 'Stok Rendah' : 'Tersedia' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-12">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Deskripsi Produk</small>
                            <p class="mb-0 text-secondary">{{ $product->description ?: 'Tidak ada deskripsi yang tersedia untuk produk ini.' }}</p>
                        </div>
                    </div>

                    {{-- Metadata --}}
                    <div class="col-md-6">
                        <div class="p-2 px-3 border-start border-4 border-primary bg-white">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Input Data</small>
                            <span class="text-dark small fw-medium">{{ $product->created_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 px-3 border-start border-4 border-warning bg-white">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Terakhir Diupdate</small>
                            <span class="text-dark small fw-medium">{{ $product->updated_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->isAdmin())
            <div class="card-footer bg-light p-4 border-top-0 d-flex gap-3">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning px-4 py-2 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i> Edit Produk
                </a>
                
                <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-outline-danger px-4 py-2 fw-bold"
                        data-confirm="Produk &ldquo;<strong>{{ $product->name }}</strong>&rdquo; akan dihapus. Anda bisa memulihkannya di Data Terhapus."
                        data-confirm-title="Hapus Produk"
                        data-confirm-ok="Hapus"
                        data-confirm-type="danger"
                        data-confirm-icon="bi-trash3-fill">
                        <i class="bi bi-trash me-2"></i> Hapus Produk
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
