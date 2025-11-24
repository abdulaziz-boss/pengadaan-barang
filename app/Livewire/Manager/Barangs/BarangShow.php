<?php

namespace App\Livewire\Manager\Barangs;

use App\Models\Barang;
use Livewire\Component;

class BarangShow extends Component
{
    public $barangId;
    public $barang;

    public function mount($id)
    {
        $this->barangId = $id;
        $this->loadBarang();
    }

    public function loadBarang()
    {
        $this->barang = Barang::with('category')->findOrFail($this->barangId);
    }

    public function render()
    {
        return view('livewire.manager.barangs.barang-show');
    }
}
