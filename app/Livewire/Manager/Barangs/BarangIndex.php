<?php

namespace App\Livewire\Manager\Barangs;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class BarangIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $barangs = Barang::with('category')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('category', function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama', 'asc')
            ->paginate(10);

        return view('livewire.manager.barangs.barang-index', [
            'barangs' => $barangs,
        ]);
    }
}
