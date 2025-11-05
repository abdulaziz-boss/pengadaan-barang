<?php

namespace App\Livewire\Admin\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $avatar;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save()
    {
        // Validasi untuk data profil
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'avatar' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6|same:password_confirmation',
        ]);

        $user = Auth::user();

        // Update avatar jika ada
        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Update data profil
        $user->name = $this->name;
        $user->email = $this->email;

        // Update password jika diisi
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Reset field password
        $this->reset(['password', 'password_confirmation']);

        // Kirim event untuk SweetAlert dan redirect
        $this->dispatch('showSweetAlert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Profil berhasil diperbarui!',
            'redirectUrl' => route('admin.profile.index')
        ]);
    }

    public function render()
    {
        return view('livewire.admin.profile.edit');
    }
}
