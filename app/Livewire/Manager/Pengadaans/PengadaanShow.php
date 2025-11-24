<?php

namespace App\Livewire\Manager\Pengadaans;

use Livewire\Component;
use App\Models\Pengadaan;

class PengadaanShow extends Component
{
    public $pengadaan;

    // Untuk tolak
    public $showTolakForm = false;
    public $alasan_penolakan = '';
    protected $listeners = [
        'doSetujui' => 'doSetujui',
        'doTolak' => 'doTolak',
    ];



    public function mount($id)
    {
        $this->pengadaan = Pengadaan::with(['pengaju', 'items.barang'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.manager.pengadaans.pengadaan-show');
    }


    // =======================
    //   SETUJUI PENGADAAN
    // =======================
    public function confirmSetujui()
    {
        $this->dispatch('confirm-setujui', id: $this->pengadaan->id);
    }

    public function doSetujui()
    {
        $this->pengadaan->update([
            'status' => 'disetujui',
            'tanggal_disetujui' => now(),
        ]);

        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Pengadaan berhasil disetujui.'
        ]);

        $this->refreshData();
    }


    // =======================
    //   TOLAK PENGADAAN
    // =======================
    public function openTolakForm()
    {
        $this->showTolakForm = true;
    }

    public function closeTolakForm()
    {
        $this->showTolakForm = false;
        $this->alasan_penolakan = '';
    }

    public function confirmSubmitTolak()
    {
        $this->showTolakForm = false; // ⬅ Tutup form dulu
        $this->dispatch('confirm-tolak');
    }

    public function doTolak()
    {
        if (!$this->alasan_penolakan) {
            $this->dispatch('alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'text' => 'Alasan penolakan wajib diisi.'
            ]);
            return;
        }

        $this->pengadaan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $this->alasan_penolakan,
            'tanggal_selesai' => now(),
        ]);

        $this->closeTolakForm();

        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Ditolak!',
            'text' => 'Pengadaan berhasil ditolak.'
        ]);

        $this->refreshData();
    }


    // =======================
    //   REFRESH DATA
    // =======================
    public function refreshData()
    {
        $this->pengadaan = Pengadaan::with(['pengaju', 'items.barang'])
            ->find($this->pengadaan->id);
    }
}
