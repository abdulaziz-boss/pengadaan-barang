<table style="border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; padding: 4px;">Kode Pengadaan</td>
        <td style="padding: 4px;">{{ $pengadaan->kode_pengadaan }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px;">Nama Pengaju</td>
        <td style="padding: 4px;">{{ $pengadaan->pengaju->name ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px;">Total Harga</td>
        <td style="padding: 4px;">Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px;">Status</td>
        <td style="padding: 4px;">{{ ucfirst($pengadaan->status) }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px;">Tanggal Pengajuan</td>
        <td style="padding: 4px;">{{ $pengadaan->tanggal_pengajuan ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px;">Tanggal Disetujui</td>
        <td style="padding: 4px;">{{ $pengadaan->tanggal_disetujui ?? '-' }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold; padding: 4px;">Tanggal Selesai</td>
        <td style="padding: 4px;">{{ $pengadaan->tanggal_selesai ?? '-' }}</td>
    </tr>
</table>

<br><br>

<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #cfe2f3;">
            <th style="border: 1px solid #000; font-weight: bold; padding: 4px;">No</th>
            <th style="border: 1px solid #000; font-weight: bold; padding: 4px;">Nama Barang</th>
            <th style="border: 1px solid #000; font-weight: bold; padding: 4px;">Jumlah</th>
            <th style="border: 1px solid #000; font-weight: bold; padding: 4px;">Harga Satuan</th>
            <th style="border: 1px solid #000; font-weight: bold; padding: 4px;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengadaan->items as $i => $item)
            <tr style="{{ $i % 2 == 0 ? 'background-color: #f2f2f2;' : '' }}">
                <td style="border: 1px solid #000; padding: 4px;">{{ $i + 1 }}</td>
                <td style="border: 1px solid #000; padding: 4px;">{{ $item->barang->nama ?? '-' }}</td>
                <td style="border: 1px solid #000; padding: 4px;">{{ $item->jumlah }}</td>
                <td style="border: 1px solid #000; padding: 4px;">Rp {{ number_format($item->harga_saat_pengajuan,0,',','.') }}</td>
                <td style="border: 1px solid #000; padding: 4px;">Rp {{ number_format($item->total_harga_item,0,',','.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center; border: 1px solid #000; padding: 4px;">Tidak ada barang</td>
            </tr>
        @endforelse
    </tbody>
</table>
