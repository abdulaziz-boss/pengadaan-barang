<div>
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah User</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form wire:submit.prevent="store" class="form">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">Username</label>
                                            <input wire:model="name" type="text" id="name" class="form-control"
                                                placeholder="Masukkan nama lengkap">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input wire:model="email" type="email" id="email" class="form-control"
                                                placeholder="Masukkan email">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input wire:model="password" type="password" id="password" class="form-control"
                                                placeholder="Masukan password">
                                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select wire:model="role" id="role" class="form-select">
                                                <option value="">-- Pilih Role --</option>
                                                <option value="admin">Admin</option>
                                                <option value="manager">Manager</option>
                                                <option value="staff">Staff</option>
                                            </select>
                                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Simpan
                                        </button>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-danger me-1 mb-1"wire:navigate>
                                            Batal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('user-berhasil-disimpan', event => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'User baru berhasil ditambahkan!',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            // Redirect setelah alert ditutup
            window.location.href = "{{ route('admin.users.index') }}";
        });
    });
</script>
