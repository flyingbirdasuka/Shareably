<?php

namespace App\Http\Livewire\Practice;


use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use App\Models\MusicSheet;
use Livewire\WithFileUploads;

class PracticeUpload extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $file;
    public $all_categories = [];
    public $add_categories = [];

    protected $rules = [
        'file.*' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:1024'
    ];

    protected $message = [
        'title.required' => 'The Title cannot be empty.',
        'file.*' => 'This file type is not supported'
    ];

    public function mount()
    {
        $this->all_categories = Category::all();
    }
    public function updated()
    {
        $this->validate();
    }
    
    public function add()
    {
        $this->validate();

        $practice = Practice::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $filename = $this->file->getClientOriginalName();
        $practice->musicsheets()->create([
            'title' => $this->title,
            'filename' => $filename,
        ]);
        
        $this->file->storeAs('/', $filename, $disk = 'practice');

        foreach ($this->add_categories as $category_id){
            $practice->categories()->attach($category_id);
        }
        
        session()->flash('message', 'Practice successfully added.');
        return redirect()->to('/practices');
    }

    public function render()
    {
        return view('livewire.practice.practice-upload');
    }
}
