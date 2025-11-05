<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengadaanItem;

class PengadaanItemSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Barang untuk pengadaan PGD-2025-001 (Laptop)
            [
                'pengadaan_id' => 1,
                'barang_id' => 3,
                'jumlah' => 5,
                'harga_saat_pengajuan' => 9000000,
                'total_harga_item' => 45000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Barang untuk pengadaan PGD-2025-002 (Kursi Kantor)
            [
                'pengadaan_id' => 2,
                'barang_id' => 4,
                'jumlah' => 6,
                'harga_saat_pengajuan' => 2000000,
                'total_harga_item' => 12000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Barang untuk pengadaan PGD-2025-003 (Printer)
            [
                'pengadaan_id' => 3,
                'barang_id' => 5,
                'jumlah' => 4,
                'harga_saat_pengajuan' => 2000000,
                'total_harga_item' => 8000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        PengadaanItem::insert($data);
    }
}
