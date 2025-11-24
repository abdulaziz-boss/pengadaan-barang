<?php

namespace App\Livewire\Manager\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileIndex extends Component
{
    public $name;
    public $email;
    public $role;
    public $avatar;

    public function mount()
    {
        $user = Auth::user();

        $this->name  = $user->name;
        $this->email = $user->email;
        $this->role  = $user->role;

        // URL avatar (otomatis default jika null)
        $this->avatar = $user->avatar
            ? asset('storage/' . $user->avatar)
            : asset('images/default-avatar.png');
    }

    public function render()
    {
        return view('livewire.manager.profile.profile-index');
    }
}
