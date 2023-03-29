<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\UserSettings;
use App\Models\Category;
use App\Models\Practice;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;

class Data extends Component
{
    public $user_count;
    public $user_signup_this_week;
    public $user_signup_this_month;
    public $email_subscription_rate;
    public $category_count;
    public $practice_count;
    public $practice_this_week;
    public $practice_this_month;
    public $practice_favorited;
    public $practice_most_favorited;
    public $pages;
    public $searches;
    public $locales;
    public $labels;
    public $data;


    public function mount()
    {
        // data from database 
        // make 30 dynamic per month
        // $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        //             ->whereYear('created_at', date('Y'))
        //             ->groupBy(DB::raw("Month(created_at)"))
        //             ->pluck('count', 'month_name');
 
        // $labels = $users->keys();
        // $data = $users->values();
        // $this->user_count = User::count();
        // $this->user_signup_this_week = User::where('created_at','>=',Carbon::today()->subDays(7))->count();
        // $this->user_signup_this_month = User::where('created_at','>=',Carbon::today()->subDays(30))->count();
        // $this->email_subscription_rate = UserSettings::where('email_subscription', 1)->count() / $this->user_count * 100;
        // $this->category_count = Category::count();
        // $this->practice_count = Practice::count();
        // $this->practice_this_week = Practice::where('created_at','>=',Carbon::today()->subDays(7))->count();
        // $this->practice_this_month = Practice::where('created_at','>=',Carbon::today()->subDays(30))->count();
        // $this->practice_favorited = DB::table('favorites')->distinct()->get(['practice_id'])->count();
        // $most_favorited_id = DB::table('favorites')->groupBy('practice_id')->orderByRaw('count(*) DESC')->value('practice_id');
        // $this->practice_most_favorited = Practice::find($most_favorited_id);


        // data from session
        // $this->pages = Session::get('data.page'); // count per page
        // $this->searches = Session::get('data.search'); 
        // $this->locales = Session::get('data.locale'); // grab it only unique value
       
    }    
    public function render()
    {
        return view('livewire.data');
    }
}
