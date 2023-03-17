<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Models\Category;

class AddCategory extends ModalComponent
{
    public $user;
    public $categories = [];
    public $all_categories = [];

    public function mount($user, $categories)
    {
        $this->user = $user;
        $this->categories = $categories;
        $this->all_categories = Category::orderBy('title')->get();
    }

    public function render()
    {
        return view('livewire.users.add-category');
    }
}
