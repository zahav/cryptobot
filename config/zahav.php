<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Trading Strategy
    |--------------------------------------------------------------------------
    |
    | This option is the trading strategy this will be used when placing orders.
    | It's recommended to start with a conservative approach and tweak the trade
    | size and frequency to test for different outcomes.
    |
    | Available strategies: 'conservative', 'moderate', 'aggressive'
    |
    */

    'strategy' => env('ZAHAV_STRATEGY', 'conservative'),

];