<?php

namespace App\Http\Livewire\Practice;

use File;
use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
// use Livewire\WithFileUploads;

class PracticeEdit extends Component
{
    // use WithFileUploads;
    
    public $practice;
    public $title;
    public $description;
    // public $file;
    // public $new_file;
    // public $practice_file;
    public $all_categories = [];
    public $add_categories = [];

    protected $rules = [
        'add_categories' => 'requried',
        // 'new_file.*' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:1024',
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
        // $this->practice_file = $this->practice->musicsheets()->get()->first();
        // $this->file = asset('practice/' . $this->practice_file->filename);
        $this->all_categories = Category::all();
        // (THIS WORKS AND DONT CHANGE THE VALUE IN THE VIEW)
        $this->add_categories = $this->practice->categories()->pluck('categories.id')->all();
       
    }

    // public function submit($id, $formData){
    //     dd($formData);
    // }

    public function update_practice()
    {

        // dd($this->title, $this->practice);
        // $edit_file = $this->new_file? true : false;
        // if($edit_file){ // if the new file is attatched
            // $this->validate();
        // }

        // dd($this->add_categories);
        // update the practice table
        // Practice::where('id', $this->practice->id);

        // (THIS WORKS)
        Practice::where('id', $this->practice->id)->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        // if($edit_file){
        //     // remove the previous file and relationship of previous musicsheet and practice
        //     File::delete($this->file);
        //     // dd($this->practice_file);
        //     $this->file->detach($this->practice_file);

        //     // add the new file
        //     $new_filename = $this->new_file->getClientOriginalName();
        //     $practice->musicsheets()->create([
        //         'title' => $this->title,
        //         'filename' => $new_filename,
        //     ]);
        //     $this->file->storeAs('/', $new_filename, $disk = 'practice');

        // }

        // update the attatched categories

        // remove the original category for this practice (THIS WORKS)
        foreach($this->practice->categories()->get() as $original_category){
            $this->practice->categories()->detach($original_category);
        }
        // add the new categories into this practice (THIS WORKS)
        foreach ($this->add_categories as $category_id){
            $this->practice->categories()->attach($category_id);
        }
        
        // session()->flash('message', 'Practice successfully added.');
        // return redirect()->to('/practices');
    }
    public function render()
    {
        return view('livewire.practice.practice-edit');
    }
}