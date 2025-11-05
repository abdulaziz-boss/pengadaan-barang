<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PengadaanFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement(['diproses', 'disetujui', 'ditolak', 'selesai']);
        $tanggalPengajuan = $this->faker->dateTimeBetween('-2 months', 'now');
        $tanggalDisetujui = in_array($status, ['disetujui', 'selesai']) ? $this->faker->dateTimeBetween($tanggalPengajuan, 'now') : null;
        $tanggalSelesai = $status === 'selesai' ? $this->faker->dateTimeBetween($tanggalDisetujui, 'now') : null;

        return [
            'kode_pengadaan' => 'PGD-' . strtoupper(Str::random(6)),
            'pengaju_id' => 4, // <- langsung fixed staff ID 4
            'total_harga' => $this->faker->numberBetween(1000000, 15000000),
            'status' => $status,
            'alasan_penolakan' => $status === 'ditolak' ? $this->faker->sentence(6) : null,
            'tanggal_pengajuan' => $tanggalPengajuan,
            'tanggal_disetujui' => $tanggalDisetujui,
            'tanggal_selesai' => $tanggalSelesai,
        ];
    }
}
