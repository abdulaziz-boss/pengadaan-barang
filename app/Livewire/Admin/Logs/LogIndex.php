<?php

namespace App\Livewire\Admin\Logs;

use App\Models\Log;
use Livewire\Component;
use Livewire\WithPagination;

class LogIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';

    // Dengarkan event deleteConfirmed
    protected $listeners = ['deleteConfirmed' => 'deleteLog'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Menampilkan SweetAlert konfirmasi
    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', id: $id);
    }

    // Hapus log berdasarkan ID - parameter langsung $id
    public function deleteLog($id)
    {
        $log = Log::find($id);

        if ($log) {
            $log->delete();
            // Dispatch event untuk notifikasi sukses
            $this->dispatch('show-delete-success');
        }
    }

    public function render()
    {
        $logs = Log::query()
            ->when($this->search, function ($query) {
                $query->where('table_name', 'like', '%' . $this->search . '%')
                    ->orWhere('action', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest('created_at')
            ->paginate(8);

        return view('livewire.admin.logs.log-index', ['logs' => $logs]);
    }
}
