<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAddressController;
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
Route::prefix('address')->name('address.')->group(function ()
{
    Route::get('/provinces', [AddressController::class, 'provinces'])->name('provinces');
    Route::get('/cities', [AddressController::class, 'cities'])->name('cities');
    Route::get('/districts', [AddressController::class, 'districts'])->name('districts');
    Route::get('/subdistricts', [AddressController::class, 'subdistricts'])->name('subdistricts');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('profile')->name('profile.')->middleware(['auth'])->group(function ()
{
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/address', [ProfileController::class, 'editAddress'])->name('address.edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->resource('user', UserController::class);

Route::put('/user/{user}/address', [UserAddressController::class, 'update'])
    ->middleware(['auth'])
    ->name('user.address.update');


require __DIR__.'/auth.php';
