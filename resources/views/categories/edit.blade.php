@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<h4><i class='bi bi-pencil'></i> Edit Kategori</h4>
@if($errors->any())
    <div class='alert alert-danger'><ul class='mb-0'>
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul></div>
@endif
<div class='card mt-3'><div class='card-body'>
    <form method='POST' action='{{ route("categories.update", $category->id) }}'>
        @csrf @method('PUT')
        <div class='mb-3'>
            <label class='form-label fw-bold'>Nama Kategori *</label>
            <input type='text' name='name' class='form-control' value='{{ old('name', $category->name) }}' required>
        </div>
        <div class='mb-3'>
            <label class='form-label fw-bold'>Deskripsi</label>
            <textarea name='description' class='form-control' rows='3'>{{ old('description', $category->description) }}</textarea>
        </div>
        <div class='d-flex gap-2'>
            <button type='submit' class='btn btn-warning'>Update</button>
            <a href='{{ route("categories.index") }}' class='btn btn-secondary'>Batal</a>
        </div>
    </form>
</div></div>
@endsection
