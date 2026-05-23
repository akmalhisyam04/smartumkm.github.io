<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai per_page dari request, default 10
        $perPage = $request->input('per_page', 10);
        
        // Validasi per_page hanya angka yang diizinkan
        $allowedPerPage = [10, 20, 50, 100, 200];
        $perPage = in_array($perPage, $allowedPerPage) ? $perPage : 10;
        
        // Ambil data dengan pagination dan relasi produk
        $kategori = Kategori::withCount('produk')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
        
        return view('kategori.index', compact('kategori', 'perPage'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, int $id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(int $id)
    {
        Kategori::destroy($id);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}