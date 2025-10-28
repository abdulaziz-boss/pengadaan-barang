<?php

namespace App\Livewire\Admin\Barangs;

use App\Models\Barang;
use Livewire\Component;

class BarangIndex extends Component
{
    public $search = '';

    public function delete($id)
    {
        Barang::findOrFail($id)->delete();
        session()->flash('success', 'Barang berhasil dihapus!');
    }

    public function render()
    {
        $barangs = Barang::with('category')
            ->where('nama', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.barangs.index', [
            'barangs' => $barangs
        ]);
    }
}
