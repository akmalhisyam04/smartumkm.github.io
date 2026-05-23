<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\PergerakanStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PergerakanStokController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $jenis = $request->input('jenis', '');
        
        $allowedPerPage = [10, 20, 50, 100];
        $perPage = in_array($perPage, $allowedPerPage) ? $perPage : 10;
        
        // Query data stok
        $stok = PergerakanStok::with('produk')
                    ->when($search, function($query, $search) {
                        return $query->whereHas('produk', function($q) use ($search) {
                            $q->where('nama_produk', 'like', "%{$search}%");
                        });
                    })
                    ->when($jenis, function($query, $jenis) {
                        return $query->where('jenis', $jenis);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
        
        // Data statistik
        $totalStokMasuk = PergerakanStok::where('jenis', 'masuk')->sum('jumlah');
        $totalStokKeluar = PergerakanStok::where('jenis', 'keluar')->sum('jumlah');
        $totalProduk = Produk::count();
        $produkStokMenipis = Produk::where('stok', '<=', 5)->count();
        $produkMenipisList = Produk::where('stok', '<=', 5)->orderBy('stok', 'asc')->take(5)->get();
        
        return view('stok.index', compact(
            'stok', 'totalStokMasuk', 'totalStokKeluar', 
            'totalProduk', 'produkStokMenipis', 'produkMenipisList'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        return view('stok.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        DB::beginTransaction();
        
        try {
            $produk = Produk::findOrFail($request->id_produk);
            
            // Update stok produk
            if ($request->jenis == 'masuk') {
                $produk->stok += $request->jumlah;
                $keteranganDefault = "Stok masuk - " . ($request->keterangan ?? 'Pembelian barang');
            } else {
                // Cek apakah stok cukup
                if ($produk->stok < $request->jumlah) {
                    return back()->with('error', "Stok tidak mencukupi! Stok tersedia: {$produk->stok}");
                }
                $produk->stok -= $request->jumlah;
                $keteranganDefault = "Stok keluar - " . ($request->keterangan ?? 'Penjualan/ penggunaan');
            }
            
            $produk->save();
            
            // Simpan histori pergerakan stok
            PergerakanStok::create([
                'id_produk' => $request->id_produk,
                'jenis' => $request->jenis,
                'jumlah' => $request->jumlah,
                'stok_sebelum' => $request->jenis == 'masuk' ? $produk->stok - $request->jumlah : $produk->stok + $request->jumlah,
                'stok_sesudah' => $produk->stok,
                'keterangan' => $request->jenis == 'masuk' ? $keteranganDefault : $keteranganDefault,
                'created_by' => session('nama') ?? 'System',
            ]);
            
            DB::commit();
            
            $message = $request->jenis == 'masuk' 
                ? "Stok berhasil ditambahkan!" 
                : "Stok berhasil dikurangi!";
            
            return redirect()->route('stok.index')
                                ->with('success', $message);
                                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource (histori stok per produk).
     */
    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        
        $historiStok = PergerakanStok::where('id_produk', $id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        
        return view('stok.show', compact('produk', 'historiStok'));
    }
    
    /**
     * API: Get stok produk by ID (untuk AJAX)
     */
    public function getStok($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            return response()->json([
                'success' => true,
                'stok' => $produk->stok,
                'nama_produk' => $produk->nama_produk
            ]);
        }
        return response()->json(['success' => false]);
    }
}