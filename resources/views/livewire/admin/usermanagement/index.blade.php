<div>
    <!-- Header dan Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Manajemen User</h3>
        <div class="d-flex gap-2">
            <div class="position-relative" style="width: 350px;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input
                    wire:model.live="search"
                    type="text"
                    class="form-control ps-5"
                    placeholder="Cari user berdasarkan nama atau email..."
                >
            </div>

            <!-- Tombol Tambah User pakai route -->
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"wire:navigate>
                <i class="bi bi-plus-lg"></i> Tambah User
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{
                                    $user->role === 'admin' ? 'danger' :
                                    ($user->role === 'manager' ? 'warning text-dark' : 'success')
                                }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="badge bg-success text-decoration-none"wire:navigate>
                                    Edit
                                </a>

                                @if ($user->id != auth()->id())
                                    <button
                                        wire:click="confirmDelete({{ $user->id }})"
                                        class="badge bg-danger border-0 text-decoration-none"
                                    >
                                        Hapus
                                    </button>
                                @else
                                    <span class="badge bg-secondary">Hapus</span>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Tidak ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <script>
            document.addEventListener('livewire:initialized', () => {

                // 🔥 Tampilkan konfirmasi hapus
                Livewire.on('show-delete-confirmation', () => {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data user ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim event kembali ke Livewire
                            Livewire.dispatch('deleteConfirmed');
                        }
                    });
                });

                // ✅ Tampilkan notifikasi sukses setelah dihapus
                Livewire.on('user-deleted', () => {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'User berhasil dihapus.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>
