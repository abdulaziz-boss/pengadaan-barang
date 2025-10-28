@section('title', 'List Barang')

<div>
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Barang</h5>
                <a href="{{ route('admin.barangs.create') }}" class="btn btn-primary btn-sm" wire:navigate>+ Tambah Barang</a>
            </div>

            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Stok Minimal</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->category->nama ?? '-' }}</td>
                                <td class="{{ $barang->stok <= $barang->stok_minimal ? 'text-danger fw-bold' : '' }}">
                                    {{ $barang->stok }}
                                </td>
                                <td>{{ $barang->stok_minimal }}</td>
                                <td>{{ $barang->satuan }}</td>
                                <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="#" class="badge bg-primary text-decoration-none">Lihat</a>
                                    <a href="#" class="badge bg-success text-decoration-none">Edit</a>
                                    <button wire:click="delete({{ $barang->id }})" class="badge bg-danger border-0">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data barang</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
