<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Barang;
use App\Models\Category;
use App\Models\Pengadaan;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

class DashboardAdmin extends Component
{
    public $chartData = [];
    public $bulan = [];

    public function mount()
    {
        $this->generateChartData();
    }

    private function generateChartData()
    {
        // Ambil jumlah pengadaan per bulan di tahun berjalan
        $pengadaanBulanan = Pengadaan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $this->bulan = [];
        $this->chartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $this->bulan[] = $namaBulan[$i];
            $total = $pengadaanBulanan->firstWhere('bulan', $i)->total ?? 0;
            $this->chartData[] = (int)$total;
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin', [
            'totalBarang' => Barang::count(),
            'totalPengadaan' => Pengadaan::count(),
            'totalKategori' => Category::count(),
            'recentPengadaan' => Pengadaan::latest()->take(5)->get(),
            'totalLog' => Log::count(), // Hanya total log
            'chartData' => $this->chartData,
            'bulan' => $this->bulan,
        ]);
    }
}
