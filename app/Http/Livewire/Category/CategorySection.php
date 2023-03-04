<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\User;

class CategorySection extends Component
{
    public $categories;
    public $user;

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->categories = $user->is_admin ? Category::all() : User::find($user)->first()->categories()->get();
    }

    public function render()
    {
        return view('livewire.category.category-section');
    }


}
