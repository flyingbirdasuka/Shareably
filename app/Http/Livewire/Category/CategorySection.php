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

    // Descoped
    // public $categories;
    // End

    public $user;
    public $is_admin = false;
    public $search = '';

    protected $listeners = [
        'refreshParent' => '$refresh',
    ];

    public function mount()
    {
        $this->user = auth()->user();

        // Descoped
        // $this->categories = $this->user->is_admin ? Category::orderBy('title')->get() : Category::join('user_categories', 'categories.id', '=', 'user_categories.category_id')->where('user_id', '=' , $this->user->id)->orderBy('title');

        // End

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
        // Descoped
        // if($this->is_admin){
        //     $this->categories = Category::search('title', $this->search)->orderBy('title')->get();
        // } else {
        //     if(strlen($this->search) >= 2){
        //         foreach($this->categories as $key => $category){
        //             if(!str_contains(strtolower($category->title), strtolower($this->search))){
        //                 // If the search query is not found in the practices then remove the false results
        //                 $this->categories->forget($key);
        //             }
        //         }

        //         // Arrange the final results by alphabetical order
        //         $this->categories->sortBy('title');
        //         DB::table('search_words_data')->insert([
        //             'user_id' => $this->user->id,
        //             'search_word' => 'category_'.$this->search,
        //             "created_at" =>  Carbon::now(),
        //             "updated_at" => Carbon::now(),
        //         ]);

        //     } else {
        //         $this->categories = $this->user->categories()->orderBy('title')->get();
        //     }
        // }

        // End

    }

    // Reset the pagination after search is run
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {

        // Capture the search query for analytics
        if(!$this->is_admin && $this->search !=''){
            DB::table('search_words_data')->insert([
                'user_id' => $this->user->id,
                'search_word' => 'category_'.$this->search,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }

        // Admin category list - list everything
        if ($this->user->is_admin) {
            return view('livewire.category.category-section', [
                'categories_list' => Category::where('title', 'like', '%'.$this->search.'%')->orderBy('title')->paginate(10),
            ]);
        }


        // Normal user categories - only the ones they have been added to
        return view('livewire.category.category-section', [
            'categories_list' => 
                Category::join('user_categories', 'categories.id', '=', 'user_categories.category_id')
                ->where('categories.title', 'like', '%'.$this->search.'%')
                ->where('user_id', '=' , $this->user->id)
                ->select('categories.id','title', 'description', 'categories.created_at', 'categories.updated_at')
                ->distinct()
                ->orderBy('title')
                ->paginate(10),
        ]);
    }

}
