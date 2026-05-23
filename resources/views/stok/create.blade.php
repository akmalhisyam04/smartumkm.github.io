@extends('layouts.app')

@section('title', 'Tambah Pergerakan Stok')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Tambah Pergerakan Stok</h5>
                    <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('stok.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Produk <span class="text-danger">*</span></label>
                                <select name="produk_id" id="produk_id" class="form-select @error('produk_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produk as $p)
                                        <option value="{{ $p->id_produk }}" 
                                            data-stok="{{ $p->stok }}"
                                            data-nama="{{ $p->nama_produk }}"
                                            {{ old('produk_id') == $p->id_produk ? 'selected' : '' }}>
                                            {{ $p->nama_produk }} - Stok Saat Ini: {{ number_format($p->stok) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('produk_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jenis <span class="text-danger">*</span></label>
                                <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="masuk" {{ old('jenis') == 'masuk' ? 'selected' : '' }}>📥 Masuk (Tambah Stok)</option>
                                    <option value="keluar" {{ old('jenis') == 'keluar' ? 'selected' : '' }}>📤 Keluar (Kurangi Stok)</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" 
                                       value="{{ old('jumlah', 1) }}" required min="1" step="1">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Masukkan jumlah stok yang akan ditambahkan/dikurangi.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Stok Saat Ini</label>
                                <div class="p-2 bg-light rounded">
                                    <span id="stokSaatIni" class="fw-semibold">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Stok Setelah Transaksi</label>
                                <div class="p-2 bg-light rounded" id="stokSetelahPanel">
                                    <span id="stokSetelah" class="fw-semibold text-primary">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                       value="{{ old('keterangan') }}" placeholder="Contoh: Pembelian dari supplier, retur, dll">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Informasi:</strong> 
                        <ul class="mb-0 mt-2">
                            <li><span class="badge bg-success">Masuk</span> - Menambah stok produk (pembelian, retur pembeli)</li>
                            <li><span class="badge bg-danger">Keluar</span> - Mengurangi stok produk (penjualan, rusak, kadaluarsa)</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                        <a href="{{ route('stok.index') }}" class="btn btn-danger">
                            <i class="ti ti-x me-1"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const produkSelect = document.getElementById('produk_id');
    const jenisSelect = document.getElementById('jenis');
    const jumlahInput = document.getElementById('jumlah');
    const stokSaatIniSpan = document.getElementById('stokSaatIni');
    const stokSetelahSpan = document.getElementById('stokSetelah');

    let currentStock = 0;

    function updateStokInfo() {
        const selectedOption = produkSelect.options[produkSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            currentStock = parseInt(selectedOption.getAttribute('data-stok')) || 0;
            stokSaatIniSpan.textContent = currentStock.toLocaleString();
            stokSaatIniSpan.className = currentStock <= 5 ? 'fw-semibold text-danger' : 'fw-semibold text-success';
        } else {
            currentStock = 0;
            stokSaatIniSpan.textContent = '-';
            stokSaatIniSpan.className = 'fw-semibold';
        }
        hitungStokSetelah();
    }

    function hitungStokSetelah() {
        const jumlah = parseInt(jumlahInput.value) || 0;
        const jenis = jenisSelect.value;
        
        let stokSetelah = currentStock;
        let warning = '';
        
        if (jenis === 'masuk') {
            stokSetelah = currentStock + jumlah;
            stokSetelahSpan.className = 'fw-semibold text-success';
        } else if (jenis === 'keluar') {
            stokSetelah = currentStock - jumlah;
            stokSetelahSpan.className = 'fw-semibold text-danger';
            
            if (stokSetelah < 0) {
                warning = ' (Peringatan: Stok akan menjadi negatif!)';
                stokSetelahSpan.className = 'fw-semibold text-danger fw-bold';
            } else if (stokSetelah <= 5) {
                warning = ' (Stok akan menipis!)';
            }
        } else {
            stokSetelahSpan.className = 'fw-semibold';
        }
        
        stokSetelahSpan.textContent = stokSetelah.toLocaleString() + warning;
        
        // Validate if stock becomes negative when jenis is keluar
        if (jenis === 'keluar' && stokSetelah < 0) {
            jumlahInput.classList.add('is-invalid');
            jumlahInput.setCustomValidity('Jumlah melebihi stok yang tersedia!');
            return false;
        } else {
            jumlahInput.classList.remove('is-invalid');
            jumlahInput.setCustomValidity('');
            return true;
        }
    }

    produkSelect.addEventListener('change', function() {
        updateStokInfo();
    });

    jenisSelect.addEventListener('change', function() {
        hitungStokSetelah();
    });

    jumlahInput.addEventListener('input', function() {
        hitungStokSetelah();
    });

    // Initial calculation
    updateStokInfo();
</script>
@endpush