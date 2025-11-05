@section('title', 'Tambah Barang')

<div>
    <section id="multiple-column-form">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Barang</h4>
            </div>

            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form wire:submit.prevent="save" class="form">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="form-control" placeholder="Masukkan nama barang">
                            @error('nama_barang') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label>Pilih Mode Kategori</label>
                            <select wire:model.live="modeKategori" class="form-select">
                                <option value="pilih">Pilih kategori yang sudah ada</option>
                                <option value="baru">Masukkan kategori baru</option>
                            </select>
                        </div>

                        {{-- Jika pilih kategori yang sudah ada --}}
                        @if ($modeKategori === 'pilih')
                            <div class="col-md-6 mt-3">
                                <label>Pilih Kategori</label>
                                <select wire:model="kategori_id" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        {{-- Jika buat kategori baru --}}
                        @if ($modeKategori === 'baru')
                            <div class="col-md-6 mt-3">
                                <label>Nama Kategori Baru</label>
                                <input type="text" wire:model="nama_kategori_baru" class="form-control" placeholder="Masukkan nama kategori baru">
                                @error('nama_kategori_baru') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label>Deskripsi Kategori</label>
                                <textarea wire:model="deskripsi_kategori" class="form-control" placeholder="Deskripsi kategori"></textarea>
                            </div>
                        @endif

                        <div class="col-md-6 mt-3">
                            <label>Stok</label>
                            <input type="number" wire:model="stok" class="form-control" placeholder="Masukkan jumlah stok">
                            @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Stok Minimal</label>
                            <input type="number" wire:model="stok_minimal" class="form-control" placeholder="Masukkan stok minimal">
                            @error('stok_minimal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Satuan</label>
                            <input type="text" wire:model="satuan" class="form-control" placeholder="Contoh: pcs, liter, kg">
                            @error('satuan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Harga Satuan</label>
                            <input type="number" wire:model="harga_satuan" class="form-control" placeholder="Masukkan harga satuan">
                            @error('harga_satuan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-1 mb-1"><i class="bi bi-check-circle me-1"></i>Simpan</button>
                            <a href="{{ route('admin.barangs.index') }}" class="btn btn-danger me-1 mb-1" wire:navigate> <i class="bi bi-x-circle me-1"></i>Batal</a>
                        </div>
                    </div>
                </form>

                <script>
                    window.addEventListener('barang-berhasil-ditambah', event => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Barang berhasil ditambahkan!',
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
