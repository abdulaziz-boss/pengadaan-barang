<div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3>Edit User</h3>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="update">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select wire:model="role" class="form-select">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
                        </select>
                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Event sukses update user
    window.addEventListener('user-berhasil-diupdate', event => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data user berhasil diperbarui!',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = "{{ route('admin.users.index') }}";
        });
    });

    // Event sukses hapus user
    window.addEventListener('user-berhasil-dihapus', event => {
        Swal.fire({
            icon: 'success',
            title: 'Dihapus!',
            text: 'User berhasil dihapus!',
            showConfirmButton: false,
            timer: 1500
        });
    });
</script>


</div>

