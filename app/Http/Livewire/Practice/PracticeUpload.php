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
    public $showDropdown = false;

    // protected $rules = [
    //     'title' => 'required',
    //     'file' => 'required'
    // ];

    // protected $message = [
    //     'title.required' => 'The Title cannot be empty.',
    //     'file.required' => 'The file needs to be uploaded', 
    //     'file.mimes' => 'This file type is not supported',
    //     'file.max' => 'This file is too big'
    // ];

    public function mount()
    {
        $this->all_categories = Category::orderBy('title')->get();


    }

    // public function updatedFile($propertyName)
    // {
    //     $test = $this->validateOnly($propertyName, [
    //         'file' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:1024',
    //     ]);
    //     dd($test);

        
    // }

    public function add()
    {
        // $this->validate();

        // dd($this->files);
        $this->validate([
                'title' => 'required',
                'file' => 'required|mimes:pdf|max:1024',

            ],
            [
                'title.required' => 'The Title cannot be empty.',
                'file.required' => 'The file needs to be uploaded.',
            ],
        );

        $practice = Practice::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $filename = $this->file->getClientOriginalName();
        $unique_name = uniqid().'-'.$filename;
        $practice->musicsheets()->create([
            'title' => $this->title,
            'filename' => $unique_name
        ]);
        
        $this->file->storeAs('/', $unique_name, $disk = 'practice');

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
