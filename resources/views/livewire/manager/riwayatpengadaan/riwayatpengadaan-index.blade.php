<div>
    @section('title','Riwayat Pengadaan')

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Riwayat Pengadaan</h5>

            <div class="d-flex gap-2 align-items-center">

                <input type="text" wire:model.live.debounce.500ms="search"
                       class="form-control form-control-sm"
                       placeholder="Cari: nama barang / kategori / kode / pengaju"
                       style="width: 320px;">

                <button class="btn btn-success btn-sm"
                        wire:click="exportExcel"
                        wire:loading.attr="disabled"
                        @disabled(empty($selected))
                >
                    <span wire:loading.remove wire:target="exportExcel">Excel</span>
                    <span wire:loading wire:target="exportExcel" class="spinner-border spinner-border-sm"></span>
                </button>

                <button class="btn btn-secondary btn-sm"
                        wire:click="exportPdf"
                        wire:loading.attr="disabled"
                        @disabled(empty($selected))
                >
                    <span wire:loading.remove wire:target="exportPdf">PDF</span>
                    <span wire:loading wire:target="exportPdf" class="spinner-border spinner-border-sm"></span>
                </button>

                <button class="btn btn-danger btn-sm" onclick="confirmDelete()"
                        @disabled(empty($selected))
                >
                    Hapus ({{ count(array_filter($selected)) }})
                </button>
            </div>
        </div>

        <div class="card-body ">
            @if(session()->has('success'))
                <div class="alert alert-success m-3">{{ session('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger m-3">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="40">
                                <input type="checkbox"
                                       wire:model.live="selectPage"
                                       {{ $selectAll ? 'checked' : '' }}>
                            </th>
                            <th>Kode</th>
                            <th>Pengaju</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th width="90">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- when select page but not all, show option to select across pages --}}
                        @if($selectPage && !$selectAll)
                            <tr>
                                <td colspan="7" class="bg-light">
                                    <div class="p-2">
                                        <strong>{{ count(array_filter($selected)) }}</strong> dipilih pada halaman ini.
                                        <button class="btn btn-link p-0" wire:click="selectAllAcrossPages">
                                            Pilih semua ({{ \App\Models\Pengadaan::whereIn('status',['disetujui','ditolak','selesai'])->count() }} item)
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        {{-- when selectAll active, show notification --}}
                        @if($selectAll)
                            <tr>
                                <td colspan="7" class="bg-info text-white">
                                    <div class="p-2 d-flex justify-content-between align-items-center">
                                        <span>
                                            <strong>Semua {{ count(array_filter($selected)) }} item</strong> telah dipilih di seluruh halaman.
                                        </span>
                                        <button class="btn btn-link text-white p-0 text-decoration-underline" wire:click="unselectAll">
                                            Batalkan pilihan
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        @forelse($pengadaans as $row)
                            <tr wire:key="pengadaan-{{ $row->id }}">
                                <td>
                                    {{-- Jika selectAll aktif, tampilkan checkbox checked tanpa wire:model --}}
                                    @if($selectAll)
                                        <input type="checkbox"
                                               checked
                                               disabled
                                               wire:key="checkbox-{{ $row->id }}">
                                    @else
                                        <input type="checkbox"
                                               wire:model.live="selected.{{ $row->id }}"
                                               value="1"
                                               wire:key="checkbox-{{ $row->id }}">
                                    @endif
                                </td>

                                <td>{{ $row->kode_pengadaan }}</td>
                                <td>{{ $row->pengaju->name ?? '-' }}</td>
                                <td>Rp {{ number_format($row->total_harga,0,',','.') }}</td>
                                <td>
                                    @if($row->status === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($row->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-primary">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ $row->tanggal_pengajuan }}</td>
                                <td>
                                    <a href="{{ route('manager.riwayatpengadaan.show', $row->id) }}" class="btn btn-info btn-sm" wire:navigate>
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $pengadaans->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete() {
            Swal.fire({
                title: "Hapus data terpilih?",
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteSelected');
                }
            });
        }
    </script>
    @endpush

    <style>
        thead.bg-primary th { color: #fff !important; }
        .table td, .table th { vertical-align: middle; }

        /* Style untuk checkbox yang disabled agar tetap terlihat checked */
        input[type="checkbox"]:disabled:checked {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</div>
