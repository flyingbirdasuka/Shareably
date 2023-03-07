<?php

namespace App\Http\Livewire\Practice;

// use File;
use Storage;
use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class PracticeEdit extends Component
{
    use WithFileUploads;
    
    public $practice;
    public $title;
    public $description;
    public $original_file;
    public $original_file_name;
    public $new_file;
    public $all_categories = [];
    public $add_categories = [];
    public $isUploaded=false;

    protected $rules = [
        'add_categories' => 'requried',
    ];

    protected $message = [
        'title.required' => 'The Title cannot be empty.',
        'new_file.*' => 'This file type is not supported'
    ];

    public function mount($id)
    {
        $this->practice = Practice::find($id);
        $this->title = $this->practice->title;
        $this->description = $this->practice->description;
        $this->original_file_name = $this->practice->musicsheets()->get()->first()->filename;
        $this->original_file = asset('practice/' . $this->original_file_name);
        $this->all_categories = Category::orderBy('title')->get();
        // (THIS WORKS AND DONT CHANGE THE VALUE IN THE VIEW)
        $this->add_categories = $this->practice->categories()->pluck('categories.id')->all();
       
    }

    public function updatedNewFile($value)
    {
        $this->isUploaded = true;
        $this->validate([
            'new_file' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:1024',
        ]);
    }

    public function update_practice()
    {
        // !!! check validation later

        // $this->validate();

        Practice::where('id', $this->practice->id)->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        if($this->new_file){
            Storage::delete('/practice/'.$this->original_file_name); // delete the file
            $this->practice->musicsheets()->delete(); // delete the previous musicsheet in DB
            $this->practice->musicsheets()->detach(); // detach the relationship

            // add the new file
            $new_filename = $this->new_file->getClientOriginalName();
            $this->practice->musicsheets()->create([
                'title' => $this->title,
                'filename' => $new_filename,
            ]);
            $this->new_file->storeAs('/', $new_filename, $disk = 'practice');
        }
    

        // update the attatched categories
        // remove the original category for this practice (THIS WORKS)
        foreach($this->practice->categories()->get() as $original_category){
            $this->practice->categories()->detach($original_category);
        }
        // add the new categories into this practice (THIS WORKS)
        foreach ($this->add_categories as $category_id){
            $this->practice->categories()->attach($category_id);
        }
        
        session()->flash('message', 'Practice successfully added.');
        return redirect()->to('/practices');
    }
    public function render()
    {
        return view('livewire.practice.practice-edit');
    }
}