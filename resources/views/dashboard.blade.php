@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">

        {{-- TOTAL PRODUK --}}
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-box-seam fs-1 opacity-75"></i>
                    <div>
                        <div class="small text-white-50 fw-semibold">Total Produk</div>
                        <div class="fs-2 fw-bold">{{ $totalProduk }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-arrow-left-right fs-1 opacity-75"></i>
                    <div>
                        <div class="small text-white-50 fw-semibold">Total Transaksi</div>
                        <div class="fs-2 fw-bold">{{ $totalTransaksi }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL KATEGORI --}}
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <i class="bi bi-tags fs-1 opacity-75"></i>
                    <div>
                        <div class="small text-white-50 fw-semibold">Total Kategori</div>
                        <div class="fs-2 fw-bold">{{ $totalKategori }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        {{-- PRODUK STOK RENDAH --}}
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-danger text-white d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Stok Hampir Habis (≤ 3)</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStock as $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item->name }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $item->category->name ?? '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $item->stock }} unit</span>
                                    </td>
                                    <td>
                                        @if(auth()->user()->isAdmin())
                                        <a href="{{ route('products.edit', $item->id) }}"
                                           class="btn btn-xs btn-outline-warning py-0 px-2" style="font-size:0.75rem;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-check-circle-fill text-success fs-4 d-block mb-1"></i>
                                        Semua stok aman!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TRANSAKSI TERBARU --}}
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-info text-white d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history"></i>
                    <strong>Transaksi Terbaru</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Tipe</th>
                                <th class="text-center">Jumlah</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $t)
                                <tr>
                                    <td class="fw-semibold">{{ $t->product->name ?? '-' }}</td>
                                    <td>
                                        @if($t->type == 'masuk')
                                            <span class="badge bg-success"><i class="bi bi-arrow-down-circle"></i> Masuk</span>
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-arrow-up-circle"></i> Keluar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $t->quantity }} unit</td>
                                    <td class="text-muted small">
                                        {{ \Carbon\Carbon::parse($t->created_at)->timezone('Asia/Jakarta')->format('d/m H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($recentTransactions->count() > 0)
                <div class="card-footer text-end p-2">
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-info">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>

    </div>
@endsection