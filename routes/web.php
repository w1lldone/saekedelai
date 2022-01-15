<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMediaController;
use App\Http\Controllers\UserOrganizationController;
use App\Http\Controllers\UserRoleController;
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

Route::prefix('address')->name('address.')->group(function () {
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

Route::prefix('profile')->name('profile.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/address', [ProfileController::class, 'editAddress'])->name('address.edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->resource('user', UserController::class);

Route::prefix('/user/{user}')->middleware(['auth'])->name('user.')->group(function () {
    Route::get('/address/edit', [UserAddressController::class, 'edit'])->name('address.edit');
    Route::put('/address', [UserAddressController::class, 'update'])->name('address.update');
    Route::get('/role/edit', [UserRoleController::class, 'edit'])->name('role.edit');
    Route::put('/role', [UserRoleController::class, 'update'])->name('role.update');
    Route::get('/organization/edit', [UserOrganizationController::class, 'edit'])->name('organization.edit');
    Route::post('/organization', [UserOrganizationController::class, 'store'])->name('organization.store');
    Route::delete('/organization/{organization}', [UserOrganizationController::class, 'destroy'])->name('organization.delete');

    Route::post('/media', [UserMediaController::class, 'store'])->name('media.store');
    Route::get('/media/{media}', [UserMediaController::class, 'show'])->name('media.show');
    Route::delete('/media/{media}', [UserMediaController::class, 'destroy'])->name('media.delete');
});

Route::middleware(['auth'])->resource('organization', OrganizationController::class);

Route::prefix('/organization/{organization}')->name('organization.')->middleware(['auth'])->group(function () {
    Route::get('/user', [OrganizationUserController::class, 'index'])->name('user.index');
    Route::post('/user', [OrganizationUserController::class, 'store'])->name('user.store');
});

Route::prefix('field')->middleware(['auth'])->name('field.')->group(function ()
{
    Route::get('/', [FieldController::class, 'index'])->name('index');
    Route::post('/', [FieldController::class, 'store'])->name('store');
    Route::get('/create', [FieldController::class, 'create'])->name('create');
    Route::get('/{field}', [FieldController::class, 'show'])->name('show');
    Route::get('/{field}/edit', [FieldController::class, 'edit'])->name('edit');
    Route::delete('/{field}', [FieldController::class, 'destroy'])->name('delete');
    Route::put('/{field}', [FieldController::class, 'update'])->name('update');
});

require __DIR__ . '/auth.php';
