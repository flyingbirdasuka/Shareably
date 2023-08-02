<?php

namespace App\Http\Livewire\Practice;

use Storage;
use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use App\Traits\GoogleSetup;

class PracticeEdit extends Component
{
    use GoogleSetup;
    use WithFileUploads;
    
    public $practice;
    public $title;
    public $description;
    public $video_id;
    public $video_type;
    public $original_file;
    public $original_file_name;
    public $new_file;
    public $new_music;
    public $original_music;
    public $original_music_name;
    public $all_categories = [];
    public $add_categories = [];
    public $showDropdown = false;
    public $original_music_removed = false;

    protected $rules = [
        'title' => 'required',
        'add_categories' => 'required',
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
        $this->video_id = $this->practice->video_id;
        $this->video_type = $this->practice->video_type;
        $this->original_file_name = $this->practice->musicsheets()->first()->filename;
        $this->original_file = asset('practice/' . $this->original_file_name);
        if($this->practice->musics()->first() != null) {
            $this->original_music_name = $this->practice->musics()->first()->filename;
            $this->original_music = asset('practice/' . $this->original_music_name);
        }
        $this->all_categories = Category::orderBy('title')->get();
        $this->add_categories = $this->practice->categories()->pluck('categories.id')->all();
       
    }

    /*
     *  Real time validation of the chosen file to be uploaded, users don't have to click submit.
     */
    public function updatedNewFile($value)
    {
        $this->validate([
            'new_file' => 'file|mimes:pdf|max:1024',
        ]);
    }

    /*
     *  Real time validation of the chosen title to check if it is unique, users don't have to click submit.
     */
    public function updatedTitle()
    {
        $this->validate([
            'title' => ['required', Rule::unique('practices')->ignore($this->practice)],
        ]);
    }

     // remove the original music when the remove button was clicked
     protected $listeners = [
        'removeMusic'
    ];

    public function removeMusic()
    {
        Storage::delete('/practice/'.$this->original_music_name); // delete the file
        $this->practice->musics()->delete(); // delete the previous musicsheet in DB
        $this->practice->musics()->detach(); // detach the relationship
        $this->original_music_name = '';
        $this->original_music = '';
    }

    public function update_practice()
    {

        $this->validate();

        if($this->video_id != ''){
            $this->validate([
                'video_type' => 'required',
            ]);
        }
        Practice::where('id', $this->practice->id)->update([
            'title' => $this->title,
            'description' => $this->description,
            'video_id' => $this->video_id,
            'video_type' => $this->video_type
        ]);

        // where a new PDF is uploaded
        if($this->new_file){
            Storage::delete('/practice/'.$this->original_file_name); // delete the file
            $this->practice->musicsheets()->delete(); // delete the previous musicsheet in DB
            $this->practice->musicsheets()->detach(); // detach the relationship

            // add the new file
            $new_filename = $this->new_file->getClientOriginalName();
            $new_unique_name = uniqid().'-'.$new_filename;
            $this->practice->musicsheets()->create([
                'title' => $this->title,
                'filename' =>$new_unique_name,
            ]);
            $this->new_file->storeAs('/', $new_unique_name, $disk = 'practice');
        }

        // // where a new music is uploaded
        if($this->new_music){
            Storage::delete('/practice/'.$this->original_music_name); // delete the file
            $this->practice->musics()->delete(); // delete the previous musicsheet in DB
            $this->practice->musics()->detach(); // detach the relationship

        //     // add the new file
            $new_music_filename = $this->new_music->getClientOriginalName();
            $new_music_unique_name = uniqid().'-'.$new_music_filename;
            $this->practice->musics()->create([
                'title' => $this->title,
                'filename' => $new_music_unique_name,
            ]);
            $this->new_music->storeAs('/', $new_music_unique_name, $disk = 'practice');
        }
    

        $original_categories = Practice::find($this->practice->id)->categories()->get()->pluck('id')->toArray();

        // if the category is added new then attatch to the category
        foreach($this->add_categories as $category_id){
            if(!in_array(intval($category_id), $original_categories)){
                // attatch the user to the category
                $users = Category::find($category_id)->users()->where('is_admin',0)->get()->pluck('id')->toArray();
                foreach($users as $user){
                    $this->addToGoogleDrive($user, $this->practice->video_id, $category_id, '+3 days');
                    // the expiration date is for test purpose. Replace with the lower version later
                    // $this->addToGoogleDrive($user, $this->practice->video_id, $category_id);
                }
                Category::where('id',$category_id)->first()->practices()->attach($this->practice->id);
            }
        }


        // if the category was removed then detach from the category
        foreach($original_categories as $category_id){
            if(!in_array(intval($category_id), $this->add_categories)){
                // if the practice has a google drive video then remove the user permission
                $practices = Category::find($category_id)->practices()->get()->where('video_type',1);
                foreach($practices as $practice){
                    $users = Category::find($category_id)->users()->where('is_admin',0)->get()->pluck('id')->toArray();
                    foreach($users as $user){
                        $this->removeFromGoogleDrive($user, $practice->video_id, $category_id);
                    }
                }
                $this->practice->categories()->detach($category_id);
            }
        }


        return redirect()->to('/practices');
    }
    public function render()
    {
        return view('livewire.practice.practice-edit');
    }
}