<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use App\Models\Practice;
use App\Models\MusicSheet;
use Illuminate\Support\Facades\Storage;

class PracticeDetails extends Component
{
    public $practice;
    public $practice_file;
    public $categories;
    public $pdf;
    public $video_id;
    public $music;

    public function mount($id)
    {
        $this->practice = Practice::find($id);
        $this->practice_file = $this->practice->musicsheets()->get()->first()->filename;
        $this->pdf = asset('practice/' . $this->practice_file);
        $this->categories = $this->practice->categories()->orderBy('title')->get();
        $this->video_id = $this->practice->video_id;

        if($this->practice->musics()->first() != null){
            // $this->music = asset('practice/641eea60cf72b-tv5mE42plkcOmYC93CU9HkjLH0tFzc-metaRmxvd2VyeSBib3VuY2UubXAz-.mp3');
            $this->music = asset('practice/'.$this->practice->musics()->first()->filename);
        }
    }

    public function render()
    {
        return view('livewire.practice.practice-details');
    }
}
