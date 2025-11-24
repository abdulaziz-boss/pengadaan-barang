<?php

namespace App\Livewire\Manager\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $avatar; // Input file
    public $currentAvatar; // Hanya untuk preview

    public function mount()
    {
        $user = Auth::user();

        $this->name  = $user->name;
        $this->email = $user->email;

        $this->currentAvatar = $user->avatar
            ? asset('storage/' . $user->avatar)
            : asset('images/default-avatar.png');
    }

    public function save()
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'avatar'   => 'nullable|image|max:2048',
            'password' => 'nullable|min:6|same:password_confirmation',
        ]);

        $user = Auth::user();

        // Jika upload avatar baru
        if ($this->avatar) {

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name  = $this->name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->reset(['password', 'password_confirmation']);

        $this->dispatch('showSweetAlert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Profil berhasil diperbarui!',
            'redirectUrl' => route('manager.profile.index')
        ]);
    }

    public function render()
    {
        return view('livewire.manager.profile.profile-edit');
    }
}
