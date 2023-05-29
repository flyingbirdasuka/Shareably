<?php

namespace App\Http\Livewire\Practice;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Practice;
use App\Models\Category;
use App\Models\User;
use DB;
use Carbon\Carbon;

class PracticeSection extends Component
{
    use WithPagination;

    // public $practices=[];

    public $user;
    public $is_admin;
    public $search = '';
    public $categories;
    public $user_practices = [];

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->categories = Category::all()->count();
        /*
        $this->practices = $this->user->is_admin ? Practice::orderBy('title')->get() : $this->user->practices()->orderBy('title')->get();
        $this->is_admin = $this->user->is_admin;
        $this->user_practices = $this->user->practices()->pluck('practices.id')->all();
        */

        // Capture the page view data for analytics
        $this->is_admin = $this->user->is_admin && true;
        if(!$this->is_admin){
            DB::table('page_view_data')->insert([
                'user_id' => $this->user->id,
                'page_name' => 'category',
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }

    public function updatedSearch()
    {
        /* Descoped
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
        */
    }

    // Reset the pagination after search is run
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Capture the search query for analytics
        DB::table('search_words_data')->insert([
            'user_id' => $this->user->id,
            'search_word' => 'category_'.$this->search,
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        // SQL debugging code - dont remove yet
        //DB::enableQueryLog();
        
        // $p2 = Practice::join('favorites', 'practices.id', '=', 'favorites.practice_id')
        //         ->where('practices.title', 'like', '%'.$this->search.'%')
        //         ->where('user_id', '=' , $this->user->id)
        //         ->select('practices.id','title', 'description', 'video_id', 'practices.created_at', 'practices.updated_at')
        //         ->orderBy('title')
        //         ->paginate(10);

        // dd(DB::getQueryLog());


        // Admin practice list - list everything
        if ($this->user->is_admin) {
            return view('livewire.practice.practice-section', [
                'practices_list' => Practice::where('title', 'like', '%'.$this->search.'%')->paginate(10),
            ]);
        }


        // Return favorited practices only - for non admins
        return view('livewire.practice.practice-section', [
            'practices_list' => 
                Practice::join('favorites', 'practices.id', '=', 'favorites.practice_id')
                ->where('practices.title', 'like', '%'.$this->search.'%')
                ->where('user_id', '=' , $this->user->id)
                ->select('practices.id','title', 'description', 'video_id', 'practices.created_at', 'practices.updated_at')
                ->orderBy('title')
                ->paginate(10)
        ]);

        return view('livewire.practice.practice-section');
    }
}