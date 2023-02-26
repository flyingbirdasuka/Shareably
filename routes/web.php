<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\PracticeController;
use App\Http\Controllers\User\LanguageController;
use App\Http\Controllers\User\TeamsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('categories',CategoryController::class);
    Route::resource('practices',PracticeController::class);
    Route::resource('languages',LanguageController::class);
    Route::resource('teams',TeamsController::class);
});



// Only Admins

// Route::group(['middleware'=>'admins'],function(){
//     Route::get('/', function () {
//         return view('welcome');  
//     });
// });