<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Practice;
use App\Models\User;
use DB;
use Carbon\Carbon;

class PracticeSection extends Component
{
    use WithPagination;

    public $practices=[];
    public $user;
    public $is_admin;
    public $search = '';
    public $user_practices = [];

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->practices = $this->user->is_admin ? Practice::orderBy('title')->get() : $this->user->practices()->orderBy('title')->get();
        $this->is_admin = $this->user->is_admin;
        $this->user_practices = $this->user->practices()->pluck('practices.id')->all();
        if(!$this->is_admin){
            DB::table('page_view_data')->insert([
                'user_id' => $this->user->id,
                'page_name' => 'practice',
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }

    public function updatedSearch()
    {
        if($this->is_admin){
            $this->practices = Practice::search('title', $this->search)->orderBy('title')->get();
        } else {
            if(strlen($this->search) >= 2){
                foreach($this->practices as $key => $practice){
                    if(!str_contains(strtolower($practice->title), strtolower($this->search))){
                        // If the search query is not found in the practices then remove the false results
                        $this->practices->forget($key);
                    }
                }

                // Arrange the final results by alphabetical order
                $this->practices->sortBy('title');
                dd($this->search);
                DB::table('search_words_data')->insert([
                    'user_id' => $this->user->id,
                    'search_word' => 'practice_'.$this->search,
                    "created_at" =>  Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);

            } else {
                $this->practices = $this->user->practices()->orderBy('title')->get();
            }
        }
    }

    // Reset the pagination after search is run
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.practice.practice-section', [
            'practices_list' => Practice::where('title', 'like', '%'.$this->search.'%')->paginate(10),
        ]);

        return view('livewire.practice.practice-section');
    }
}