<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use App\Models\MusicSheet;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;

class PracticeDetails extends Component
{
    public $practice;
    public $practice_file;
    public $categories;
    public $pdf;
    public $video_id;
    public $video_type;
    public $music;
    public $is_admin;

    public function mount($id)
    {
        $this->practice = Practice::find($id);
        $this->practice_file = $this->practice->musicsheets()->get()->first()->filename;
        $this->pdf = asset('practice/' . $this->practice_file);
        $this->categories = $this->practice->categories()->orderBy('title')->get();
        if($this->practice->video_type == '1'){
            $this->video_id = 'https://drive.google.com/file/d/' . $this->practice->video_id .'/preview';
        } else if($this->practice->video_type == '2'){
            $this->video_id = 'https://www.youtube.com/embed/' . $this->practice->video_id;
        }

        $this->is_admin = auth()->user()->is_admin;

        if($this->practice->musics()->first() != null){
            $this->music = asset('practice/'.$this->practice->musics()->first()->filename);
        }
        if(!$this->is_admin){
            DB::table('page_view_data')->insert([
                'user_id' => auth()->user()->id,
                'page_name' => 'practice_'.$id,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.practice.practice-details');
    }
}
