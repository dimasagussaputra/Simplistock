@extends('layouts.app')
@section('title', 'Manajemen Produk')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-3'>
    <h4><i class='bi bi-box'></i> Manajemen Produk</h4>
    @if(auth()->user()->isAdmin())
    <a href='{{ route("products.create") }}' class='btn btn-primary'>
        <i class='bi bi-plus-circle'></i> Tambah Produk
    </a>
    @endif
</div>

{{-- FORM PENCARIAN --}}
<form method='GET' class='mb-3 d-flex gap-2'>
    <input type='text' name='search' class='form-control w-50'
           placeholder='Cari nama produk atau kategori...' value='{{ request('search') }}'>
    <button class='btn btn-outline-secondary'>Cari</button>
    <a href='{{ route("products.index") }}' class='btn btn-outline-danger'>Reset</a>
</form>

<div class='card'><div class='card-body p-0'>
    <table class='table table-hover table-bordered mb-0'>
        <thead class='table-primary'>
            <tr><th>No</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        @forelse($products as $i => $p)
            <tr>
                <td>{{ $products->firstItem() + $i }}</td>
                <td>{{ $p->name }}</td>
                <td><span class='badge bg-info text-dark'>{{ $p->category->name ?? '-' }}</span></td>
                <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                <td>
                    <span class='badge {{ $p->stock <= 3 ? "bg-danger" : "bg-success" }}'>
                        {{ $p->stock }} unit
                    </span>
                </td>
                <td>
                    <span class='badge bg-success'>Aktif</span>
                </td>
                <td>
                    @if(auth()->user()->isAdmin())
                        <a href='{{ route("products.edit", $p->id) }}' class='btn btn-sm btn-warning'>Edit</a>
                        <form method='POST' action='{{ route("products.destroy", $p->id) }}' class='d-inline'>
                            @csrf @method('DELETE')
                            <button type='button' class='btn btn-sm btn-danger'
                                data-confirm='Produk &ldquo;<strong>{{ $p->name }}</strong>&rdquo; akan dihapus. Anda bisa memulihkannya di Data Terhapus.'
                                data-confirm-title='Hapus Produk'
                                data-confirm-ok='Hapus'
                                data-confirm-type='danger'
                                data-confirm-icon='bi-trash3-fill'>Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan='7'>
                    <div class='text-center py-5'>
                        <i class='bi bi-box-seam text-muted' style='font-size:3rem;'></i>
                        <p class='text-muted mt-2 mb-3'>Belum ada produk yang ditemukan.</p>
                        @if(auth()->user()->isAdmin())
                        <a href='{{ route("products.create") }}' class='btn btn-primary btn-sm'>
                            <i class='bi bi-plus-circle me-1'></i>Tambah Produk Pertama
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div></div>
{{ $products->links('vendor.pagination.modern') }}
@endsection
