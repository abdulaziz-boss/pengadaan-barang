<div>
    @section('title', 'List Barang')

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Barang (Manager)</h5>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                wire:model.live="search"
                                class="form-control"
                                placeholder="Cari barang atau kategori..."
                            >
                            @if($search)
                                <button class="btn btn-outline-danger" wire:click="$set('search', '')" type="button">
                                    <i class="bi bi-x"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead class="bg-primary">
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
                                        <a href="{{ route('manager.barangs.show', $barang->id) }}"
                                           class="btn btn-primary btn-sm"
                                           wire:navigate>
                                           <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        @if($search)
                                            Tidak ada hasil untuk "{{ $search }}"
                                        @else
                                            Belum ada data barang
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $barangs->links() }}
                </div>
            </div>
        </div>
    </section>

    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

        @media (max-width: 575px) {
            .table .btn {
                width: 100%;
            }
        }
    </style>
</div>
