@extends('layouts.app')
@section('title', 'Manajemen Kategori')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-3'>
    <h4><i class='bi bi-tags'></i> Manajemen Kategori</h4>
    <a href='{{ route("categories.create") }}' class='btn btn-primary'>
        <i class='bi bi-plus-circle'></i> Tambah Kategori
    </a>
</div>

{{-- FORM PENCARIAN --}}
<form method='GET' class='mb-3 d-flex gap-2'>
    <input type='text' name='search' class='form-control w-25' placeholder='Cari kategori...'
           value='{{ request('search') }}'>
    <button class='btn btn-outline-secondary'>Cari</button>
    <a href='{{ route("categories.index") }}' class='btn btn-outline-danger'>Reset</a>
</form>

<div class='card'>
    <div class='card-body p-0 table-responsive'>
    <table class='table table-hover table-bordered mb-0'>
        <thead class='table-primary'>
            <tr>
                <th>No</th><th>Nama</th><th>Deskripsi</th><th>Status</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $i => $cat)
            <tr>
                <td>{{ $categories->firstItem() + $i }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->description ?? '-' }}</td>
                <td>
                    <span class='badge bg-success'>Aktif</span>
                </td>
                <td>
                    <a href='{{ route("categories.edit", $cat->id) }}' class='btn btn-sm btn-warning'>Edit</a>
                    {{-- SOFT DELETE --}}
                    <form method='POST' action='{{ route("categories.destroy", $cat->id) }}' class='d-inline'>
                        @csrf @method('DELETE')
                        <button type='button' class='btn btn-sm btn-danger'
                            data-confirm='Kategori &ldquo;<strong>{{ $cat->name }}</strong>&rdquo; akan dihapus. Anda bisa memulihkannya di Data Terhapus.'
                            data-confirm-title='Hapus Kategori'
                            data-confirm-ok='Hapus'
                            data-confirm-type='danger'
                            data-confirm-icon='bi-trash3-fill'>Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan='5'>
                    <div class='text-center py-5'>
                        <i class='bi bi-tags text-muted' style='font-size:3rem;'></i>
                        <p class='text-muted mt-2 mb-3'>Belum ada kategori yang ditemukan.</p>
                        <a href='{{ route("categories.create") }}' class='btn btn-primary btn-sm'>
                            <i class='bi bi-plus-circle me-1'></i>Tambah Kategori Pertama
                        </a>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
{{ $categories->links('vendor.pagination.modern') }}
@endsection
