<?php

namespace App\Livewire\Admin\Pengadaans;

use Livewire\Component;
use App\Models\Pengadaan;

class PengadaanShow extends Component
{
    public $pengadaan;

    public function mount($id)
    {
        $this->pengadaan = Pengadaan::with('pengaju')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.pengadaans.show');
    }
}
