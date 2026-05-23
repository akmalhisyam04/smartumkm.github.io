@extends('layouts.app')

@section('title', 'Pergerakan Stok')

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Kartu Statistik --}}
        <div class="row">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card overflow-hidden border-0 shadow-sm" style="transition: transform 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">
                                        <i class="ti ti-package me-1"></i> Total Produk
                                    </p>
                                    <h3 class="fw-bold mb-0">{{ $totalProduk ?? 0 }}</h3>
                                    <small class="text-success mt-2 d-inline-block">
                                        <i class="ti ti-trending-up"></i> +{{ number_format(($totalProduk ?? 0) * 0.12, 0) }}
                                    </small>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 55px; height: 55px; background: linear-gradient(135deg, #3b82f6, #1e40af);">
                                    <i class="ti ti-package fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card overflow-hidden border-0 shadow-sm" style="transition: transform 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">
                                        <i class="ti ti-arrow-down me-1"></i> Stok Masuk
                                    </p>
                                    <h3 class="fw-bold mb-0">{{ number_format($totalStokMasuk ?? 0) }}</h3>
                                    <small class="text-success mt-2 d-inline-block">
                                        <i class="ti ti-trending-up"></i> Bulan ini
                                    </small>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 55px; height: 55px; background: linear-gradient(135deg, #22c55e, #15803d);">
                                    <i class="ti ti-arrow-down fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card overflow-hidden border-0 shadow-sm" style="transition: transform 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">
                                        <i class="ti ti-arrow-up me-1"></i> Stok Keluar
                                    </p>
                                    <h3 class="fw-bold mb-0">{{ number_format($totalStokKeluar ?? 0) }}</h3>
                                    <small class="text-warning mt-2 d-inline-block">
                                        <i class="ti ti-trending-down"></i> Bulan ini
                                    </small>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 55px; height: 55px; background: linear-gradient(135deg, #f59e0b, #b45309);">
                                    <i class="ti ti-arrow-up fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-warning" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="card overflow-hidden border-0 shadow-sm" style="transition: transform 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">
                                        <i class="ti ti-alert-triangle me-1"></i> Stok Menipis
                                    </p>
                                    <h3 class="fw-bold mb-0 {{ ($produkStokMenipis ?? 0) > 0 ? 'text-danger' : '' }}">
                                        {{ $produkStokMenipis ?? 0 }}
                                    </h3>
                                    <small class="text-danger mt-2 d-inline-block">
                                        <i class="ti ti-alert-circle"></i> Perlu perhatian
                                    </small>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 55px; height: 55px; background: linear-gradient(135deg, #ef4444, #991b1b);">
                                    <i class="ti ti-alert-triangle fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-danger" style="width: {{ ($produkStokMenipis ?? 0) > 0 ? '100' : '20' }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

        {{-- Alert Stok Menipis --}}
        @if(($produkStokMenipis ?? 0) > 0 && isset($produkMenipisList))
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            <i class="ti ti-alert-circle me-2"></i>
            <strong>Perhatian!</strong> Terdapat {{ $produkStokMenipis }} produk dengan stok menipis (≤ 5):
            @foreach($produkMenipisList as $item)
                <span class="badge bg-danger ms-1">{{ $item->nama_produk }} ({{ $item->stok }})</span>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Card Utama --}}
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                    <h5 class="card-title fw-semibold mb-0">Pergerakan Stok</h5>
                </div>

                {{-- Filter dan Pencarian --}}
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <label class="text-muted small">Tampilkan:</label>
                        <select id="perPageSelect" class="form-select form-select-sm" style="width: 70px;">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span class="text-muted small">data</span>
                    </div>

                    <form action="{{ route('stok.index') }}" method="GET" class="mx-auto" style="min-width: 350px; max-width: 500px;">
                        <div class="input-group">
                            <span class="input-group-text bg-white" style="padding: 5px 15px;">
                                <i class="ti ti-search fs-5"></i>
                            </span>
                            <input type="text" 
                                name="search" 
                                class="form-control py-2" 
                                style="font-size: 15px; height: 35px;"
                                placeholder="Cari produk..." 
                                value="{{ request('search') }}">
                            <select name="jenis" class="form-select" style="width: 140px; height: 35px; font-size: 14px;">
                                <option value="">Semua Jenis</option>
                                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>📥 Stok Masuk</option>
                                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>📤 Stok Keluar</option>
                            </select>
                            <button class="btn btn-primary px-4" type="submit" style="height: 35px; font-size: 14px;">
                                <i class="ti ti-filter me-2"></i> Filter
                            </button>
                            @if(request('search') || request('jenis'))
                                <a href="{{ route('stok.index') }}" class="btn btn-outline-danger px-3" style="height: 35px;">
                                    <i class="ti ti-x fs-5"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    <a href="{{ route('stok.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Data
                    </a>

                    <div></div> {{-- Spacer untuk keseimbangan --}}
                </div>

                {{-- Info Total Data --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted small">
                        <i class="ti ti-info-circle me-1"></i>
                        Menampilkan <strong>{{ $stok->firstItem() ?? 0 }}</strong> - <strong>{{ $stok->lastItem() ?? 0 }}</strong> 
                        dari <strong>{{ $stok->total() }}</strong> data
                    </div>
                    @if(request('search') || request('jenis'))
                        <div class="text-muted small">
                            <i class="ti ti-filter me-1"></i>
                            Filter aktif
                        </div>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0" width="5%">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Produk</h6>
                                </th>
                                <th class="border-bottom-0" width="10%">
                                    <h6 class="fw-semibold mb-0">Jenis</h6>
                                </th>
                                <th class="border-bottom-0" width="10%">
                                    <h6 class="fw-semibold mb-0">Jumlah</h6>
                                </th>
                                <th class="border-bottom-0" width="10%">
                                    <h6 class="fw-semibold mb-0">Stok Akhir</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Keterangan</h6>
                                </th>
                                <th class="border-bottom-0" width="15%">
                                    <h6 class="fw-semibold mb-0">Tanggal</h6>
                                </th>
                                <th class="border-bottom-0" width="10%">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stok as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration + ($stok->currentPage() - 1) * $stok->perPage() }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-package text-muted"></i>
                                        <p class="mb-0 fw-normal">
                                            <a href="{{ route('stok.show', $item->id_stok) }}" class="text-decoration-none">
                                                {{ $item->produk->nama_produk ?? '-' }}
                                            </a>
                                        </p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    @if($item->jenis == 'masuk')
                                        <span class="badge bg-success rounded-3 fw-semibold">
                                            <i class="ti ti-arrow-down me-1"></i> Masuk
                                        </span>
                                    @elseif($item->jenis == 'keluar')
                                        <span class="badge bg-danger rounded-3 fw-semibold">
                                            <i class="ti ti-arrow-up me-1"></i> Keluar
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-3 fw-semibold">
                                            {{ $item->jenis }}
                                        </span>
                                    @endif
                                </td>
                                <td class="border-bottom-0">
                                    <span class="fw-semibold {{ $item->jenis == 'masuk' ? 'text-success' : 'text-danger' }}">
                                        {{ $item->jenis == 'masuk' ? '+' : '-' }} {{ number_format($item->jumlah) }}
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="badge bg-primary rounded-3 fw-semibold">
                                        <i class="ti ti-box me-1"></i> {{ number_format($item->stok_sesudah ?? $item->stok_akhir ?? $item->produk->stok ?? 0) }}
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $item->keterangan ?? '-' }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-calendar text-muted"></i>
                                        <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</p>
                                    </div>
                                    {{-- <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small> --}}
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('stok.edit', $item->id_stok) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('stok.destroy', $item->id_stok) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus" 
                                                    onclick="return confirm('Yakin ingin menghapus data pergerakan stok ini?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ti ti-box-off fs-1 text-muted mb-3"></i>
                                        <h6 class="text-muted mb-2">Tidak ada data pergerakan stok</h6>
                                        <p class="text-muted small mb-3">
                                            @if(request('search') || request('jenis'))
                                                Tidak ditemukan data dengan filter yang dipilih
                                            @else
                                                Silakan tambah pergerakan stok terlebih dahulu
                                            @endif
                                        </p>
                                        @if(request('search') || request('jenis'))
                                            <a href="{{ route('stok.index') }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-refresh me-1"></i> Hapus Filter
                                            </a>
                                        @else
                                            <a href="{{ route('stok.create') }}" class="btn btn-primary btn-sm">
                                                <i class="ti ti-plus me-1"></i> Tambah Data Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($stok, 'links') && $stok->total() > 0)
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                        <div class="text-muted small">
                            <i class="ti ti-database me-1"></i>
                            Halaman {{ $stok->currentPage() }} dari {{ $stok->lastPage() }}
                        </div>
                        <div>
                            {{ $stok->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Auto-submit when per page dropdown changes
    document.getElementById('perPageSelect')?.addEventListener('change', function() {
        var url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    });
</script>
@endpush