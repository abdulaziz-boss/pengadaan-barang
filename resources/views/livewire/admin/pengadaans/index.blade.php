<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Pengadaan</h3>
        <input wire:model.live="search" type="text" placeholder="Cari kode pengadaan..." class="form-control w-25">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Pengaju</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengadaans as $p)
                <tr>
                    <td>{{ $p->kode_pengadaan }}</td>
                    <td>{{ $p->pengaju->name ?? '-' }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $p->status == 'disetujui' ? 'success' : ($p->status == 'ditolak' ? 'danger' : 'warning') }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>{{ $p->tanggal_pengajuan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.pengadaans.show', $p->id) }}"
                           class="badge bg-info text-decoration-none"
                           wire:navigate>
                           Detail
                        </a>
                        <button type="button"
                                wire:click="confirmDelete({{ $p->id }})"
                                class="badge bg-danger border-0">
                            Hapus
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {

            // Konfirmasi hapus
            Livewire.on('confirm-delete', (event) => {
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteConfirmed', { id: event.id });
                    }
                });
            });

            // Notif sukses
            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Barang berhasil dihapus!',
                    timer: 1500,
                    showConfirmButton: false
                });
            });

            // Notif error
            Livewire.on('swal:error', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: event.title,
                    text: event.text,
                    confirmButtonText: 'OK'
                });
            });

        });
    </script>
    @endpush
</div>
