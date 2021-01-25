<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Coinspot API URL
    |--------------------------------------------------------------------------
    |
    | Here you may specify the url for our API requests to Coinspot.
    | Easily configurable if we need to update to the latest API version in the Coinspot Service Provider.
    | Public: https://www.coinspot.com.au/pubapi
	| Authenticated: https://www.coinspot.com.au/pubapi
    */

    'url' => env('COINSPOT_HOST', 'https://www.coinspot.com.au/api'),

    /*
    |--------------------------------------------------------------------------
    | Access seeker API key
    |--------------------------------------------------------------------------
    |
    | Specify the api key for your Coinspot account.
    |
    */

    'key' => env('COINSPOT_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Access seeker API secret
    |--------------------------------------------------------------------------
    |
    | Specify the secret key for your Coinspot account.
    |
    */

    'secret' => env('COINSPOT_SECRET', ''),

];