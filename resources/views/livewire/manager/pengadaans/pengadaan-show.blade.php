<div>
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Pengadaan</h5>

            <a href="{{ route('manager.pengadaans.index') }}" class="btn btn-secondary btn-sm" wire:navigate>
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Kode Pengadaan</th>
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
                        @if ($pengadaan->status === 'diproses')
                            <span class="badge bg-warning text-dark">Diproses</span>
                        @elseif ($pengadaan->status === 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif ($pengadaan->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-primary">Selesai</span>
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

            <h5 class="mt-4">Daftar Barang</h5>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="bg-primary text-white !important">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan (Saat Pengajuan)</th>
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
                                <td colspan="5" class="text-muted">Tidak ada barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            {{-- BUTTON SETUJUI & TOLAK (Hanya jika status masih diproses) --}}
            @if ($pengadaan->status === 'diproses')
                <div class="d-flex justify-content-end mt-4 gap-2">

                    <button wire:click="confirmSetujui"
                            class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Setujui
                    </button>

                    <button wire:click="openTolakForm"
                            class="btn btn-danger">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>

                </div>
            @endif

        </div>
    </div>


    {{-- === MODAL FORM TOLAK === --}}
    @if ($showTolakForm)
        <div class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center"
            style="z-index: 9999;">

            <div class="bg-white p-4 rounded shadow" style="width: 400px;">
                <h5 class="mb-3">Alasan Penolakan</h5>

                <textarea wire:model="alasan_penolakan"
                        class="form-control mb-3"
                        rows="4"
                        placeholder="Tulis alasan penolakan..."></textarea>

                <div class="d-flex justify-content-end gap-2">
                    <button wire:click="closeTolakForm" class="btn btn-secondary btn-sm">
                        Batal
                    </button>

                    <button wire:click="confirmSubmitTolak" class="btn btn-danger btn-sm">
                        Tolak Pengadaan
                    </button>
                </div>
            </div>

        </div>
    @endif
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

    // =============================
    //      KONFIRMASI SETUJUI
    // =============================
    Livewire.on('confirm-setujui', (data) => {
        Swal.fire({
            title: "Setujui Pengadaan?",
            text: "Pengadaan akan disetujui dan tidak dapat dibatalkan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Setujui",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('doSetujui');
            }
        });
    });


    // =============================
    //      KONFIRMASI TOLAK
    // =============================
    Livewire.on('confirm-tolak', () => {
        Swal.fire({
            title: "Yakin menolak pengadaan?",
            text: "Data tidak bisa dikembalikan setelah ditolak!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Tolak",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('doTolak');
            }
        });
    });


    // =============================
    //          ALERT + REDIRECT
    // =============================
    Livewire.on("alert", (data) => {
        Swal.fire({
            icon: data.type ?? 'success',
            title: data.title ?? '',
            text: data.text ?? '',
            timer: data.timer ?? 1500,
            timerProgressBar: true,
            showConfirmButton: false,
        }).then(() => {
                window.location.href = "{{ route('manager.pengadaans.index') }}";
            });
    });

});
</script>


