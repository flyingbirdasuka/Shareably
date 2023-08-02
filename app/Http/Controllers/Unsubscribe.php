<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Category;
use App\Traits\GoogleSetup;

class Unsubscribe
{
    use GoogleSetup;
    public function unsubscribe(){
        // go through the database and find the expired subscription
        $today = Carbon::now();

        $expired_subscriptions = DB::table('user_categories')->get()->where('expiration_date', '<=',$today);
        foreach($expired_subscriptions as $subscription){
            $category = Category::find($subscription->category_id);
            $practices = $category->practices()->get();
            foreach($practices as $practice){
                $this->removeFromGoogleDrive($subscription->user_id, $practice->video_id, $subscription->category_id);
            }
            $category->users()->detach($subscription->user_id);
        }
    }
}