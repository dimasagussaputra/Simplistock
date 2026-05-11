@extends('layouts.app')
@section('title', 'Detail Kategori')
@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-decoration-none">Kategori</a></li>
        <li class="breadcrumb-item active">Detail Kategori</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold text-dark"><i class='bi bi-tag me-2'></i> Detail Kategori</h4>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 fw-bold text-primary">Informasi Kategori</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="row g-4">
                    {{-- Nama Kategori --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light h-100">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Nama Kategori</small>
                            <span class="fs-5 fw-semibold">{{ $category->name }}</span>
                        </div>
                    </div>
                    
                    {{-- Status --}}
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light h-100">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Status</small>
                            <span class="badge bg-success px-3 py-2 rounded-pill mt-1">Aktif</span>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-12">
                        <div class="p-3 border rounded-3 bg-light">
                            <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Deskripsi Kategori</small>
                            <p class="mb-0 text-secondary">{{ $category->description ?: 'Tidak ada deskripsi yang tersedia untuk kategori ini.' }}</p>
                        </div>
                    </div>

                    {{-- Metadata --}}
                    <div class="col-md-6">
                        <div class="p-2 px-3 border-start border-4 border-primary bg-white">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Dibuat Pada</small>
                            <span class="text-dark small fw-medium">{{ $category->created_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 px-3 border-start border-4 border-warning bg-white">
                            <small class="text-muted d-block" style="font-size: 0.75rem;">Terakhir Diupdate</small>
                            <span class="text-dark small fw-medium">{{ $category->updated_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-light p-4 border-top-0 d-flex gap-3">
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning px-4 py-2 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i> Edit Kategori
                </a>
                
                <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-outline-danger px-4 py-2 fw-bold"
                        data-confirm="Kategori &ldquo;<strong>{{ $category->name }}</strong>&rdquo; akan dihapus. Anda bisa memulihkannya di Data Terhapus."
                        data-confirm-title="Hapus Kategori"
                        data-confirm-ok="Hapus"
                        data-confirm-type="danger"
                        data-confirm-icon="bi-trash3-fill">
                        <i class="bi bi-trash me-2"></i> Hapus Kategori
                    </button>
                </form>
            </div>
        </div>

        {{-- DAFTAR PRODUK DALAM KATEGORI INI --}}
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">Produk dalam Kategori ini</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th class="text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->products as $product)
                                <tr>
                                    <td class="px-4 fw-medium">{{ $product->name }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $product->stock <= 3 ? 'bg-danger' : 'bg-success' }}">
                                            {{ $product->stock }} unit
                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted italic">
                                        Belum ada produk dalam kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
