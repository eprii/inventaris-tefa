<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Barang;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeminjam = Peminjam::count();
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');

        $totalPeminjaman = Peminjaman::count();
        $sedangDipinjam = Peminjaman::where('status_peminjaman', 'dipinjam')->count();
        $sudahDikembalikan = Peminjaman::where('status_peminjaman', 'dikembalikan')->count();

        $peminjamanTerbaru = Peminjaman::with(['peminjam', 'barang'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPeminjam',
            'totalBarang',
            'totalStok',
            'totalPeminjaman',
            'sedangDipinjam',
            'sudahDikembalikan',
            'peminjamanTerbaru'
        ));
    }
}
