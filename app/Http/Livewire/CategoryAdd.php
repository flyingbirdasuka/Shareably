<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryAdd extends Component
{
    public $title ='';
    public $description = '';

    protected $rules = [
        'title' => 'required',
    ];

    protected $message = [
        'title.required' => 'The Title cannot be empty.',
    ];

    public function add()
    {
        $this->validate();

        Category::insert([
            'title' => $this->title,
            'description' => $this->description,
        ]);
        session()->flash('message', 'Category successfully added.');
        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category-add');
    }
}