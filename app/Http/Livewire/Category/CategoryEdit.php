<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;

class CategoryEdit extends ModalComponent
{
    public $category_id;
    public $title;
    public $description;

    protected $rules = [
        'title' => 'required|unique:categories',
    ];

    protected $message = [
        'title.required' => 'The Title cannot be empty.',
    ];

    public function mount($title, $description)
    {

        $this->title = $title;
        $this->description = $description;
    }

    public function render()
    {
        return view('livewire.category.category-edit');
    }

    public function edit()
    {
        $this->validate();
        
        Category::where('id', $this->category_id)->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $this->closeModal();
        return redirect()->to('/categories');
    }
}