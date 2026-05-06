@extends('layouts.app')
@section('title', 'Data Terhapus')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-3'>
    <h4><i class='bi bi-trash3'></i> Data Terhapus</h4>
</div>

<ul class="nav nav-tabs mb-3" id="trashTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="true"><i class='bi bi-box'></i> Produk Terhapus</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="category-tab" data-bs-toggle="tab" data-bs-target="#category" type="button" role="tab" aria-controls="category" aria-selected="false"><i class='bi bi-tags'></i> Kategori Terhapus</button>
  </li>
</ul>

<div class="tab-content" id="trashTabsContent">
  <!-- TAB PRODUK -->
  <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
    <div class='card'>
        <div class='card-body p-0'>
        <table class='table table-hover table-bordered mb-0'>
            <thead class='table-danger'>
                <tr><th>No</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($deletedProducts as $i => $p)
                <tr class="table-secondary">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td><span class='badge bg-info text-dark'>{{ $p->category->name ?? '-' }}</span></td>
                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>
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
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan='5'>
                        <div class='text-center py-5'>
                            <i class='bi bi-box-seam text-muted' style='font-size:3rem;'></i>
                            <p class='text-muted mt-2 mb-0'>Tidak ada produk yang terhapus.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
  </div>

  <!-- TAB KATEGORI -->
  <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
    <div class='card'>
        <div class='card-body p-0'>
        <table class='table table-hover table-bordered mb-0'>
            <thead class='table-danger'>
                <tr>
                    <th>No</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($deletedCategories as $i => $cat)
                <tr class="table-secondary">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->description ?? '-' }}</td>
                    <td>
                        <form method='POST' action='{{ route("categories.restore", $cat->id) }}' class='d-inline'>
                            @csrf @method('PATCH')
                            <button class='btn btn-sm btn-success'>Pulihkan</button>
                        </form>
                        <form method='POST' action='{{ route("categories.forceDelete", $cat->id) }}' class='d-inline'>
                            @csrf @method('DELETE')
                            <button type='button' class='btn btn-sm btn-danger'
                                data-confirm='Kategori &ldquo;<strong>{{ $cat->name }}</strong>&rdquo; akan dihapus secara permanen dan <u>tidak dapat dipulihkan</u>.'
                                data-confirm-title='Hapus Permanen'
                                data-confirm-ok='Hapus Permanen'
                                data-confirm-type='danger'
                                data-confirm-icon='bi-trash3-fill'>Hapus Permanen</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan='4'>
                        <div class='text-center py-5'>
                            <i class='bi bi-tags text-muted' style='font-size:3rem;'></i>
                            <p class='text-muted mt-2 mb-0'>Tidak ada kategori yang terhapus.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
  </div>
</div>
@endsection
