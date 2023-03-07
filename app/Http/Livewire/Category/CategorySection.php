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
    public $search;

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->categories = $user->is_admin ? Category::all() : User::find($user)->first()->categories()->get();
        $this->is_admin = $user->is_admin && true;
    }

    public function updatedSearch()
    {
        if($this->is_admin){
            $this->categories = Category::search('title', $this->search)->get();
        } else {
            if($this->search !=''){
                foreach($this->categories as $key => $category){
                    if(!str_contains(strtolower($category->title), strtolower($this->search))){
                        // If the search query is not found in the practices then remove the false results
                        $this->categories->forget($key);
                    }
                }
                // dd($this->categories);
            } else {
                $this->categories = User::find(auth()->user())->first()->categories()->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.category.category-section');
    }


}
