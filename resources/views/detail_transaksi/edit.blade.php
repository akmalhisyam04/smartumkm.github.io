@extends('layouts.app')

@section('title', 'Edit Detail Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Edit Detail Transaksi</h5>
                    <a href="{{ route('detail-transaksi.index') }}" class="btn btn-secondary">
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

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('detail-transaksi.update', $detail->id_detail) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Transaksi <span class="text-danger">*</span></label>
                                <select name="transaksi_id" class="form-select @error('transaksi_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Transaksi --</option>
                                    @foreach($transaksi as $t)
                                        <option value="{{ $t->id_transaksi }}" 
                                            {{ old('transaksi_id', $detail->transaksi_id) == $t->id_transaksi ? 'selected' : '' }}>
                                            {{ $t->kode_transaksi }} ({{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('transaksi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Produk <span class="text-danger">*</span></label>
                                <select name="produk_id" id="produk_id" class="form-select @error('produk_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($produk as $p)
                                        <option value="{{ $p->id_produk }}" 
                                            data-harga="{{ $p->harga_jual }}"
                                            data-stok="{{ $p->stok }}"
                                            {{ old('produk_id', $detail->produk_id) == $p->id_produk ? 'selected' : '' }}>
                                            {{ $p->nama_produk }} - Stok: {{ $p->stok }} - Rp {{ number_format($p->harga_jual, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('produk_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" 
                                       value="{{ old('jumlah', $detail->jumlah) }}" required min="1" step="1">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" 
                                           value="{{ old('harga', $detail->harga) }}" required>
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subtotal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="subtotal" id="subtotal" class="form-control" 
                                           value="{{ old('subtotal', $detail->subtotal) }}" readonly style="background-color: #f8f9fa;">
                                </div>
                                <div class="form-text">Subtotal akan dihitung otomatis (Jumlah x Harga)</div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sisa Stok</label>
                                <div class="p-2 bg-light rounded">
                                    <span id="sisaStok" class="fw-semibold">-</span>
                                </div>
                                <div class="form-text text-warning">Stok awal: <span id="stokAwal">-</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Pastikan jumlah yang diinput tidak melebihi stok yang tersedia.
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-device-floppy me-1"></i> Update
                        </button>
                        <a href="{{ route('detail-transaksi.index') }}" class="btn btn-danger">
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
    const hargaInput = document.getElementById('harga');
    const jumlahInput = document.getElementById('jumlah');
    const subtotalInput = document.getElementById('subtotal');
    const sisaStokSpan = document.getElementById('sisaStok');
    const stokAwalSpan = document.getElementById('stokAwal');

    function hitungSubtotal() {
        const harga = parseFloat(hargaInput.value) || 0;
        const jumlah = parseFloat(jumlahInput.value) || 0;
        const subtotal = harga * jumlah;
        subtotalInput.value = subtotal;
    }

    function updateStokInfo() {
        const selectedOption = produkSelect.options[produkSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
            stokAwalSpan.textContent = stok;
            sisaStokSpan.textContent = stok;
            sisaStokSpan.className = stok <= 5 ? 'fw-semibold text-danger' : 'fw-semibold text-success';
        } else {
            stokAwalSpan.textContent = '-';
            sisaStokSpan.textContent = '-';
            sisaStokSpan.className = 'fw-semibold';
        }
    }

    function validateStock() {
        const selectedOption = produkSelect.options[produkSelect.selectedIndex];
        const stokTersedia = parseInt(selectedOption.getAttribute('data-stok')) || 0;
        const jumlahDiminta = parseInt(jumlahInput.value) || 0;
        
        if (jumlahDiminta > stokTersedia) {
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
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga') || 0;
        hargaInput.value = harga;
        hitungSubtotal();
        updateStokInfo();
        validateStock();
    });

    hargaInput.addEventListener('input', function() {
        hitungSubtotal();
    });

    jumlahInput.addEventListener('input', function() {
        hitungSubtotal();
        validateStock();
    });

    // Initial calculations
    if (produkSelect.value) {
        updateStokInfo();
        validateStock();
    }
</script>
@endpush