<?php

namespace App\Livewire\Admin\Barangs;

use App\Models\Barang;
use App\Models\Category;
use Livewire\Component;

class BarangEdit extends Component
{
    public $barang;
    public $nama_barang;
    public $nama_kategori;
    public $stok;
    public $stok_minimal;
    public $satuan;
    public $harga_satuan;

    public function mount($id)
    {
        $this->barang = Barang::with('category')->findOrFail($id);
        $this->nama_barang = $this->barang->nama;
        $this->nama_kategori = $this->barang->category->nama;
        $this->stok = $this->barang->stok;
        $this->stok_minimal = $this->barang->stok_minimal;
        $this->satuan = $this->barang->satuan;
        $this->harga_satuan = $this->barang->harga_satuan;
    }

    protected $rules = [
        'stok' => 'required|integer|min:0',
        'stok_minimal' => 'required|integer|min:0',
        'satuan' => 'required|string|max:50',
        'harga_satuan' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'stok.required' => 'Stok wajib diisi.',
        'stok_minimal.required' => 'Stok minimal wajib diisi.',
        'satuan.required' => 'Satuan wajib diisi.',
        'harga_satuan.required' => 'Harga satuan wajib diisi.',
        'stok.min' => 'Stok tidak boleh kurang dari 0.',
        'stok_minimal.min' => 'Stok minimal tidak boleh kurang dari 0.',
        'harga_satuan.min' => 'Harga satuan tidak boleh kurang dari 0.',
    ];

    public function update()
    {
        $this->validate();

        // Update data barang (hanya field yang diizinkan)
        $this->barang->update([
            'stok' => $this->stok,
            'stok_minimal' => $this->stok_minimal,
            'satuan' => $this->satuan,
            'harga_satuan' => $this->harga_satuan,
        ]);

        $this->dispatch('barang-berhasil-diupdate');
    }

    public function render()
    {
        return view('livewire.admin.barangs.edit');
    }
}
