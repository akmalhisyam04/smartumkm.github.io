@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4 no-print">
                    <h5 class="card-title fw-semibold mb-0">Laporan Penjualan</h5>
                    <div class="d-flex gap-2">
                        <button type="button" id="btnPrint" class="btn btn-secondary" onclick="window.print()">
                            <i class="ti ti-printer me-1"></i> Cetak Laporan
                        </button>
                        <a href="{{ route('laporan.export.excel') }}" class="btn btn-success">
                            Export Excel
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                        <i class="ti ti-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Filter Tanggal --}}
                <div class="row mb-4 no-print">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" id="dari_tanggal" class="form-control" value="{{ date('Y-m-01') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" id="sampai_tanggal" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <button type="button" id="btnFilter" class="btn btn-primary d-block">
                            <i class="ti ti-filter me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <button type="button" id="btnReset" class="btn btn-outline-secondary d-block">
                            <i class="ti ti-refresh me-1"></i> Reset
                        </button>
                    </div>
                </div>

                {{-- Ringkasan (hanya tampil di layar, tidak saat print) --}}
                <div class="row mb-4 no-print">
                    <div class="col-md-4">
                        <div class="card bg-light-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-currency-dollar fs-1 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Total Pendapatan</h6>
                                        <h4 class="mb-0 fw-semibold" id="totalPendapatan">Rp 0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-shopping-cart fs-1 text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Total Transaksi</h6>
                                        <h4 class="mb-0 fw-semibold" id="totalTransaksi">0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-box fs-1 text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="text-muted mb-1">Rata-rata per Transaksi</h6>
                                        <h4 class="mb-0 fw-semibold" id="rataRata">Rp 0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Header Laporan untuk Print --}}
                <div class="print-header text-center" style="display: none;">
                    <h2>{{ config('app.name', 'SmartUMKM') }}</h2>
                    <h4>Laporan Penjualan</h4>
                    <p>Periode: <span id="printPeriode"></span></p>
                    <hr>
                </div>

                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle" id="laporanTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tanggal Laporan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total Penjualan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Jumlah Penjualan</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="laporanBody">
                            @forelse($laporan as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="ti ti-calendar text-muted no-print"></i>
                                        <p class="mb-0 fw-normal">{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d/m/Y') }}</p>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    {{ number_format($item->jumlah_penjualan) }} transaksi
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ti ti-file-report fs-1 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Belum ada data laporan</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer untuk Print (opsional) --}}
                <div class="print-footer text-center" style="display: none;">
                    <hr>
                    <small>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</small>
                </div>

                @if(method_exists($laporan, 'links'))
                    <div class="d-flex justify-content-end mt-4 no-print">
                        {{ $laporan->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style media="print">
    /* Sembunyikan elemen yang tidak perlu saat print */
    .no-print {
        display: none !important;
    }
    
    /* Sembunyikan sidebar dan navbar dari layout app */
    .left-sidebar,
    .app-header,
    .sidebar-nav,
    .brand-logo,
    .unlimited-access,
    .py-6,
    footer,
    .sidebartoggler,
    .page-wrapper > .left-sidebar,
    .body-wrapper > .app-header {
        display: none !important;
    }
    
    /* Atur ulang margin dan padding untuk print */
    .page-wrapper,
    .body-wrapper,
    .container-fluid,
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Tampilkan header dan footer print */
    .print-header,
    .print-footer {
        display: block !important;
    }
    
    /* Atur ulang margin body */
    body {
        margin: 0;
        padding: 0;
        font-size: 12pt;
    }
    
    /* Style card agar tidak terlihat seperti card */
    .card {
        border: none !important;
        box-shadow: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .card-body {
        padding: 0 !important;
    }
    
    /* Style tabel untuk print */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    
    .table th,
    .table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    
    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    
    /* Sembunyikan icon dan badge */
    .ti,
    .badge {
        display: none !important;
    }
    
    /* Warna teks hitam untuk print */
    .text-success,
    .text-primary,
    .text-warning,
    .text-danger,
    .text-muted {
        color: #000 !important;
    }
    
    /* Pastikan tidak ada background warna berlebih */
    .bg-light-primary,
    .bg-light-success,
    .bg-light-warning,
    .bg-primary,
    .bg-success,
    .bg-warning {
        background: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Format Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // Update summary
    function updateSummary(data) {
        let totalPendapatan = 0;
        let totalTransaksi = 0;
        
        data.forEach(item => {
            totalPendapatan += item.total_penjualan;
            totalTransaksi += item.jumlah_penjualan;
        });
        
        const rataRata = totalTransaksi > 0 ? totalPendapatan / totalTransaksi : 0;
        
        document.getElementById('totalPendapatan').innerHTML = formatRupiah(totalPendapatan);
        document.getElementById('totalTransaksi').innerHTML = totalTransaksi.toLocaleString();
        document.getElementById('rataRata').innerHTML = formatRupiah(rataRata);
    }

    // Filter functionality
    document.getElementById('btnFilter')?.addEventListener('click', function() {
        const dariTanggal = document.getElementById('dari_tanggal').value;
        const sampaiTanggal = document.getElementById('sampai_tanggal').value;
        
        if (dariTanggal && sampaiTanggal) {
            window.location.href = "{{ route('laporan.index') }}?dari=" + dariTanggal + "&sampai=" + sampaiTanggal;
        }
    });

    document.getElementById('btnReset')?.addEventListener('click', function() {
        window.location.href = "{{ route('laporan.index') }}";
    });

    // Update periode print saat filter digunakan
    function updatePrintPeriode() {
        const dari = document.getElementById('dari_tanggal').value;
        const sampai = document.getElementById('sampai_tanggal').value;
        const printPeriode = document.getElementById('printPeriode');
        if (printPeriode && dari && sampai) {
            printPeriode.textContent = formatTanggal(dari) + ' - ' + formatTanggal(sampai);
        }
    }
    
    function formatTanggal(dateString) {
        const parts = dateString.split('-');
        if (parts.length === 3) {
            return parts[2] + '/' + parts[1] + '/' + parts[0];
        }
        return dateString;
    }
    
    // Set periode awal
    updatePrintPeriode();
    
    // Update periode saat filter berubah
    document.getElementById('dari_tanggal')?.addEventListener('change', updatePrintPeriode);
    document.getElementById('sampai_tanggal')?.addEventListener('change', updatePrintPeriode);

    // Calculate summary from current table data
    const currentData = @json($laporan->map(function($item) {
        return [
            'total_penjualan' => $item->total_penjualan,
            'jumlah_penjualan' => $item->jumlah_penjualan
        ];
    }));
    updateSummary(currentData);
</script>
@endpush