@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Tambah Kategori</li>
    </ol>
</nav>

<h4><i class='bi bi-plus-circle'></i> Tambah Kategori</h4>

<div class='card mt-3'><div class='card-body'>
    <form method='POST' action='{{ route("categories.store") }}' id='categoryForm'>
        @csrf
        <div class='mb-3'>
            <label class='form-label fw-bold'>Nama Kategori *</label>
            <input type='text' name='name' id='name'
                   class='form-control @error("name") is-invalid @enderror'
                   value='{{ old("name") }}' required>
            @error('name')
                <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>
        <div class='mb-3'>
            <label class='form-label fw-bold'>Deskripsi</label>
            <textarea name='description' id='description'
                      class='form-control @error("description") is-invalid @enderror'
                      rows='3'>{{ old('description') }}</textarea>
            @error('description')
                <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>
        <div class='d-flex gap-2'>
            <button type='submit' class='btn btn-primary' id='submitBtn'>
                <i class='bi bi-save me-1'></i>Simpan
            </button>
            <a href='{{ route("categories.index") }}' class='btn btn-secondary' id='cancelBtn'>
                <i class='bi bi-x-circle me-1'></i>Batal
            </a>
        </div>
    </form>
</div></div>

@push('scripts')
<script>
document.getElementById('categoryForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';
});

let formDirty = false;
document.querySelectorAll('#categoryForm input, #categoryForm textarea')
    .forEach(el => el.addEventListener('input', () => formDirty = true));
document.getElementById('categoryForm').addEventListener('submit', () => formDirty = false);
document.getElementById('cancelBtn').addEventListener('click', function(e) {
    if (formDirty && !confirm('Data yang Anda isi belum disimpan. Yakin ingin keluar?')) {
        e.preventDefault();
    }
});
</script>
@endpush

@endsection
