<div>
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Pengadaan Barang</h5>

            <div class="d-flex gap-2">
                <div class="input-group w-auto">
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari kode, barang, atau pengaju...">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                </div>

                <button wire:click="deleteSelected"
                        class="btn btn-danger btn-sm"
                        @disabled(count($selected) === 0)>
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table text-center align-middle">
                    <thead class="bg-primary">
                        <tr>
                            <th><input type="checkbox" wire:model.live="selectAll"></th>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Pengaju</th>
                            <th>Barang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pengadaans as $index => $p)
                            <tr wire:key="pengadaan-{{ $p->id }}">
                                <td><input type="checkbox" wire:model.live="selected" value="{{ $p->id }}"></td>
                                <td>{{ $pengadaans->firstItem() + $index }}</td>
                                <td><strong>{{ $p->kode_pengadaan }}</strong></td>
                                <td>{{ $p->pengaju->name ?? '-' }}</td>

                                <td class="text-start">
                                    <ul class="mb-0 list-unstyled">
                                        @foreach ($p->items as $item)
                                            <li>{{ $item->barang->nama }} ({{ $item->jumlah }})</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>

                                <td>
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                </td>

                                <td>
                                    <a href="{{ route('manager.pengadaans.show', $p->id) }}"
                                       class="btn btn-primary btn-sm"
                                       wire:navigate>
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-muted">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{ $pengadaans->links() }}

        </div>
    </div>

    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid #eee;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
    </style>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    Livewire.on("alert", (data) => {
        Swal.fire({
            icon: data.type ?? 'success',
            title: data.title ?? '',
            text: data.text ?? '',
            timer: data.timer ?? 1500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    });

});
</script>
