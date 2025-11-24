<?php

namespace App\Livewire\Manager\Usermanagement;

use App\Models\User;
use Livewire\Component;

class UserShow extends Component
{
    public $userId;
    public $user;

    public function mount($id)
    {
        $this->userId = $id;
        $this->loadUser();
    }

    public function loadUser()
    {
        $this->user = User::findOrFail($this->userId);
    }

    public function render()
    {
        return view('livewire.manager.usermanagement.user-show');
    }
}
