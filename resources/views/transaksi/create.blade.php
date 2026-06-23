@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Tambah Transaksi</h5>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kode Transaksi <span class="text-danger">*</span></label>
                                <input type="text" name="kode_transaksi" class="form-control @error('kode_transaksi') is-invalid @enderror" 
                                       value="{{ old('kode_transaksi') }}" placeholder="TRX/2025/001" required>
                                @error('kode_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Masukkan kode transaksi unik.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pengguna <span class="text-danger">*</span></label>
                                <select name="pengguna_id" class="form-select @error('pengguna_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pengguna --</option>
                                    @foreach($user as $u)
                                        <option value="{{ $u->id }}" {{ old('pengguna_id') == $u->id ? 'selected' : '' }}>
                                            {{ $u->username }} ({{ $u->role ?? 'Kasir' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('pengguna_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="total_harga" class="form-control @error('total_harga') is-invalid @enderror" 
                                            value="{{ old('total_harga') }}" placeholder="0" required min="0">
                                </div>
                                @error('total_harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select name="metode_pembayaran" class="form-select @error('metode_pembayaran') is-invalid @enderror" required>
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>💵 Cash (Tunai)</option>
                                    <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>🏦 Transfer Bank</option>
                                    <option value="e-wallet" {{ old('metode_pembayaran') == 'e-wallet' ? 'selected' : '' }}>📱 E-Wallet</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" 
                                        value="{{ old('tanggal_transaksi', date('Y-m-d')) }}" required>
                                @error('tanggal_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>❌ Batal</option>
                                </select>
                                <div class="form-text">Status transaksi (opsional).</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Informasi:</strong> Setelah transaksi disimpan, Anda dapat menambahkan detail produk yang dibeli.
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                        <a href="{{ route('transaksi.index') }}" class="btn btn-danger">
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
    // Auto-generate kode transaksi jika kosong
    const kodeInput = document.querySelector('input[name="kode_transaksi"]');
    if (kodeInput && kodeInput.value === '') {
        const date = new Date();
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        kodeInput.value = `TRX/${year}${month}${day}/${random}`;
    }
</script>
@endpush