<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Category\CategorySection;
use App\Http\Livewire\Category\CategoryDetails;
use App\Http\Livewire\Practice\PracticeSection;
use App\Http\Livewire\Practice\PracticeDetails;
use App\Http\Livewire\Practice\PracticeUpload;
use App\Http\Livewire\Practice\PracticeEdit;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// language
// Route::get('/{language}', function($language){
//     App::setLocale($language);
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/categories',CategorySection::class);
    Route::get('/categories/{id}',CategoryDetails::class);
    Route::get('/practices',PracticeSection::class);
    Route::get('/practices/{id}',PracticeDetails::class);
    Route::get('/practice-upload',PracticeUpload::class);
    Route::get('/practices/{id}/edit',PracticeEdit::class);
});



// Only Admins

// Route::group(['middleware'=>'admins'],function(){
//     Route::get('/', function () {
//         return view('welcome');  
//     });
// });