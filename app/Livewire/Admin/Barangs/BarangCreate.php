<?php

namespace App\Livewire\Admin\Barangs;

use App\Models\Barang;
use Livewire\Component;
use App\Models\Category;

class BarangCreate extends Component
{
    public $nama_barang, $stok, $stok_minimal, $satuan, $harga_satuan;
    public $modeKategori = 'pilih'; // default mode
    public $kategori_id, $nama_kategori_baru, $deskripsi_kategori;
    public $categories;

    protected $rules = [
        'nama_barang' => 'required|string|max:255',
        'stok' => 'required|integer|min:0',
        'stok_minimal' => 'required|integer|min:0',
        'satuan' => 'required|string|max:50',
        'harga_satuan' => 'required|numeric|min:0',
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updatedModeKategori()
    {
        // Reset field kategori saat mode berubah
        $this->kategori_id = null;
        $this->nama_kategori_baru = null;
        $this->deskripsi_kategori = null;
    }

    public function save()
{
    $this->validate();

    // Cek apakah barang sudah ada
    if (Barang::where('nama', $this->nama_barang)->exists()) {
        $this->addError('nama_barang', 'Barang dengan nama ini sudah ada!');
        return;
    }

    // Tangani mode kategori
    $kategori_id = null;

    if ($this->modeKategori === 'baru') {
        $this->validate([
            'nama_kategori_baru' => 'required|string|max:255',
            'deskripsi_kategori' => 'nullable|string',
        ]);

        // Simpan kategori baru
        $kategori = Category::create([
            'nama' => $this->nama_kategori_baru,
            'deskripsi' => $this->deskripsi_kategori,
        ]);
        $kategori_id = $kategori->id;
    } else {
        $this->validate([
            'kategori_id' => 'required|exists:categories,id',
        ]);

        $kategori_id = $this->kategori_id;
    }

    // Pastikan kategori_id sudah ada sebelum insert
    if (!$kategori_id) {
        $this->addError('kategori_id', 'Kategori belum dipilih!');
        return;
    }

    // Simpan barang baru
    Barang::create([
        'nama' => $this->nama_barang,
        'category_id' => $kategori_id,
        'stok' => $this->stok,
        'stok_minimal' => $this->stok_minimal,
        'satuan' => $this->satuan,
        'harga_satuan' => $this->harga_satuan,
    ]);

    $this->dispatch('barang-berhasil-ditambah');
    
}

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.admin.barangs.create');
    }
}
