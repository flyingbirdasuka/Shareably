<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use App\Models\Practice;
use App\Models\User;
use DB;
use Carbon\Carbon;

class CategoryDetails extends Component
{
    public $category;
    public $practices;
    public $users;
    public $user_id;
    public $is_admin;
    public $user_practices = [];

    public function mount($id)
    {
        $this->category = Category::find($id);
        $this->practices = $this->category->practices()->orderBy('title')->get();
        $this->users = $this->category->users()->orderBy('name')->get();
        $this->is_admin = auth()->user()->is_admin;
        $this->user_practices = auth()->user()->practices()->pluck('practices.id')->all();
        if(!$this->is_admin){
            DB::table('page_view_data')->insert([
                'user_id' => auth()->user()->id,
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

    public function edit_practice($practice_id)
    {
        return redirect('practices/'.$practice_id.'/edit');
    }

    public function render()
    {
        return view('livewire.category.category-details');
    }
}