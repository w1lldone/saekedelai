<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldPlantingController;
use App\Http\Controllers\OnfarmMediaController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationUserController;
use App\Http\Controllers\PlantingHarvestController;
use App\Http\Controllers\PlantingOnfarmController;
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

    Route::get('/{field}/planting', [FieldPlantingController::class, 'index'])->name('planting.index');
    Route::get('/{field}/planting/create', [FieldPlantingController::class, 'create'])->name('planting.create');
    Route::get('/{field}/planting/{planting}', [FieldPlantingController::class, 'show'])->name('planting.show');
    Route::get('/{field}/planting/{planting}/postharvest', [FieldPlantingController::class, 'postharvest'])->name('planting.postharvest');
    Route::get('/{field}/planting/{planting}/edit', [FieldPlantingController::class, 'edit'])->name('planting.edit');
    Route::post('/{field}/planting', [FieldPlantingController::class, 'store'])->name('planting.store');
    Route::put('/{field}/planting/{planting}', [FieldPlantingController::class, 'update'])->name('planting.update');
    Route::delete('/{field}/planting/{planting}', [FieldPlantingController::class, 'destroy'])->name('planting.delete');
});

Route::prefix('planting/{planting}/onfarm')->name('planting.onfarm.')->middleware(['auth'])->group(function ()
{
    Route::get('/create', [PlantingOnfarmController::class, 'create'])->name('create');
    Route::get('/{onfarm}/edit', [PlantingOnfarmController::class, 'edit'])->name('edit');
    Route::put('/{onfarm}', [PlantingOnfarmController::class, 'update'])->name('update');
    Route::post('/', [PlantingOnfarmController::class, 'store'])->name('store');
    Route::delete('/{onfarm}', [PlantingOnfarmController::class, 'destroy'])->name('delete');
});

Route::prefix('planting/{planting}/harvest')->name('planting.harvest.')->middleware(['auth'])->group(function ()
{
    Route::get('/create', [PlantingHarvestController::class, 'create'])->name('create');
    Route::post('/', [PlantingHarvestController::class, 'store'])->name('store');
});

Route::prefix('onfarm/{onfarm}/media')->name('onfarm.media.')->middleware(['auth'])->group(function ()
{
    Route::get('/{media}', [OnfarmMediaController::class, 'show'])->name('show');
    Route::post('/', [OnfarmMediaController::class, 'store'])->name('store');
    Route::delete('/{media}', [OnfarmMediaController::class, 'destroy'])->name('delete');
});

require __DIR__ . '/auth.php';
