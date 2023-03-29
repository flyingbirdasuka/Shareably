<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;

class CategoryAdd extends ModalComponent
{
    public $title ='';
    public $description = '';

    protected $rules = [
        'title' => 'required|unique:categories',
    ];

    protected $message = [
        'title.required' => 'The Title cannot be empty.',
    ];

    public function add()
    {
        $this->validate();

        Category::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);
        session()->flash('message', 'Category successfully added.');
        $this->closeModal();
        return redirect()->to('/categories');
    }

    public function render()
    {
        return view('livewire.category.category-add');
    }
}