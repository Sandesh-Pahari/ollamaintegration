<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EsewaController;

Route::get('/', function () {
    return view('template');
});


Route::get('/pay/{amount}', [EsewaController::class, 'initiate'])->name('esewa.pay');
Route::post('/esewa/success', [EsewaController::class, 'success'])->name('esewa.success');
Route::post('/esewa/failure', [EsewaController::class, 'failure'])->name('esewa.failure');
