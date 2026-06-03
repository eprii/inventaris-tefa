<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;

class PeminjamController extends Controller
{
    public function index()
    {
        $peminjam = Peminjam::orderBy('nama_peminjam')->paginate(10);

        return view('peminjam.index', compact('peminjam'));
    }
}
