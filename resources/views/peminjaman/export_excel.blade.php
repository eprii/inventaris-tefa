<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Nama Barang</th>
            <th>Kategori Barang</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Jumlah Pinjam</th>
            <th>Status Peminjaman</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peminjaman as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->peminjam->nama_peminjam ?? '-' }}</td>
                <td>{{ $item->peminjam->kelas ?? '-' }}</td>
                <td>{{ $item->peminjam->jurusan ?? '-' }}</td>
                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                <td>{{ $item->barang->kategori_barang ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y H:i') }}</td>
                <td>
                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y H:i') : '-' }}
                </td>
                <td>{{ $item->jumlah_pinjam }}</td>
                <td>{{ ucfirst($item->status_peminjaman) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
