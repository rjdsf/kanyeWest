<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteCollection;
use App\Managers\QuoteManager;

class QuotesController extends Controller
{
    public function list(QuoteManager $quoteManager): QuoteCollection
    {
        $quotes = $quoteManager->driver('kanyeWest')->getQuotes();
        return new QuoteCollection($quotes);
    }

    public function refreshList(QuoteManager $quoteManager): QuoteCollection
    {
        $quotes = $quoteManager->driver('kanyeWest')->refreshQuotes();
        return new QuoteCollection($quotes);
    }
}
