<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Category\CategorySection;
use App\Http\Livewire\Category\CategoryDetails;
use App\Http\Livewire\Practice\PracticeSection;
use App\Http\Livewire\Practice\PracticeDetails;
use App\Http\Livewire\Practice\PracticeUpload;
use App\Http\Livewire\Practice\PracticeEdit;
use App\Http\Livewire\Users\UserDetail;
use App\Http\Livewire\Teams\TeamsAll;
use App\Http\Livewire\Users\UsersAll;
use App\Http\Livewire\Users\UserLogin;
use App\Http\Livewire\Users\UserLogout;
use App\Http\Livewire\UserSettings\UserSettingsSection;
use App\Http\Livewire\Data;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    if(!Auth::user()->is_admin){
        DB::table('locale_data')->insert([
            'user_id' => auth()->user()->id,
            'locale' => $locale,
            'browser' => 0,
            "created_at" =>  Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
    return redirect()->back();
});

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {

    $limiter = config('fortify.limiters.login');

    Route::post('/login', [UserLogin::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]));
    Route::post('/logout', [UserLogout::class, 'destroy'])->name('logout');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/categories',CategorySection::class)->name('categories');
    Route::get('/categories/{id}',CategoryDetails::class);
    Route::get('/practices',PracticeSection::class)->name('practices');
    Route::get('/practices/{id}',PracticeDetails::class);
    Route::get('/email-setting/{id}', [UserSettingsSection::class, 'email_unsubscribe']);
})->group(function(){ // Only Admins
        Route::middleware('admins')->group(function () {
            Route::get('/teams-all', TeamsAll::class)->name('teams-all');
            Route::get('/users-all', UsersAll::class)->name('users-all');
            Route::get('/practice-upload',PracticeUpload::class)->name('upload');
            Route::get('/practices/{id}/edit',PracticeEdit::class);
            Route::get('/users/{id}',UserDetail::class);
            Route::get('/analytics-dashboard',Data::class)->name('analytics-dashboard');
        });
});
