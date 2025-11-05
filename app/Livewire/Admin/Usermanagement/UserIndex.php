<?php

namespace App\Livewire\Admin\Usermanagement;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithPagination;

    public $name, $email, $password, $role, $user_id;
    public $search = '';
    public $isOpen = false;
    public $deleteId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,manager,staff'
    ];

    // 🔥 Listener untuk menangkap event dari JS SweetAlert
    protected $listeners = ['deleteConfirmed' => 'delete'];

    public function render()
    {
        $users = User::when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
        })->latest()->paginate(10);

        return view('livewire.admin.usermanagement.index', compact('users'));
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        // 🧨 Kirim event ke browser untuk munculkan SweetAlert
        $this->dispatch('show-delete-confirmation');
    }

    public function delete()
    {
        if (!$this->deleteId) {
            session()->flash('error', 'ID user tidak valid.');
            return;
        }

        if ($this->deleteId == auth()->id()) {
            session()->flash('error', 'Tidak dapat menghapus akun sendiri.');
            return;
        }

        $user = User::find($this->deleteId);

        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.');
            return;
        }

        $user->delete();

        $this->deleteId = null;

        // 🧨 Kirim event sukses ke browser
        $this->dispatch('user-deleted');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
