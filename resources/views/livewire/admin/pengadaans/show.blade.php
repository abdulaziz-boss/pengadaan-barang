<div>
    <h3>Detail Pengadaan</h3>
    <hr>

    <table class="table">
        <tr>
            <th>Kode Pengadaan</th>
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
            <td>{{ ucfirst($pengadaan->status) }}</td>
        </tr>
        @if($pengadaan->alasan_penolakan)
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

    <h4 class="mt-4">Daftar Barang</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan (saat pengajuan)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengadaan->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->barang->nama ?? '-' }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->harga_saat_pengajuan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->total_harga_item, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada barang yang ditambahkan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin.pengadaans.index') }}" class="btn btn-danger"wire:navigate>Kembali</a>
</div>
