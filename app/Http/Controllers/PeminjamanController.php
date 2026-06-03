<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Peminjam;
use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

use function Safe\date;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['peminjam', 'barang'])
            ->latest()->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $peminjam = Peminjam::orderBy('nama_peminjam')->get();
        $barang = Barang::orderBy('nama_barang')->get();

        return view('peminjaman.create', compact('peminjam', 'barang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peminjam_id' => 'required|exists:peminjam,id',
            'barang_id' => 'required|exists:barang,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'jumlah_pinjam' => 'required|integer|min:1',
            'status_peminjaman' => 'required|in:dipinjam,dikembalikan,terlambat',
        ], [
            'peminjam_id.required' => 'Peminjam wajib dipilih.',
            'barang_id.required' => 'Barang wajib dipilih.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'jumlah_pinjam.required' => 'Jumlah pinjam wajib diisi.',
            'jumlah_pinjam.integer' => 'Jumlah pinjam harus berupa angka.',
            'jumlah_pinjam.min' => 'Jumlah pinjam minimal 1.',
            'status_peminjaman.required' => 'Status peminjaman wajib dipilih.',
        ]);

        $barang = Barang::findOrFail($data['barang_id']);

        if ($data['status_peminjaman'] === 'dipinjam') {
            if ($data['jumlah_pinjam'] > $barang->stok) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'jumlah_pinjam' => 'Jumlah pinjam melebihi stok barang yang tersedia.',
                    ]);
            }

            $barang->decrement('stok', $data['jumlah_pinjam']);
        }

        Peminjaman::create($data);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        return redirect()->route('peminjaman.index');
    }

    public function edit(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_peminjaman === 'dikembalikan') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Barang yang sudah dikembalikan tidak bisa diedit.');
        }

        $peminjam = Peminjam::orderBy('nama_peminjam')->get();
        $barang = Barang::orderBy('nama_barang')->get();

        return view('peminjaman.edit', compact('peminjaman', 'peminjam', 'barang'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status_peminjaman === 'dikembalikan') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Barang yang sudah dikembalikan tidak bisa diperbarui.');
        }

        $data = $request->validate([
            'peminjam_id' => 'required|exists:peminjam,id',
            'barang_id' => 'required|exists:barang,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'jumlah_pinjam' => 'required|integer|min:1',
            'status_peminjaman' => 'required|in:dipinjam,dikembalikan,terlambat',
        ]);

        $barangBaru = Barang::findOrFail($data['barang_id']);
        $stokTersedia = $barangBaru->stok;

        if (
            $peminjaman->status_peminjaman === 'dipinjam' &&
            $peminjaman->barang_id == $data['barang_id']
        ) {
            $stokTersedia = $stokTersedia + $peminjaman->jumlah_pinjam;
        }

        if ($data['status_peminjaman'] === 'dipinjam') {
            if ($data['jumlah_pinjam'] > $stokTersedia) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'jumlah_pinjam' => 'Jumlah pinjam melebihi stok barang yang tersedia.',
                    ]);
            }
        }

        if ($peminjaman->status_peminjaman === 'dipinjam') {
            $barangLama = Barang::findOrFail($peminjaman->barang_id);
            $barangLama->increment('stok', $peminjaman->jumlah_pinjam);
        }

        if ($data['status_peminjaman'] === 'dipinjam') {
            $barangBaru->decrement('stok', $data['jumlah_pinjam']);
        }

        $peminjaman->update($data);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_peminjaman === 'dipinjam') {
            $peminjaman->barang->increment('stok', $peminjaman->jumlah_pinjam);
        }

        $peminjaman->update([
            'status_peminjaman' => 'dikembalikan',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Barang berhasil dikembalikan dan stok berhasil ditambahkan kembali.');
    }

    public function exportPdf()
    {
        $peminjaman = Peminjaman::with(['peminjam', 'barang'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('peminjaman.export_pdf', compact('peminjaman'));

        return $pdf->download('laporan-peminjaman_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PeminjamanExport, 'laporan-peminjaman_' . date('Y-m-d') . ' .xlsx');
    }


    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_peminjaman === 'dipinjam') {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Data peminjaman yang masih dipinjam tidak boleh dihapus.');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
