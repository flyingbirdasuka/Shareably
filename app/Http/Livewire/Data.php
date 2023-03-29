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
    public $category_this_week;
    public $category_this_month;
    public $practice_count;
    public $practice_this_week;
    public $practice_this_month;
    public $practice_favorited;
    public $practice_most_favorited;
    public $pages;
    public $searches;
    public $locales;
    public $user_labels;
    public $user_data;
    public $email_labels;
    public $email_data;
    public $practice_labels;
    public $practice_data;
    public $user_range;

    public function mount()
    {
        /**
         * Making a graphics by using the data from database
         */

        // calculate the current month days dynamically
        $current_month = Carbon::today()->month;
        $this_month_days = $this->getCurrentMonthDays($current_month);

        // // user information
        $this->user_labels = [
            'all users',
            'added this week',
            'added this month',
        ];
        $this->user_count = User::count();
        $this->user_signup_this_week = User::where('created_at','>=',Carbon::today()->subDays(7))->count();
        $this->user_signup_this_month = User::where('created_at','>=',Carbon::today()->subDays($this_month_days))->count();
        $this->user_data = [
            $this->user_count,
            $this->user_signup_this_month,
            $this->user_signup_this_month,
        ];

        // email subscription rate
        $this->email_labels = [
            'all subscription',
            'this week',
            'this month'
        ];
        $this->email_subscription_rate = UserSettings::where('email_subscription', 1)->count() / $this->user_count * 100;

        $this->email_data = [$this->email_subscription_rate, $this->email_subscription_rate, $this->email_subscription_rate];


        // category
        $this->category_count = Category::count();
        $this->category_this_week = Category::where('created_at','>=',Carbon::today()->subDays(7))->count();
        $this->category_this_month = Category::where('created_at','>=',Carbon::today()->subDays($this_month_days))->count();


        $this->category_labels = [
            'all category',
            'this week',
            'this month',
        ];

        $this->category_data = [$this->category_count, $this->category_this_week, $this->category_this_month];


        // practice
        $this->practice_count = Practice::count();
        $this->practice_this_week = Practice::where('created_at','>=',Carbon::today()->subDays(7))->count();
        $this->practice_this_month = Practice::where('created_at','>=',Carbon::today()->subDays($this_month_days))->count();
        $this->practice_favorited = DB::table('favorites')->distinct()->get(['practice_id'])->count();

        $this->practice_labels = [
            'all practices',
            'this week',
            'this month',
            'favorited_practice'
        ];

        $this->practice_data = [$this->practice_count, $this->practice_this_week, $this->practice_this_month, $this->practice_favorited];

        // get the most favorited practice
        $most_favorited_id = DB::table('favorites')->groupBy('practice_id')->orderByRaw('count(*) DESC')->value('practice_id');
        $this->practice_most_favorited = Practice::find($most_favorited_id)->title;


        // data from session
        $this->pages = Session::get('data.page'); // count per page
        $this->searches = Session::get('data.search');
        $this->locales = Session::get('data.locale'); // grab it only unique value

    }
    public function render()
    {
        return view('livewire.data');
    }

    public function getCurrentMonthDays($current_month)
    {
        $long_month = [1,3,5,7,8,10,12]; // 31 days per month
        $short_month = [4,6,9,11]; // 30 days per month

        if(in_array($current_month, $long_month)){
            return 31;
        } else if (in_array($current_month, $short_month)){
            return 30;
        } else { // February
            return Carbond::today()->year % 4 == 0 ?  29 : 28;
        }
    }

    // get the desired date range from date range picker
    protected $listeners = [
        'getDateRange',
    ];

    public function getDateRange($value)
    {
        if(!is_null($value)){
            $date_range = $value;
            if($date_range){
                $user_range = User::whereBetween('created_at',[$date_range[0],$date_range[1]])->count();
                // $this->email_range = User::whereBetween('created_at',[$date_range[0],$date_range[1]])->count();
                $category_range = Category::whereBetween('created_at',[$date_range[0],$date_range[1]])->count();
                $practice_range = Practice::whereBetween('created_at',[$date_range[0],$date_range[1]])->count();
                $this->dispatchBrowserEvent('chart-update', ['selected date range',$user_range, $category_range, $practice_range ]);
            }
        }

    }
}
