<?php

namespace App\Livewire\Manager\Pengadaans;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengadaan;

class PengadaanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 8;

    // Bulk Delete
    public $selected = [];
    public $selectAll = false;

    // Modal Penolakan
    public $showTolakForm = false;
    public $alasan_penolakan = '';
    public $tolakId;

    protected $paginationTheme = 'bootstrap';

    // LISTENER EVENT DARI SWEETALERT
    protected $listeners = [
        'doSetujui' => 'setujui',
        'doTolak' => 'executeTolak',
        'closeTolakForm' => 'closeTolakForm',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function baseQuery()
    {
        return Pengadaan::withTrashed()
            ->with(['pengaju', 'items.barang'])
            ->where('status', 'diproses') // hanya tampilkan status diproses
            ->when($this->search, function ($q) {
                $q->where('kode_pengadaan', 'like', "%{$this->search}%")
                  ->orWhereHas('pengaju', fn($u) =>
                      $u->where('name', 'like', "%{$this->search}%")
                  )
                  ->orWhereHas('items.barang', fn($b) =>
                      $b->where('nama', 'like', "%{$this->search}%")
                  );
            })
            ->orderBy('created_at', 'desc');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $currentPage = $this->getPage();
            $paginator = $this->baseQuery()
                ->paginate($this->perPage, ['*'], 'page', $currentPage);

            $this->selected = $paginator->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedPage()
    {
        $this->selectAll = false;
    }

    public function deleteSelected()
    {
        if (count($this->selected) === 0) {
            $this->dispatch('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Tidak ada item yang dipilih.'
            ]);
            return;
        }

        Pengadaan::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->selectAll = false;

        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Pengadaan terpilih berhasil dihapus!'
        ]);
    }

    // === SWEETALERT CONFIRM ===
    public function confirmSetujui($id)
    {
        $this->dispatch('confirm-setujui', id: $id);
    }

    public function confirmSubmitTolak()
    {
        $this->dispatch('confirm-tolak');
    }

    // === SETUJUI ===
    public function setujui($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->status = 'disetujui';
        $pengadaan->tanggal_disetujui = now();
        $pengadaan->save();

        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Pengajuan berhasil disetujui.'
        ]);
    }

    // === BUKA FORM TOLAK ===
    public function openTolakForm($id)
    {
        $this->tolakId = $id;
        $this->showTolakForm = true;
    }

    public function closeTolakForm()
    {
        $this->showTolakForm = false;
        $this->alasan_penolakan = '';
        $this->dispatch('modal-closed');
    }

    // === TOLAK (SETELAH SWEETALERT) ===
    public function executeTolak()
    {
        $pengadaan = Pengadaan::findOrFail($this->tolakId);
        $pengadaan->status = 'ditolak';
        $pengadaan->alasan_penolakan = $this->alasan_penolakan;
        $pengadaan->tanggal_selesai = now();
        $pengadaan->save();

        $this->closeTolakForm();

        $this->dispatch('alert', [
            'type' => 'success',
            'title' => 'Ditolak!',
            'text' => 'Pengadaan berhasil ditolak.'
        ]);
    }

    public function render()
    {
        return view('livewire.manager.pengadaans.pengadaan-index', [
            'pengadaans' => $this->baseQuery()->paginate($this->perPage),
        ]);
    }
}
