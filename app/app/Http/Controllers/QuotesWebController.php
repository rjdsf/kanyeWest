<?php

namespace App\Http\Controllers;

use App\Http\Resources\Quotes;
use App\Managers\QuoteManager;
use Inertia\Inertia;
use Inertia\Response;


class QuotesWebController extends Controller
{
    public function show(QuoteManager $quoteManager):Response
    {
       $refreshCache =  request()->headers->get('cache-control') == 'no-cache';

        $quotes = $quoteManager->driver('kanyeWest')->getQuotes(5, $refreshCache);
        return Inertia::render('Home',
            (new Quotes($quotes))->resolve()
        );
    }
}
