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
    <div class='card-body p-0'>
    <table class='table table-hover mb-0'>
        <thead class='table-primary'>
            <tr>
                <th>#</th><th>Nama</th><th>Deskripsi</th><th>Status</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $i => $cat)
            <tr class='{{ $cat->deleted_at ? "table-secondary" : "" }}'>
                <td>{{ $categories->firstItem() + $i }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->description ?? '-' }}</td>
                <td>
                    @if($cat->deleted_at)
                        <span class='badge bg-secondary'>Diarsipkan</span>
                    @else
                        <span class='badge bg-success'>Aktif</span>
                    @endif
                </td>
                <td>
                    @if($cat->deleted_at)
                        {{-- RESTORE: Pulihkan dari soft delete --}}
                        <form method='POST' action='{{ route("categories.restore", $cat->id) }}' class='d-inline'>
                            @csrf @method('PATCH')
                            <button class='btn btn-sm btn-success'>Pulihkan</button>
                        </form>
                        {{-- HARD DELETE: Hapus permanen --}}
                        <form method='POST' action='{{ route("categories.forceDelete", $cat->id) }}' class='d-inline'
                              onsubmit='return confirm("Hapus permanen? Data tidak bisa dipulihkan!")'>
                            @csrf @method('DELETE')
                            <button class='btn btn-sm btn-danger'>Hapus Permanen</button>
                        </form>
                    @else
                        <a href='{{ route("categories.edit", $cat->id) }}' class='btn btn-sm btn-warning'>Ubah</a>
                        {{-- SOFT DELETE --}}
                        <form method='POST' action='{{ route("categories.destroy", $cat->id) }}' class='d-inline'
                              onsubmit='return confirm("Arsipkan kategori ini?")'>
                            @csrf @method('DELETE')
                            <button class='btn btn-sm btn-secondary'>Arsipkan</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan='5' class='text-center py-3'>Tidak ada data kategori.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
{{ $categories->links() }}
@endsection
