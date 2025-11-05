<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileIndex extends Component
{
    public $name;
    public $email;
    public $role;
    public $avatar;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->avatar = $user->avatar_url;
    }

    public function render()
    {
        return view('livewire.admin.profile.index');
    }
}
