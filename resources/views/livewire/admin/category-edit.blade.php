@section('title', 'Edit categories ')
<div>
    <div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h3>Edit Kategori</h3>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="update">
                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text" wire:model="nama" class="form-control">
                        @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea wire:model="deskripsi" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Simpan Perubahan</button>
                    <a href="{{ route('admin.categories') }}" class="btn btn-danger" wire:navigate><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </form>
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                window.addEventListener('swal', event => {
                                    Swal.fire({
                                        title: "Good job!",
                                        text: "Kategori berhasil diedit!",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        // Redirect setelah klik OK
                                        window.location.href = "{{ route('admin.categories') }}";
                                    });
                                });
                </script>
            </div>
        </div>
    </section>
</div>

</div>
