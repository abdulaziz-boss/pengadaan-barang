<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\Pengadaan;
use Illuminate\Support\Facades\Auth;

class DashboardStaff extends Component
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
        $userId = Auth::id();
        $tahun = date('Y');

        // Hitung total-per-status
        $this->totalPengadaan = Pengadaan::where('pengaju_id', $userId)->count();
        $this->totalDiproses  = Pengadaan::where('pengaju_id', $userId)->where('status', 'diproses')->count();
        $this->totalDisetujui = Pengadaan::where('pengaju_id', $userId)->where('status', 'disetujui')->count();
        $this->totalDitolak   = Pengadaan::where('pengaju_id', $userId)->where('status', 'ditolak')->count();
        $this->totalSelesai   = Pengadaan::where('pengaju_id', $userId)->where('status', 'selesai')->count();

        // Latest pengadaan user
        $this->recentPengadaan = Pengadaan::where('pengaju_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Ambil data mentah (hanya bulan yg ada datanya)
        $raw = Pengadaan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('pengaju_id', $userId)
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // MAPPING NAMA BULAN
        $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        // Generate 12 bulan (Jan–Des)
        $chart = [];
        for ($i = 1; $i <= 12; $i++) {
            $chart[] = $raw[$i] ?? 0;
        }

        $this->bulan = $namaBulan; // Jan–Des
        $this->chartData = $chart; // array 12 angka lengkap
    }


    public function render()
    {
        return view('livewire.staff.dashboard-staff');
    }
}
