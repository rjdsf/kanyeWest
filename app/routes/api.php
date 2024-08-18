<?php

use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::controller(QuotesController::class)->group(function () {
    Route::get('/kanye-west/quotes', 'list')->name('kanye-west-quotes');
    Route::post('/kanye-west/quotes/refresh', 'refreshList')->name('kanye-west-quotes-refresh');
});
