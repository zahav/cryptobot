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

    /*
    |--------------------------------------------------------------------------
    | Purchase Amount
    |--------------------------------------------------------------------------
    |
    | This option sets the amount of coins you want to buy for each trade.
    | The max precision is 8 decimal places
    |
    */

    'buyAmount' => env('ZAHAV_BUY_AMOUNT', 0),

    /*
    |--------------------------------------------------------------------------
    | Sale Amount
    |--------------------------------------------------------------------------
    |
    | This option sets the amount of coins you want to sell for each trade.
    | The max precision is 8 decimal places
    |
    */

    'sellAmount' => env('ZAHAV_SELL_AMOUNT', 0),

];