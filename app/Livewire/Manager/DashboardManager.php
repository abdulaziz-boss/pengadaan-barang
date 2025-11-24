<?php

namespace App\Livewire\Manager;

use Livewire\Component;
use App\Models\Pengadaan;

class DashboardManager extends Component
{
    public $totalPengadaan = 0;
    public $totalDiproses = 0;
    public $totalDisetujui = 0;
    public $totalDitolak = 0;
    public $totalSelesai = 0;
    public $recentPengadaan;
    public $bulan = [];
    public $chartData = [];

    public function mount()
    {
        $tahun = date('Y');

        // Hitung total per status
        $this->totalPengadaan = Pengadaan::count();
        $this->totalDiproses  = Pengadaan::where('status', 'diproses')->count();
        $this->totalDisetujui = Pengadaan::where('status', 'disetujui')->count();
        $this->totalDitolak   = Pengadaan::where('status', 'ditolak')->count();
        $this->totalSelesai   = Pengadaan::where('status', 'selesai')->count();

        // Pengadaan terbaru (5 data terakhir)
        $this->recentPengadaan = Pengadaan::with('pengaju')
            ->latest()
            ->take(5)
            ->get();

        // Ambil data mentah pengadaan per bulan
        $raw = Pengadaan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Nama bulan
        $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // Generate array 12 bulan lengkap
        $chart = [];
        for ($i = 1; $i <= 12; $i++) {
            $chart[] = $raw[$i] ?? 0;
        }

        $this->bulan = $namaBulan;
        $this->chartData = $chart;
    }

    public function render()
    {
        return view('livewire.manager.dashboard-manager');
    }
}
