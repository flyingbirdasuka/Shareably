<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\User;

class CategorySection extends Component
{
    public $categories;
    public $user;
    public $is_admin = false;

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->categories = $user->is_admin ? Category::orderBy('title')->get() : User::find($user)->first()->categories()->orderBy('title')->get();
        $this->is_admin = $user->is_admin && true;
    }

    public function render()
    {
        return view('livewire.category.category-section');
    }


}
