<?php

use App\Http\Controllers\QuotesController;
use App\Http\Middleware\AuthApiToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(QuotesController::class)->middleware(AuthApiToken::class)->group(function () {
    Route::get('/kanye-west/quotes', 'list')->name('kanye-west-quotes');
    Route::get('/kanye-west/quotes/refresh', 'refreshList')->name('kanye-west-quotes-refresh');
});
