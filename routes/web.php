<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\CategoryEdit;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\Logs\LogIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\CategoryCreate;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Staff\DashboardStaff;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StaffMiddleware;
use App\Http\Middleware\ManagerMiddleware;
use App\Livewire\Admin\Barangs\BarangEdit;
use App\Livewire\Admin\Barangs\BarangShow;
use App\Livewire\Manager\DashboardManager;
use App\Livewire\Admin\Barangs\BarangIndex;
use App\Livewire\Admin\Profile\ProfileEdit;
use App\Livewire\Admin\Barangs\BarangCreate;
use App\Livewire\Admin\Profile\ProfileIndex;
use App\Livewire\Admin\Usermanagement\UserEdit;
use App\Livewire\Admin\Pengadaans\PengadaanShow;
use App\Livewire\Admin\Usermanagement\UserIndex;
use App\Livewire\Admin\Usermanagement\UserCreate;
use App\Livewire\Staff\Pengadaanitem\PengadaanIndex;
use App\Livewire\Admin\Pengadaans\PengadaanIndex as AdminPengadaanIndex;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', Login::class)->name('login');
Route::prefix('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
});

Route::prefix('admin')->middleware(['auth', AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/', DashboardAdmin::class)->name('dashboard');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/categories/create', CategoryCreate::class)->name('categories.create');
    Route::get('/categories/edit/{id}', CategoryEdit::class)->name('categories.edit');

    Route::get('/barangs', BarangIndex::class)->name('barangs.index');
    Route::get('/barangs/create', BarangCreate::class)->name('barangs.create');
    Route::get('/barangs/edit/{id}', BarangEdit::class)->name('barangs.edit');
    Route::get('/barangs/show/{id}', BarangShow::class)->name('barangs.show');

    Route::get('/pengadaans', AdminPengadaanIndex::class)->name('pengadaans.index');
    Route::get('/pengadaans/{id}', PengadaanShow::class)->name('pengadaans.show');

    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/users/create', UserCreate::class)->name('users.create');
    Route::get('/users/edit/{id}', UserEdit::class)->name('users.edit');

    Route::get('/logs', LogIndex::class)->name('logs.index');

    Route::get('/profile', ProfileIndex::class)->name('profile.index');
    Route::get('/profile/edit', ProfileEdit::class)->name('profile.edit');

});

Route::prefix('manager')->middleware(['auth', ManagerMiddleware::class])->name('manager.')->group(function () {
    Route::get('/', DashboardManager::class)->name('dashboard');
});

Route::prefix('staff')->middleware(['auth', StaffMiddleware::class])->name('staff.')->group(function () {
    Route::get('/', DashboardStaff::class)->name('dashboard');
    Route::get('/pengadaan', PengadaanIndex::class)->name('pengadaanitem.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});
