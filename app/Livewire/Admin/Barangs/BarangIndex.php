<?php

namespace App\Livewire\Admin\Barangs;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class BarangIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';

    // Event listener dari JavaScript
    public $listeners = ['deleteConfirmed' => 'delete'];

    public function confirmDelete($id)
    {
        // kirim event ke JS untuk munculkan SweetAlert
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    public function delete($id)
    {
        $barang = Barang::find($id);

        if ($barang) {
            $barang->delete();
            // kirim event ke JS untuk SweetAlert sukses
            $this->dispatch('barang-deleted');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $barangs = Barang::with('category')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', "%{$this->search}%")
                      ->orWhere('satuan', 'like', "%{$this->search}%")
                      ->orWhereHas('category', function ($q) {
                          $q->where('nama', 'like', "%{$this->search}%");
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('livewire.admin.barangs.index', [
            'barangs' => $barangs
        ]);
    }
}
