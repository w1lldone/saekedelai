<?php

use App\Http\Controllers\Losant\LosantDeviceController;
use Illuminate\Support\Facades\Route;

Route::prefix('losant')->middleware(['auth', 'api'])->name('losant.')->group(function ()
{
    Route::prefix('device')->name('device.')->group(function ()
    {
        Route::get('/', [LosantDeviceController::class, 'index'])->name('index');
        Route::get('/{device}', [LosantDeviceController::class, 'show'])->name('show');
    });
});
