<?php

namespace App\Livewire\Admin\Usermanagement;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserEdit extends Component
{
    public $user_id, $name, $email, $password, $role;

    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required|in:admin,manager,staff',
            'password' => 'nullable|min:8',
        ]);

        $user = User::findOrFail($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // ✅ kirim event ke JS SweetAlert
        $this->dispatch('user-berhasil-diupdate');
    }

    public function render()
    {
        return view('livewire.admin.usermanagement.edit');

    }
}


