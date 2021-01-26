<?php

namespace Zahav\ZahavLaravel;

use Zahav\ZahavLaravel\Coinspot;

class Trader
{
    public function start()
    {
        $coinspot = new Coinspot(config('coinspot'));
        $latest = (float)$coinspot->latestPrices('BTC')->last;
        
        $buyAmount = $latest * ((100-1) / 100);
        $sellAmount = $latest * ((100+1) / 100);
    
        $coinspot->buyOrder('BTC', '0.0005', $buyAmount);
        sleep(10);
        $coinspot->sellOrder('BTC', '0.0005', $sellAmount);
    }
}