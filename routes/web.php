<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('profile')->name('profile.')->middleware(['auth'])->group(function ()
{
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->resource('user', UserController::class);


require __DIR__.'/auth.php';
