@section('title', 'Edit Barang')

<div>
    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Barang</h4>
                <p class="text-muted">Nama barang dan kategori tidak dapat diubah</p>
            </div>

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form wire:submit.prevent="update" class="form">
                    <div class="row">
                        {{-- Nama Barang (Readonly) --}}
                        <div class="col-md-6">
                            <label>Nama Barang</label>
                            <input
                                type="text"
                                value="{{ $nama_barang }}"
                                class="form-control"
                                readonly
                                style="background-color: #f8f9fa; cursor: not-allowed;"
                            >
                            <small class="text-muted">Nama barang tidak dapat diubah</small>
                        </div>

                        {{-- Kategori (Readonly) --}}
                        <div class="col-md-6">
                            <label>Kategori</label>
                            <input
                                type="text"
                                value="{{ $nama_kategori }}"
                                class="form-control"
                                readonly
                                style="background-color: #f8f9fa; cursor: not-allowed;"
                            >
                            <small class="text-muted">Kategori tidak dapat diubah</small>
                        </div>

                        {{-- Stok --}}
                        <div class="col-md-6 mt-3">
                            <label>Stok <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                wire:model="stok"
                                class="form-control"
                                placeholder="Masukkan jumlah stok"
                                min="0"
                            >
                            @error('stok')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Stok Minimal --}}
                        <div class="col-md-6 mt-3">
                            <label>Stok Minimal <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                wire:model="stok_minimal"
                                class="form-control"
                                placeholder="Masukkan stok minimal"
                                min="0"
                            >
                            @error('stok_minimal')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Satuan --}}
                        <div class="col-md-6 mt-3">
                            <label>Satuan <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                wire:model="satuan"
                                class="form-control"
                                placeholder="Contoh: pcs, liter, kg"
                            >
                            @error('satuan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Harga Satuan --}}
                        <div class="col-md-6 mt-3">
                            <label>Harga Satuan <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                wire:model="harga_satuan"
                                class="form-control"
                                placeholder="Masukkan harga satuan"
                                min="0"
                                step="0.01"
                            >
                            @error('harga_satuan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Informasi --}}
                        <div class="col-12 mt-3">
                            <div class="alert alert-light-info">
                                <h6 class="alert-heading">Informasi</h6>
                                <p class="mb-0">
                                    Hanya field <strong>Stok, Stok Minimal, Satuan, dan Harga Satuan</strong> yang dapat diubah.
                                    Nama barang dan kategori tidak dapat diubah untuk menjaga konsistensi data.
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                <i class="bi bi-check-circle me-1"></i>Update Barang
                            </button>
                            <a href="{{ route('admin.barangs.index') }}" class="btn btn-danger me-1 mb-1" wire:navigate>
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>

                <script>
                    window.addEventListener('barang-berhasil-diupdate', event => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data barang berhasil diperbarui!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('admin.barangs.index') }}";
                        });
                    });
                </script>

            </div>
        </div>
    </section>
</div>
