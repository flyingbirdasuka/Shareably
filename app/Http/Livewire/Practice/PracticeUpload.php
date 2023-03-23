<?php

namespace App\Http\Livewire\Practice;


use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use App\Models\MusicSheet;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPractice;

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

        $url = url("/practices/{$practice->id}");

        $all_users = [];
        foreach ($this->add_categories as $category_id){
            $users = Category::find($category_id)->users()->get();
            foreach($users as $user){
                !$user->is_admin && array_push($all_users,['email'=> $user->email,'name' => $user->name]);
            }
        }
        $unique_users = array_map("unserialize",array_unique(array_map("serialize", $all_users)));
        foreach(array_unique($unique_users) as $user){
            $name = $user['name'];
            Mail::to($user['email'])->send(new NewPractice($practice, $url, $name));
        }


        session()->flash('message', 'Practice successfully added.');
        return redirect()->to('/practices');
    }

    public function render()
    {
        return view('livewire.practice.practice-upload');
    }
}