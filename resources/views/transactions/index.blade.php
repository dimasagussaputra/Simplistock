@extends('layouts.app')
@section('title', 'Transaksi Stok')
@section('content')
<div class='d-flex justify-content-between align-items-center mb-3'>
    <h4><i class='bi bi-arrow-left-right'></i> Transaksi Stok</h4>
    <a href='{{ route("transactions.create") }}' class='btn btn-primary'>
        <i class='bi bi-plus-circle'></i> Tambah Transaksi
    </a>
</div>

{{-- FORM PENCARIAN --}}
<form method='GET' class='mb-3 d-flex gap-2'>
    <input type='text' name='search' class='form-control w-50'
           placeholder='Cari produk, kategori, user...' value='{{ request('search') }}'>
    <button class='btn btn-outline-secondary'>Cari</button>
    <a href='{{ route("transactions.index") }}' class='btn btn-outline-danger'>Reset</a>
</form>

<div class='card'><div class='card-body p-0'>
    <table class='table table-hover mb-0'>
        <thead class='table-primary'>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Stok Saat Ini</th>
                <th>Oleh User</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($transactions as $i => $t)
            <tr>
                <td>{{ $transactions->firstItem() + $i }}</td>
                <td>{{ \Carbon\Carbon::parse($t->created_at)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $t->product_name }}</strong></td>
                <td><span class='badge bg-info text-dark'>{{ $t->category_name }}</span></td>
                <td>
                    @if($t->type === 'masuk')
                        <span class='badge bg-success'><i class='bi bi-arrow-down-circle'></i> Masuk</span>
                    @else
                        <span class='badge bg-danger'><i class='bi bi-arrow-up-circle'></i> Keluar</span>
                    @endif
                </td>
                <td>{{ $t->quantity }} unit</td>
                <td>{{ $t->current_stock }} unit</td>
                <td>{{ $t->user_name }}</td>
                <td>{{ $t->note ?? '-' }}</td>
                <td>
                    @if(auth()->user()->isAdmin())
                    <form method='POST' action='{{ route("transactions.destroy", $t->id) }}' class='d-inline'>
                        @csrf @method('DELETE')
                        <button type='button' class='btn btn-sm btn-danger'
                            data-confirm='Transaksi pada produk &ldquo;<strong>{{ $t->product_name }}</strong>&rdquo; akan dihapus secara permanen.'
                            data-confirm-title='Hapus Transaksi'
                            data-confirm-ok='Hapus'
                            data-confirm-type='danger'
                            data-confirm-icon='bi-trash3-fill'>Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan='10'>
                    <div class='text-center py-5'>
                        <i class='bi bi-arrow-left-right text-muted' style='font-size:3rem;'></i>
                        <p class='text-muted mt-2 mb-3'>Belum ada transaksi yang tercatat.</p>
                        <a href='{{ route("transactions.create") }}' class='btn btn-primary btn-sm'>
                            <i class='bi bi-plus-circle me-1'></i>Catat Transaksi Pertama
                        </a>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div></div>
{{ $transactions->links() }}
@endsection
