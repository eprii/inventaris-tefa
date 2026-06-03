<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->paginate(10);

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|max:100',
            'kategori_barang' => 'required|max:100',
            'stok' => 'required|integer|min:0',
            'kondisi_barang' => 'required|max:50',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kategori_barang.required' => 'Kategori barang wajib diisi.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'kondisi_barang.required' => 'Kondisi barang wajib diisi.',
        ]);

        Barang::create($data);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        return redirect()->route('barang.index');
    }

    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $databarang = $request->validate([
            'nama_barang' => 'required|max:100',
            'kategori_barang' => 'required|max:100',
            'stok' => 'required|integer|min:0',
            'kondisi_barang' => 'required|max:50',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kategori_barang.required' => 'Kategori barang wajib diisi.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'kondisi_barang.required' => 'Kondisi barang wajib diisi.',
        ]);

        $barang->update($databarang);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->peminjaman()->count() > 0) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak bisa dihapus karena sudah memiliki data peminjaman.');
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }
}
