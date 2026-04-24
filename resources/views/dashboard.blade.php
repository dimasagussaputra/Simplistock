@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">

        {{-- TOTAL PRODUK --}}
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6>Total Produk</h6>
                    <h3>{{ \App\Models\Product::count() }}</h3>
                </div>
            </div>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6>Total Transaksi</h6>
                    <h3>{{ \App\Models\StockTransaction::count() }}</h3>
                </div>
            </div>
        </div>

        {{-- TOTAL KATEGORI --}}
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6>Total Kategori</h6>
                    <h3>{{ \App\Models\Category::count() }}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        {{-- PRODUK STOK RENDAH (<= 3) --}} <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <i class="bi bi-exclamation-triangle"></i> Stok Hampir Habis (≤ 3)
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $lowStock = \App\Models\Product::where('stock', '<=', 3)->get();
                            @endphp

                            @forelse($lowStock as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="badge bg-danger">{{ $item->stock }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada stok kritis</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
    </div>

    {{-- TRANSAKSI TERBARU --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="bi bi-clock-history"></i> Transaksi Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $transactions = \App\Models\StockTransaction::with('product')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp

                        @forelse($transactions as $t)
                            <tr>
                                <td>{{ $t->product->name ?? '-' }}</td>
                                <td>
                                    @if($t->type == 'masuk')
                                        <span class="badge bg-success">Masuk</span>
                                    @else
                                        <span class="badge bg-danger">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $t->quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>
@endsection