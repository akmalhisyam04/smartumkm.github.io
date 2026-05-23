<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai per_page dari request, default 10
        $perPage = $request->input('per_page', 10);
        
        // Ambil nilai pencarian
        $search = $request->input('search', '');
        
        // Validasi per_page hanya angka yang diizinkan
        $allowedPerPage = [10, 20, 50, 100, 200];
        $perPage = in_array($perPage, $allowedPerPage) ? $perPage : 10;
        
        // Query dengan pencarian
        $produk = Produk::with('kategori')
                    ->when($search, function ($query, $search) {
                        return $query->where('nama_produk', 'like', "%{$search}%")
                                        ->orWhereHas('kategori', function ($q) use ($search) {
                                            $q->where('nama_kategori', 'like', "%{$search}%");
                                        });
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
        
        return view('produk.index', compact('produk', 'perPage', 'search'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
        ]);
        
        Produk::create($request->all());
        
        return redirect()->route('produk.index')
                            ->with('success', 'Produk berhasil ditambahkan!');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('produk.edit', compact('produk', 'kategori'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
        ]);
        
        $produk = Produk::findOrFail($id);
        $produk->update($request->all());
        
        return redirect()->route('produk.index')
                            ->with('success', 'Produk berhasil diupdate!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        
        return redirect()->route('produk.index')
                            ->with('success', 'Produk berhasil dihapus!');
    }
}