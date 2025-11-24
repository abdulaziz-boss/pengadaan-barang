<div>
    @section('title', 'Detail Barang')

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Barang</h5>
            <a href="{{ route('manager.barangs.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Nama Barang</th>
                    <td>{{ $barang->nama }}</td>
                </tr>

                <tr>
                    <th>Kategori</th>
                    <td>{{ $barang->category->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Stok</th>
                    <td class="{{ $barang->stok <= $barang->stok_minimal ? 'text-danger fw-bold' : '' }}">
                        {{ $barang->stok }}
                    </td>
                </tr>

                <tr>
                    <th>Stok Minimal</th>
                    <td>{{ $barang->stok_minimal }}</td>
                </tr>

                <tr>
                    <th>Satuan</th>
                    <td>{{ $barang->satuan }}</td>
                </tr>

                <tr>
                    <th>Harga Satuan</th>
                    <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                </tr>

                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $barang->deskripsi ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>

    <style>
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid #eee;
        }

        thead.bg-primary th {
            color: #fff !important;
        }

        .text-danger {
            color: #dc3545;
        }

        @media (max-width: 575px) {
            .table .btn {
                width: 100%;
            }
        }
    </style>
</div>
