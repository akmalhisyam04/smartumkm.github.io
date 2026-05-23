@extends('layouts.app')

@section('title', 'Data Produk')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Data Produk</h5>
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                        {{-- Kiri: Dropdown Show Per Page --}}
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small" style="white-space: nowrap;">Tampilkan:</label>
                            <select id="perPageSelect" class="form-select form-select-sm" style="width: 70px;">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                            </select>
                            <span class="text-muted small">data</span>
                        </div>

                        {{-- Tengah: Form Pencarian --}}
                        <form action="{{ route('produk.index') }}" method="GET" id="searchForm" class="mx-auto" style="min-width: 350px; max-width: 500px;">
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="padding: 10px 15px;">
                                    <i class="ti ti-search fs-5"></i>
                                </span>
                                <input type="text" 
                                    name="search" 
                                    id="searchInput"
                                    class="form-control py-2" 
                                    style="font-size: 15px;"
                                    placeholder="Cari produk atau kategori..." 
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary px-4 py-2" type="submit" id="searchBtn" style="font-size: 14px;">
                                    <i class="ti ti-search me-1"></i> Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('produk.index') }}" class="btn btn-outline-danger px-3 py-2" id="resetBtn">
                                        <i class="ti ti-x fs-5"></i>
                                    </a>
                                @endif
                            </div>
                        </form>

                        {{-- Kanan: Tombol Tambah Produk --}}
                        <a href="{{ route('produk.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Tambah Produk
                        </a>
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

                <!-- Info Total Data -->
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div class="text-muted small">
                        <i class="ti ti-info-circle me-1"></i>
                        Menampilkan {{ $produk->firstItem() ?? 0 }} - {{ $produk->lastItem() ?? 0 }} 
                        dari total <strong>{{ $produk->total() }}</strong> data
                    </div>
                    <div class="text-muted small">
                        <i class="ti ti-package me-1"></i>
                        Total Produk: <strong>{{ $produk->total() }}</strong>
                        @if(request('search'))
                            <span class="text-primary ms-2">
                                <i class="ti ti-filter"></i> Hasil pencarian: "{{ request('search') }}"
                            </span>
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0" width="5%">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Produk</h6>
                                </th>
                                <th class="border-bottom-0" width="15%">
                                    <h6 class="fw-semibold mb-0">Kategori</h6>
                                </th>
                                <th class="border-bottom-0" width="15%">
                                    <h6 class="fw-semibold mb-0">Harga Jual</h6>
                                </th>
                                <th class="border-bottom-0" width="10%">
                                    <h6 class="fw-semibold mb-0">Stok</h6>
                                </th>
                                <th class="border-bottom-0" width="15%">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration + ($produk->currentPage() - 1) * $produk->perPage() }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary rounded-3 p-2">
                                            <i class="ti ti-package text-white fs-6"></i>
                                        </span>
                                        <p class="mb-0 fw-normal">{{ $item->nama_produk }}</p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="badge bg-info rounded-3 fw-semibold">
                                        <i class="ti ti-category me-1"></i>
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold text-success">
                                        Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    @php
                                        $stokClass = $item->stok <= 0 ? 'bg-danger' : ($item->stok <= 5 ? 'bg-warning text-dark' : 'bg-success');
                                    @endphp
                                    <span class="badge {{ $stokClass }} rounded-3 fw-semibold">
                                        <i class="ti ti-box me-1"></i>
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus" 
                                                    onclick="return confirm('Yakin ingin menghapus produk {{ $item->nama_produk }}?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ti ti-package-off fs-1 text-muted mb-3"></i>
                                        <h6 class="text-muted mb-2">Tidak ada data produk</h6>
                                        <p class="text-muted small mb-3">
                                            @if(request('search'))
                                                Tidak ditemukan produk dengan kata kunci "{{ request('search') }}"
                                            @else
                                                Silakan tambahkan produk terlebih dahulu
                                            @endif
                                        </p>
                                        @if(request('search'))
                                            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-refresh me-1"></i> Hapus Filter
                                            </a>
                                        @else
                                            <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
                                                <i class="ti ti-plus me-1"></i> Tambah Produk Sekarang
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination dengan Info -->
                @if($produk->total() > 0)
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                    <div class="text-muted small">
                        <i class="ti ti-info-circle me-1"></i>
                        Menampilkan <strong>{{ $produk->firstItem() }}</strong> - <strong>{{ $produk->lastItem() }}</strong> 
                        dari <strong>{{ $produk->total() }}</strong> data
                    </div>
                    
                    <div>
                        @if ($produk->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mb-0">
                                    {{-- Tombol Previous --}}
                                    @if ($produk->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">« Sebelumnya</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $produk->previousPageUrl() }}" rel="prev">
                                                « Sebelumnya
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Nomor Halaman --}}
                                    @php
                                        $currentPage = $produk->currentPage();
                                        $lastPage = $produk->lastPage();
                                        $start = max(1, $currentPage - 2);
                                        $end = min($lastPage, $currentPage + 2);
                                    @endphp
                                    
                                    @if ($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $produk->url(1) }}">1</a>
                                        </li>
                                        @if ($start > 2)
                                            <li class="page-item disabled"><span class="page-link">...</span></li>
                                        @endif
                                    @endif
                                    
                                    @for ($i = $start; $i <= $end; $i++)
                                        @if ($i == $currentPage)
                                            <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $produk->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endif
                                    @endfor
                                    
                                    @if ($end < $lastPage)
                                        @if ($end < $lastPage - 1)
                                            <li class="page-item disabled"><span class="page-link">...</span></li>
                                        @endif
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $produk->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    {{-- Tombol Next --}}
                                    @if ($produk->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $produk->nextPageUrl() }}" rel="next">
                                                Selanjutnya »
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Selanjutnya »</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                    
                    <div class="text-muted small">
                        <i class="ti ti-database me-1"></i>
                        Halaman <strong>{{ $produk->currentPage() }}</strong> dari <strong>{{ $produk->lastPage() }}</strong>
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
    document.getElementById('perPageSelect').addEventListener('change', function() {
        var perPage = this.value;
        var currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('per_page', perPage);
        currentUrl.searchParams.set('page', 1); // Reset ke halaman pertama
        window.location.href = currentUrl.toString();
    });
    
    // Optional: Search with enter key sudah otomatis
    // Optional: Auto-search after typing (debounce) - uncomment if needed
    /*
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            document.getElementById('searchForm').submit();
        }, 500);
    });
    */
</script>
@endpush