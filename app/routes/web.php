<?php


use App\Http\Controllers\QuotesWebController;
use Illuminate\Support\Facades\Route;

Route::controller(QuotesWebController::class)->group(function () {
    Route::get('/', 'show')->name('home');
});

