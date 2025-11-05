<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengadaan;

class PengadaanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan user dengan ID ini ada di tabel users
        $data = [
            [
                'kode_pengadaan' => 'PGD-2025-001',
                'pengaju_id' => 6,
                'total_harga' => 4000000,
                'status' => 'disetujui',
                'tanggal_pengajuan' => '2025-10-01',
                'tanggal_disetujui' => '2025-10-05',
                'tanggal_selesai' => '2025-10-10',
                'alasan_penolakan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pengadaan' => 'PGD-2025-002',
                'pengaju_id' => 14,
                'total_harga' => 12000000,
                'status' => 'ditolak',
                'tanggal_pengajuan' => '2025-10-05',
                'tanggal_disetujui' => null,
                'tanggal_selesai' => null,
                'alasan_penolakan' => 'Anggaran tidak mencukupi tahun ini',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pengadaan' => 'PGD-2025-003',
                'pengaju_id' => 15,
                'total_harga' => 8000000,
                'status' => 'ditolak',
                'tanggal_pengajuan' => '2025-10-10',
                'tanggal_disetujui' => null,
                'tanggal_selesai' => null,
                'alasan_penolakan' => 'Barang sudah tersedia di gudang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Pengadaan::insert($data);
    }
}
