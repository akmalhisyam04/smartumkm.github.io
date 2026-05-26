@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card overflow-hidden" style="background: linear-gradient(135deg, #eef4ff, #f8fbff);">
            <div class="card-body py-2 px-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1 mb-1" 
                                style="background-color: rgba(13, 110, 253, 0.12); font-size: 9px; font-weight: 600;">
                            <i class="ti ti-dashboard me-1"></i> DASHBOARD 
                        </span>
                        
                        <h1 class="fw-bold mb-1" 
                            style="font-size: 28px; line-height: 1.2; background: linear-gradient(135deg, #1e3a8a, #2563eb, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            Selamat Datang,<br>
                            <span style="background: linear-gradient(135deg, #1d4ed8, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                {{ config('app.name', 'SmartUMKM') }}
                            </span>
                        </h1>
                        
                        <p class="mb-0" 
                            style="font-size: 12px; color: #1e40af; max-width: 700px; line-height: 1.4; font-weight: 500;">
                            Kelola operasional usaha Anda dengan lebih modern,
                            cepat, dan efisien melalui
                            <strong style="color: #1d4ed8;">{{ config('app.name', 'SmartUMKM') }}</strong>
                            dengan presisi hari ini.
                        </p>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="text-end">
                            <img src="{{ asset('assets/images/backgrounds/shop.png') }}" alt="Welcome" class="img-fluid" style="max-height: 90px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="fw-semibold text-muted mb-2">Total Produk</h6>
                        <h3 class="fw-semibold mb-0">{{ \App\Models\Produk::count() }}</h3>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <div class="bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-package fs-6 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="fw-semibold text-muted mb-2">Total Kategori</h6>
                        <h3 class="fw-semibold mb-0">{{ \App\Models\Kategori::count() }}</h3>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <div class="bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-category fs-6 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h6 class="fw-semibold text-muted mb-2">Total Transaksi</h6>
                        <h3 class="fw-semibold mb-0">{{ \App\Models\Transaksi::count() }}</h3>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <div class="bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-shopping-cart fs-6 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Grafik Penjualan</h5>
                    </div>
                    <div>
                        <select class="form-select" id="yearSelect">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2025">2026</option>
                            <option value="2025">2027</option>
                        </select>
                    </div>
                </div>
                <div id="salesChart"></div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Ringkasan</h5>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Total Pendapatan</span>
                        <span class="fw-semibold">Rp {{ number_format(\App\Models\Transaksi::sum('total_harga') ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Total Stok Terjual</span>
                        <span class="fw-semibold">{{ \App\Models\DetailTransaksi::sum('jumlah') ?? 0 }} item</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Transaksi Bulan Ini</span>
                        <span class="fw-semibold">{{ \App\Models\Transaksi::whereMonth('created_at', date('m'))->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- INSIGHT UMKM CARD (Fokus Stok Menipis) --}}
@php
    $produkStokMenipis = \App\Models\Produk::where('stok', '<=', 10)
                            ->orderBy('stok', 'asc')
                            ->first();
    
    if ($produkStokMenipis) {
        $namaProduk = $produkStokMenipis->nama_produk;
        $sisaStok = $produkStokMenipis->stok;
        $hargaJual = $produkStokMenipis->harga_jual ?? 50000;
        $potensiKehilangan = $sisaStok * $hargaJual;
        
        $insightTitle = "⚠️ Stok {$namaProduk} Menipis!";
        $insightMessage = "Stok {$namaProduk} tersisa {$sisaStok} item. ";
        $insightMessage .= "Segera lakukan pengadaan stok untuk menghindari kehilangan omzet hingga Rp " . number_format($potensiKehilangan, 0, ',', '.');
        $targetRoute = route('stok.edit', $produkStokMenipis->id_produk);
    } else {
        $insightTitle = "Stok Terkendali";
        $insightMessage = "Semua stok produk dalam kondisi baik. Pertahankan manajemen stok Anda untuk pelayanan optimal!";
        $targetRoute = route('stok.index');
    }
@endphp

<div class="row">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="text-white mb-2">
                            <i class="ti ti-bulb fs-5 me-1"></i> Insight UMKM
                        </h5>
                        <h4 class="text-white fw-bold mb-2">{{ $insightTitle }}</h4>
                        <p class="text-white mb-0" style="opacity: 0.9; font-size: 13px;">
                            {{ $insightMessage }}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ $targetRoute }}" class="btn btn-light text-primary fw-semibold px-4 py-2 rounded-pill">
                            @if($produkStokMenipis)
                                Kelola Stok <i class="ti ti-arrow-right ms-1"></i>
                            @else
                                Lihat Semua Stok <i class="ti ti-arrow-right ms-1"></i>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TABEL TRANSAKSI TERBARU --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold mb-0">
                        <i class="ti ti-receipt me-2"></i> Transaksi Terbaru
                    </h5>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID TRANSAKSI</th>
                                <th>PELANGGAN</th>
                                <th>TANGGAL</th>
                                <th>TOTAL</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $transaksiTerbaru = \App\Models\Transaksi::with('pelanggan')->latest()->take(5)->get();
                            @endphp
                            
                            @forelse($transaksiTerbaru as $transaksi)
                            <tr>
                                <td>
                                    <span class="fw-semibold">#{{ $transaksi->kode_transaksi ?? $transaksi->id }}</span>
                                </td>
                                <td>{{ $transaksi->pelanggan->nama ?? 'Umum' }}</td>
                                <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="fw-semibold text-success">
                                        Rp {{ number_format($transaksi->total_harga ?? $transaksi->total ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $status = $transaksi->status ?? 'selesai';
                                        $statusClass = match($status) {
                                            'selesai', 'berhasil', 'success' => 'success',
                                            'proses', 'pending' => 'warning',
                                            'batal', 'failed' => 'danger',
                                            default => 'secondary'
                                        };
                                        $statusText = match($status) {
                                            'selesai', 'berhasil', 'success' => 'BERHASIL',
                                            'proses', 'pending' => 'DIPROSES',
                                            'batal', 'failed' => 'BATAL',
                                            default => strtoupper($status)
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} px-2 py-1 rounded-pill" 
                                            style="font-size: 11px; font-weight: 500;">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('transaksi.show', $transaksi->id) }}" 
                                        class="btn btn-sm btn-outline-primary rounded-circle"
                                        style="width: 30px; height: 30px; padding: 0; line-height: 28px;">
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="ti ti-receipt fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada data transaksi</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk grafik (sesuaikan dengan data real dari controller)
        var options = {
            series: [{
                name: 'Penjualan',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
            },
            colors: ['#5D87FF'],
            dataLabels: {
                enabled: false
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5
            }
        };

        var chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();
        
        // Event change year select
        document.getElementById('yearSelect').addEventListener('change', function() {
            // Tambahkan logic untuk update grafik berdasarkan tahun yang dipilih
            console.log('Tahun dipilih:', this.value);
            // Anda bisa memanggil AJAX ke controller untuk mendapatkan data penjualan per tahun
        });
    });
</script>
@endpush