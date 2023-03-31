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
    public $pages;
    public $searches;
    public $locales;
    public $user_data;
    public $email_data;
    public $practice_data;
    public $practice_favorited;
    public $practice_most_favorited;
    public $most_viewed_page;
    public $most_viewd_page_count;
    public $most_used_language;
    public $most_used_language_count;
    public $most_used_session_time;
    public $most_used_session_user;
    public $average_settion_time;

    public function mount()
    {
        /**
         * Making a graphics by using the data from database
         */

        // calculate the current month days dynamically
        $current_month = Carbon::today()->month;
        $this_month_days = $this->getCurrentMonthDays($current_month);

        $user_count = User::where('is_admin','!=' ,1)->count();

        $user_signup_this_week = User::where('is_admin','!=',1)->where('created_at','>=',Carbon::today()->subDays(7))->count();

        $user_signup_this_month = User::where('is_admin','!=',1)->where('created_at','>=',Carbon::today()->subDays($this_month_days))->count();

        $this->user_data = [$user_count, $user_signup_this_month,$user_signup_this_month];

        // email subscription rate
        $email_subscription_rate = UserSettings::where('email_subscription', 1)->get()->where('user.is_admin','!=', 1)->count()/$user_count * 100;

        $email_this_week = UserSettings::where('email_subscription', 1)->where('updated_at','>=',Carbon::today()->subDays(7))->get()->where('user.is_admin','!=', 1)->count() / $user_count * 100;

        $email_this_month = UserSettings::where('email_subscription', 1)->where('updated_at','>=',Carbon::today()->subDays($this_month_days))->get()->where('user.is_admin','!=', 1)->count() / $user_count * 100;

        $this->email_data = [$email_subscription_rate, $email_this_week, $email_this_month];


        // category
        $category_count = Category::count();

        $category_this_week = Category::where('created_at','>=',Carbon::today()->subDays(7))->count();

        $category_this_month = Category::where('created_at','>=',Carbon::today()->subDays($this_month_days))->count();

        $this->category_data = [$category_count, $category_this_week, $category_this_month];


        // practice
        $practice_count = Practice::count();

        $practice_this_week = Practice::where('created_at','>=',Carbon::today()->subDays(7))->count();

        $practice_this_month = Practice::where('created_at','>=',Carbon::today()->subDays($this_month_days))->count();

        $this->practice_data = [$practice_count, $practice_this_week, $practice_this_month];

        // practice favroited
        $this->practice_favorited = DB::table('favorites')->distinct()->get(['practice_id'])->count();

        // get the most favorited practice
        $most_favorited_id = DB::table('favorites')->count() > 0 && DB::table('favorites')->groupBy('practice_id')->orderByRaw('count(*) DESC')->value('practice_id');

        $this->practice_most_favorited = $most_favorited_id && Practice::find($most_favorited_id)->title;


        // visited page
        $this->most_viewed_page = DB::table('page_view_data')->groupBy('page_name')->orderByRaw('count(*) DESC')->value('page_name');

        $this->most_viewd_page_count = DB::table('page_view_data')->where('page_name',$this->most_viewed_page)->count();

        // locale data
        $this->most_used_language = DB::table('locale_data')->groupBy('locale')->orderByRaw('count(*) DESC')->value('locale');

        $this->most_used_language_count = DB::table('locale_data')->where('locale',$this->most_used_language)->count();

        // session data
        $this->most_used_session_time = round((DB::table('session_data')->select(DB::raw('SUM(session_time) AS session'))->groupBy('user_id')->orderByRaw('sum(session_time) DESC')->value('session'))/60,2);

        $this->most_used_session_user = User::where('id', DB::table('session_data')->select('user_id')->groupBy('user_id')->orderByRaw('sum(session_time) DESC')->value('user_id'))->first()->name;

        $this->average_settion_time = round((DB::table('session_data')->select(DB::raw( 'AVG(session_time) AS session'))->first()->session) /60,2);

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
        'getDateRange'
    ];

    /**
     * when the date range picker is used this function is called
     * then get the value between the selected date range and pass to the chart-update function of the javascript front end
     */
    public function getDateRange($value)
    {
        if(!is_null($value)){
            $date_range = $value;
            if($date_range){
                $user_range = User::where('is_admin','!=',1)->whereBetween('created_at',[$date_range[0],$date_range[1]])->count();

                $email_count = UserSettings::where('email_subscription', 1)->whereBetween('updated_at',[$date_range[0],$date_range[1]])->get()->where('user.is_admin','!=', 1)->count();
                $email_range = $email_count != 0 ?  $email_count / $user_range * 100 : 0 ;

                $category_range = Category::whereBetween('created_at',[$date_range[0],$date_range[1]])->count();

                $practice_range = Practice::whereBetween('created_at',[$date_range[0],$date_range[1]])->count();

                $this->dispatchBrowserEvent('chart-update', [$date_range[0] .' to ' .$date_range[1], $user_range, $email_range, $category_range, $practice_range ]);
            }
        }
    }
}