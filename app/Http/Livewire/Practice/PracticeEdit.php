<?php

namespace App\Http\Livewire\Practice;

// use File;
// use Storage;
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

    // protected $rules = [
    //     'add_categories' => 'requried',
    //     'new_file.*' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:1024',
    // ];

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
        $this->all_categories = Category::all();
        // (THIS WORKS AND DONT CHANGE THE VALUE IN THE VIEW)
        $this->add_categories = $this->practice->categories()->pluck('categories.id')->all();
       
    }

    public function updatedNewFile($value)
    {
        // dd('test');
        $this->isUploaded = true;
        // dd($this->isUploaded);
        $this->validate([
            'new_file' => 'file|mimes:jpg,jpeg,png,pdf,docx|max:1024',
        ]);
    }

    public function update_practice()
    {
        // !!! check validation later

        // (THIS WORKS)
        Practice::where('id', $this->practice->id)->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        if($this->new_file){
            // remove the previous file and relationship of previous musicsheet and practice

            // !!! doesnt delete the file 
            // File::delete($this->original_file);
            // dd($this->original_file);
            dd(File::delete($this->original_file));
            // Storage::delete($this->original_file);
            $this->practice->musicsheets()->delete();

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