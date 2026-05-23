@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">Data Transaksi</h5>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Tambah Transaksi
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
                                    <h6 class="fw-semibold mb-0">Kode Transaksi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Pengguna</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Metode Pembayaran</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tanggal</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="badge bg-primary rounded-3 fw-semibold">
                                        <i class="ti ti-receipt me-1"></i> {{ $item->kode_transaksi }}
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-user text-muted"></i>
                                        <p class="mb-0 fw-normal">{{ $item->pengguna->username ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="badge {{ $item->metode_pembayaran == 'cash' ? 'bg-success' : 'bg-info' }} rounded-3 fw-semibold">
                                        <i class="ti ti-{{ $item->metode_pembayaran == 'cash' ? 'wallet' : 'credit-card' }} me-1"></i>
                                        {{ ucfirst($item->metode_pembayaran) }}
                                    </span>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-calendar text-muted"></i>
                                        <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y H:i') }}</p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('transaksi.show', $item->id_transaksi) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Detail">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('transaksi.edit', $item->id_transaksi) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('transaksi.destroy', $item->id_transaksi) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus" 
                                                    onclick="return confirm('Yakin ingin menghapus transaksi {{ $item->kode_transaksi }}?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                        {{-- <a href="{{ route('transaksi.invoice', $item->id_transaksi) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Cetak Invoice">
                                            <i class="ti ti-printer"></i>
                                        </a> --}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ti ti-shopping-cart-off fs-1 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Belum ada data transaksi</p>
                                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm mt-2">Tambah Transaksi Sekarang</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($transaksi, 'links'))
                    <div class="d-flex justify-content-end mt-4">
                        {{ $transaksi->links() }}
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