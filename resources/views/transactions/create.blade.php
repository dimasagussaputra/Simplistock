@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')

{{-- BREADCRUMB --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
        <li class="breadcrumb-item active">Tambah Transaksi</li>
    </ol>
</nav>

<h4><i class='bi bi-plus-circle'></i> Tambah Transaksi Stok</h4>

{{-- Error stok tidak cukup --}}
@if(session('error'))
    <div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>
        <i class='bi bi-exclamation-triangle-fill me-2'></i>{{ session('error') }}
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>
@endif

<div class='card mt-3'><div class='card-body'>
    <form method='POST' action='{{ route("transactions.store") }}' id='transactionForm'>
        @csrf
        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label class='form-label fw-bold'>Produk *</label>
                <select name='product_id' id='product_id'
                        class='form-select @error("product_id") is-invalid @enderror' required>
                    <option value=''>-- Pilih Produk --</option>
                    @foreach($products as $prod)
                        <option value='{{ $prod->id }}'
                                {{ old('product_id') == $prod->id ? 'selected' : '' }}
                                data-stock='{{ $prod->stock }}'>
                            {{ $prod->name }} (Stok: {{ $prod->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
                {{-- Info stok saat ini --}}
                <div id='stockInfo' class='form-text text-muted mt-1' style='display:none;'>
                    <i class='bi bi-info-circle'></i> Stok saat ini: <strong id='currentStock'></strong> unit
                </div>
            </div>
            <div class='col-md-3 mb-3'>
                <label class='form-label fw-bold'>Tipe Transaksi *</label>
                <select name='type' id='type'
                        class='form-select @error("type") is-invalid @enderror' required>
                    <option value='masuk' {{ old('type') == 'masuk' ? 'selected' : '' }}>📥 Stok Masuk</option>
                    <option value='keluar' {{ old('type') == 'keluar' ? 'selected' : '' }}>📤 Stok Keluar</option>
                </select>
                @error('type')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            <div class='col-md-3 mb-3'>
                <label class='form-label fw-bold'>Jumlah *</label>
                <input type='number' name='quantity' id='quantity'
                       class='form-control @error("quantity") is-invalid @enderror'
                       value='{{ old("quantity") }}' min='1' required>
                @error('quantity')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            <div class='col-12 mb-3'>
                <label class='form-label fw-bold'>Catatan</label>
                <textarea name='note' id='note'
                          class='form-control @error("note") is-invalid @enderror'
                          rows='2' placeholder='Opsional...'>{{ old('note') }}</textarea>
                @error('note')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class='d-flex gap-2'>
            <button type='submit' class='btn btn-primary' id='submitBtn'>
                <i class='bi bi-save me-1'></i>Simpan Transaksi
            </button>
            <a href='{{ route("transactions.index") }}' class='btn btn-secondary' id='cancelBtn'>
                <i class='bi bi-x-circle me-1'></i>Batal
            </a>
        </div>
    </form>
</div></div>

@push('scripts')
<script>
// Tampilkan info stok saat produk dipilih
const productSelect = document.getElementById('product_id');
const stockInfo     = document.getElementById('stockInfo');
const currentStock  = document.getElementById('currentStock');

productSelect.addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (opt.value) {
        currentStock.textContent = opt.dataset.stock;
        stockInfo.style.display = 'block';
    } else {
        stockInfo.style.display = 'none';
    }
});

// Trigger saat page load (jika ada old value)
if (productSelect.value) productSelect.dispatchEvent(new Event('change'));

// Loading state saat submit
document.getElementById('transactionForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';
});

// Peringatan meninggalkan form yang sudah diisi
let formDirty = false;
document.querySelectorAll('#transactionForm input, #transactionForm select, #transactionForm textarea')
    .forEach(el => el.addEventListener('change', () => formDirty = true));
document.getElementById('transactionForm').addEventListener('submit', () => formDirty = false);
document.getElementById('cancelBtn').addEventListener('click', function(e) {
    if (formDirty && !confirm('Data yang Anda isi belum disimpan. Yakin ingin keluar?')) {
        e.preventDefault();
    }
});
</script>
@endpush

@endsection
