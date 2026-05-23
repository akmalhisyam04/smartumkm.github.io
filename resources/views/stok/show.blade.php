@extends('layouts.app')

@section('title', 'Detail Stok - ' . $produk->nama_produk)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="card-title fw-semibold mb-1">
                            <i class="ti ti-box me-2"></i> Detail Stok Produk
                        </h5>
                        <p class="text-muted mb-0">Histori pergerakan stok {{ $produk->nama_produk }}</p>
                    </div>
                    <div>
                        <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Info Produk --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted mb-1">Nama Produk</h6>
                                        <h4 class="mb-0">{{ $produk->nama_produk }}</h4>
                                    </div>
                                    <i class="ti ti-package fs-1 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6 class="text-white-50 mb-1">Kategori</h6>
                                <h4 class="mb-0">{{ $produk->kategori->nama_kategori ?? '-' }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card {{ $produk->stok <= 5 ? 'bg-danger' : 'bg-primary' }} text-white">
                            <div class="card-body">
                                <h6 class="text-white-50 mb-1">Stok Saat Ini</h6>
                                <h4 class="mb-0">{{ number_format($produk->stok) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Histori --}}
                <h6 class="fw-semibold mb-3">Histori Pergerakan Stok</h6>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Stok Sebelum</th>
                                <th>Stok Sesudah</th>
                                <th>Keterangan</th>
                                {{-- <th>Petugas</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historiStok as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if($item->jenis == 'masuk')
                                        <span class="badge bg-success">MASUK</span>
                                    @else
                                        <span class="badge bg-danger">KELUAR</span>
                                    @endif
                                </td>
                                <td class="{{ $item->jenis == 'masuk' ? 'text-success' : 'text-danger' }} fw-semibold">
                                    {{ $item->jenis == 'masuk' ? '+' : '-' }}{{ number_format($item->jumlah) }}
                                </td>
                                <td>{{ number_format($item->stok_sebelum) }}</td>
                                <td>{{ number_format($item->stok_sesudah) }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>{{ $item->created_by ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="ti ti-database-off fs-1 text-muted"></i>
                                    <p class="mt-2">Belum ada histori stok untuk produk ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $historiStok->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection