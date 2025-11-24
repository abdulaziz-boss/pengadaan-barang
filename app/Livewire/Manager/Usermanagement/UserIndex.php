<?php

namespace App\Livewire\Manager\Usermanagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
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
        $users = User::where('name', 'like', '%' . $this->search . '%')
                     ->orWhere('email', 'like', '%' . $this->search . '%')
                     ->orderBy('name')
                     ->paginate(10);

        return view('livewire.manager.usermanagement.user-index', [
            'users' => $users
        ]);
    }
}
