<?php

namespace App\Http\Livewire\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\LogoutResponse;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class UserLogout extends Auth
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

     /**
     * Destroy an authenticated session. Triggered on logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\LogoutResponse
     */
    public function destroy(Request $request)
    {
        // Store the logout data here only for non admin users
        if(!auth()->user()->is_admin){
            session()->push('data.end', Carbon::now());

            $data = Session::get('data');
            // Session time in seconds
            $sessionTime = $data['end'][0]->timestamp - $data['start'][0]->timestamp;

            DB::table('session_data')->insert([
                'user_id' => auth()->user()->id,
                'start' => $data['start'][0]->format('Y-m-d H:i:s'),
                'end' => $data['end'][0]->format('Y-m-d H:i:s'),
                'session_time' => $sessionTime,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
            DB::table('locale_data')->insert([
                'user_id' => auth()->user()->id,
                'locale' => $data['locale'][0],
                'browser' => 1,
                "created_at" =>  Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
