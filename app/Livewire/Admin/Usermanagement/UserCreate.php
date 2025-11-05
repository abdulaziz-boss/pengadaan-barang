<?php

namespace App\Livewire\Admin\Usermanagement;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Component
{
    public $name, $email, $password, $role = 'staff';
    public $isOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required|in:admin,manager,staff',
    ];

    public function render()
    {
        return view('livewire.admin.usermanagement.create');
    }

    public function openModal()
    {
        $this->resetInput();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->dispatch('user-berhasil-disimpan'); // Trigger SweetAlert

        $this->closeModal();
        $this->resetInput();

        $this->dispatch('refreshUserList'); // 🔁 untuk me-refresh daftar user di komponen Index
    }

    private function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'staff';
    }
}
