<?php

namespace App\Livewire\Manager\RiwayatPengadaan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengadaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class RiwayatpengadaanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;

    // selected as associative array: [id => true, id2 => true]
    public $selected = [];

    // helper flags
    public $selectPage = false;   // select all items on current page
    public $selectAll = false;    // select across all pages

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'deleteConfirmed' => 'deleteSelected',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectPage = false;
        $current = $this->currentPageIds();
        foreach ($current as $id) {
            unset($this->selected[$id]);
        }
    }

    protected function baseQuery()
    {
        return Pengadaan::with(['pengaju', 'items.barang.category'])
            ->whereIn('status', ['disetujui', 'ditolak', 'selesai'])
            ->when($this->search, function ($q) {
                $s = "%{$this->search}%";
                $q->where('kode_pengadaan', 'like', $s)
                  ->orWhereHas('pengaju', fn($u) => $u->where('name', 'like', $s))
                  ->orWhereHas('items.barang', fn($b) => $b->where('nama', 'like', $s))
                  ->orWhereHas('items.barang.category', fn($c) => $c->where('nama', 'like', $s));
            })
            ->orderBy('created_at', 'desc');
    }

    protected function currentPageIds()
    {
        $p = $this->baseQuery()->paginate($this->perPage);
        return $p->pluck('id')->toArray();
    }

    public function updatedSelectPage($value)
    {
        $current = $this->currentPageIds();

        if ($value) {
            foreach ($current as $id) {
                $this->selected[$id] = true;
            }
        } else {
            foreach ($current as $id) {
                unset($this->selected[$id]);
            }
            $this->selectAll = false;
        }
    }

    public function selectAllAcrossPages()
    {
        $this->selectAll = true;
        $this->selectPage = true;

        $ids = Pengadaan::whereIn('status', ['disetujui', 'ditolak', 'selesai'])
            ->pluck('id')->toArray();

        $this->selected = [];
        foreach ($ids as $id) {
            $this->selected[$id] = true;
        }
    }

    public function unselectAll()
    {
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }

    public function deleteSelected()
    {
        $ids = array_keys(array_filter($this->selected));
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada data yang dipilih.');
            return;
        }

        Pengadaan::whereIn('id', $ids)->delete();

        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;

        session()->flash('success', 'Data terpilih berhasil dihapus.');
        $this->resetPage();
    }

    // Export Excel
    public function exportExcel()
    {
        $ids = array_keys(array_filter($this->selected));

        if (empty($ids)) {
            session()->flash('error', 'Tidak ada data yang dipilih.');
            return null;
        }

        $pengadaans = Pengadaan::with(['pengaju', 'items.barang.category'])
            ->whereIn('id', $ids)
            ->get();

        return Excel::download(new class($pengadaans) implements FromView, ShouldAutoSize {
            protected $pengadaans;

            public function __construct($pengadaans)
            {
                $this->pengadaans = $pengadaans;
            }

            public function view(): View
            {
                return view('exports.pengadaan-excel', [
                    'data' => $this->pengadaans
                ]);
            }
        }, 'riwayat_pengadaan.xlsx');
    }

    // Export PDF
    public function exportPdf()
    {
        $ids = array_keys(array_filter($this->selected));
        if (empty($ids)) {
            session()->flash('error', 'Tidak ada data yang dipilih.');
            return null;
        }

        $data = Pengadaan::with(['pengaju','items.barang.category'])->whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('exports.pengadaan-pdf', ['data' => $data])
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'riwayat_pengadaan.pdf');
    }

    public function render()
    {
        $pengadaans = $this->baseQuery()->paginate($this->perPage);

        return view('livewire.manager.riwayatpengadaan.riwayatpengadaan-index', [
            'pengadaans' => $pengadaans,
        ]);
    }
}
