<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Practice;
use App\Models\User;
use DB;
use Carbon\Carbon;

class CategoryDetails extends Component
{
    use WithPagination;

    public $category;
    public $category_id;
    public $practices;
    public $users;
    public $user_id;
    public $is_admin;
    public $user_practices = [];
    public $search = '';

    public function mount($id)
    {
        $this->category_id = $id;
        $this->category = Category::find($id);
        $this->users = $this->category->users()->orderBy('name')->get();
        $this->is_admin = auth()->user()->is_admin;
        $this->user_id = auth()->user()->id;
        $this->user_practices = auth()->user()->practices()->pluck('practices.id')->all();
        if(!$this->is_admin){
            DB::table('page_view_data')->insert([
                'user_id' => $this->user_id,
                'page_name' => 'category_'.$id,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }

    public function updatedUserPractices(){
        // refresh the previous relationship (favorite practice)
        foreach(auth()->user()->practices()->get() as $practice){
            auth()->user()->practices()->detach($practice);
        }

        // add the new relationship (favorite practice)
        foreach ($this->user_practices as $practice_id){
            auth()->user()->practices()->attach($practice_id);
        }
    }

    // Reset the pagination after search is run
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit_practice($practice_id)
    {
        return redirect('practices/'.$practice_id.'/edit');
    }

    public function render()
    {
        // Capture the search query for analytics
        if(!$this->is_admin && $this->search !=''){
            DB::table('search_words_data')->insert([
                'user_id' => $this->user_id,
                'search_word' => 'practice_'.$this->search,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
        return view('livewire.category.category-details', [
            'practice_list' =>
                Practice::join('practice_categories', 'practices.id', '=', 'practice_categories.practice_id')
                ->where('practice_categories.category_id', $this->category_id)
                ->where('title', 'like', '%'.$this->search.'%')
                ->select('practices.id','practices.title', 'practices.description', 'practices.created_at', 'practices.updated_at')
                ->distinct()
                ->orderBy('title')->paginate(2)
        ]);
    }
}