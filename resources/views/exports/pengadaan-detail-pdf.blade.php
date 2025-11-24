<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pengadaan</title>

    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        h2 { text-align: center; margin-bottom: 10px; }
        .header { text-align: center; margin-bottom: 15px; }
        .logo { width: 100px; display: block; margin: 0 auto; }
        .badge { padding: 4px 8px; color: #fff; border-radius: 4px; font-size: 12px; }
        .success { background: #28a745; }
        .danger { background: #dc3545; }
        .primary { background: #0d6efd; }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo">
        <h2>Detail Riwayat Pengadaan</h2>
    </div>

    <table>
        <tr>
            <th width="180">Kode Pengadaan</th>
            <td>{{ $pengadaan->kode_pengadaan }}</td>
        </tr>

        <tr>
            <th>Nama Pengaju</th>
            <td>{{ $pengadaan->pengaju->name ?? '-' }}</td>
        </tr>

        <tr>
            <th>Total Harga</th>
            <td>Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
        </tr>

        <tr>
            <th>Status</th>
            <td>
                @if ($pengadaan->status === 'disetujui')
                    <span class="badge success">Disetujui</span>
                @elseif ($pengadaan->status === 'ditolak')
                    <span class="badge danger">Ditolak</span>
                @else
                    <span class="badge primary">Selesai</span>
                @endif
            </td>
        </tr>

        @if ($pengadaan->alasan_penolakan)
        <tr>
            <th>Alasan Penolakan</th>
            <td>{{ $pengadaan->alasan_penolakan }}</td>
        </tr>
        @endif

        <tr>
            <th>Tanggal Pengajuan</th>
            <td>{{ $pengadaan->tanggal_pengajuan ?? '-' }}</td>
        </tr>

        <tr>
            <th>Tanggal Disetujui</th>
            <td>{{ $pengadaan->tanggal_disetujui ?? '-' }}</td>
        </tr>

        <tr>
            <th>Tanggal Selesai</th>
            <td>{{ $pengadaan->tanggal_selesai ?? '-' }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 25px; text-align:center;">Daftar Barang</h3>

    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Barang</th>
                <th width="60">Jumlah</th>
                <th width="120">Harga Satuan</th>
                <th width="120">Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($pengadaan->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->barang->nama ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga_saat_pengajuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_harga_item, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
