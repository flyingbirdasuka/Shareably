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

    public function mount()
    {
        $this->all_categories = Category::orderBy('title')->get();
    }

    /*
     *  Real time validation of the chosen file to be uploaded, users don't have to click submit.
     */
    public function updatedFile()
    {

        $this->validate([
            'file' => 'file|mimes:pdf|max:1024',
        ]);
    }

    public function add()
    {
        $this->validate([
                'title' => 'required',
                'add_categories' => 'required',
                'file' => 'required|mimes:pdf|max:1024',

            ],
            [
                'title.required' => 'The Title cannot be empty.',
                'file.required' => 'The file needs to be uploaded. Only PDFs smaller than 1mb can be uploaded.',
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
