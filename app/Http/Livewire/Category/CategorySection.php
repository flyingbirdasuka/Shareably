<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\User;
use DB;
use Carbon\Carbon;

class CategorySection extends Component
{
    use WithPagination;

    public $categories;
    public $user;
    public $is_admin = false;
    public $search = '';

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->categories = $this->user->is_admin ? Category::orderBy('title')->get() : $this->user->categories()->orderBy('title')->get();
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
        if($this->is_admin){
            $this->categories = Category::search('title', $this->search)->orderBy('title')->get();
        } else {
            if(strlen($this->search) >= 2){
                foreach($this->categories as $key => $category){
                    if(!str_contains(strtolower($category->title), strtolower($this->search))){
                        // If the search query is not found in the practices then remove the false results
                        $this->categories->forget($key);
                    }
                }

                // Arrange the final results by alphabetical order
                $this->categories->sortBy('title');
                DB::table('search_words_data')->insert([
                    'user_id' => $this->user->id,
                    'search_word' => 'category_'.$this->search,
                    "created_at" =>  Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);

            } else {
                $this->categories = $this->user->categories()->orderBy('title')->get();
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
        return view('livewire.category.category-section', [
            'categories_list' => Category::where('title', 'like', '%'.$this->search.'%')->paginate(10),
        ]);
    }


}
