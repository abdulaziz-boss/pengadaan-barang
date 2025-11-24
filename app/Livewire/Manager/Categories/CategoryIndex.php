<?php

namespace App\Livewire\Manager\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'bootstrap';

    // Reset pagination saat search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::with('barangs')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('nama', 'asc')
            ->paginate(10);

        return view('livewire.manager.categories.category-index', [
            'categories' => $categories,
        ]);
    }
}
