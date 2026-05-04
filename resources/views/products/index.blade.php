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
    <table class='table table-hover mb-0'>
        <thead class='table-primary'>
            <tr><th>#</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        @forelse($products as $i => $p)
            <tr class='{{ $p->deleted_at ? "table-secondary" : "" }}'>
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
                    @if($p->deleted_at)
                        <span class='badge bg-secondary'>Diarsipkan</span>
                    @else
                        <span class='badge bg-success'>Aktif</span>
                    @endif
                </td>
                <td>
                    @if(auth()->user()->isAdmin())
                    @if($p->deleted_at)
                        <form method='POST' action='{{ route("products.restore", $p->id) }}' class='d-inline'>
                            @csrf @method('PATCH')
                            <button class='btn btn-sm btn-success'>Pulihkan</button>
                        </form>
                        <form method='POST' action='{{ route("products.forceDelete", $p->id) }}' class='d-inline'>
                            @csrf @method('DELETE')
                            <button type='button' class='btn btn-sm btn-danger'
                                data-confirm='Produk &ldquo;<strong>{{ $p->name }}</strong>&rdquo; akan dihapus secara permanen dan <u>tidak dapat dipulihkan</u>.'
                                data-confirm-title='Hapus Permanen'
                                data-confirm-ok='Hapus Permanen'
                                data-confirm-type='danger'
                                data-confirm-icon='bi-trash3-fill'>Hapus Permanen</button>
                        </form>
                    @else
                        <a href='{{ route("products.edit", $p->id) }}' class='btn btn-sm btn-warning'>Ubah</a>
                        <form method='POST' action='{{ route("products.destroy", $p->id) }}' class='d-inline'>
                            @csrf @method('DELETE')
                            <button type='button' class='btn btn-sm btn-secondary'
                                data-confirm='Produk &ldquo;<strong>{{ $p->name }}</strong>&rdquo; akan diarsipkan. Anda bisa memulihkannya nanti.'
                                data-confirm-title='Arsipkan Produk'
                                data-confirm-ok='Arsipkan'
                                data-confirm-type='warning'
                                data-confirm-icon='bi-archive-fill'>Arsipkan</button>
                        </form>
                    @endif
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
{{ $products->links() }}
@endsection
