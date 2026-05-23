@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Tambah Kategori</h5>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
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

                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" 
                                        value="{{ old('nama_kategori') }}" placeholder="Masukkan nama kategori" required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nama kategori harus unik dan tidak boleh sama dengan kategori lain.</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Preview</label>
                                <div class="p-3 bg-light rounded">
                                    <span class="badge bg-info rounded-3 fw-semibold">
                                        <i class="ti ti-category me-1"></i>
                                        <span id="previewKategori">Nama Kategori</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-danger">
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
    // Live preview nama kategori
    const namaKategoriInput = document.querySelector('input[name="nama_kategori"]');
    const previewSpan = document.getElementById('previewKategori');
    
    if (namaKategoriInput && previewSpan) {
        namaKategoriInput.addEventListener('input', function() {
            const value = this.value.trim();
            if (value === '') {
                previewSpan.textContent = 'Nama Kategori';
            } else {
                previewSpan.textContent = value;
            }
        });
    }
</script>
@endpush