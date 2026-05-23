@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <h5 class="card-title fw-semibold mb-0">Data Kategori</h5>
                        <div class="d-flex align-items-center gap-2">
                            <select id="perPageSelect" class="form-select form-select-sm" style="width: 70px;">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="text-muted small">/ page</span>
                        </div>
                    </div>
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Kategori
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

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Kategori</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Jumlah Produk</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-info rounded-3 fw-semibold">
                                            <i class="ti ti-category me-1"></i>
                                        </span>
                                        <p class="mb-0 fw-normal">{{ $item->nama_kategori }}</p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="badge bg-primary rounded-3 fw-semibold">
                                        {{ $item->produk_count ?? $item->produk->count() ?? 0 }} Produk
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus" 
                                                    onclick="return confirm('Yakin ingin menghapus kategori {{ $item->nama_kategori }}? Data produk dengan kategori ini juga akan terpengaruh.')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ti ti-category-off fs-1 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Belum ada data kategori</p>
                                        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm mt-2">Tambah Kategori Sekarang</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($kategori, 'links'))
                    <div class="d-flex justify-content-end mt-4">
                        {{ $kategori->links() }}
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
</script>
@endpush