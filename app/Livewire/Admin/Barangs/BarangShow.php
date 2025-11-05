<?php

namespace App\Livewire\Admin\Barangs;

use App\Models\Barang;
use Livewire\Component;

class BarangShow extends Component
{
    public $barang;
    public $nama_barang;
    public $nama_kategori;
    public $stok;
    public $stok_minimal;
    public $satuan;
    public $harga_satuan;
    public $created_at;
    public $updated_at;

    public function mount($id)
    {
        $this->barang = Barang::with('category')->findOrFail($id);
        $this->nama_barang = $this->barang->nama;
        $this->nama_kategori = $this->barang->category->nama;
        $this->stok = $this->barang->stok;
        $this->stok_minimal = $this->barang->stok_minimal;
        $this->satuan = $this->barang->satuan;
        $this->harga_satuan = $this->barang->harga_satuan;
        $this->created_at = $this->barang->created_at;
        $this->updated_at = $this->barang->updated_at;
    }

    public function render()
    {
        return view('livewire.admin.barangs.show');
    }
}

