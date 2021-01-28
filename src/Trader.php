<?php

namespace Zahav\ZahavLaravel;

use Zahav\ZahavLaravel\Coinspot;

class Trader
{
    /**
     * The trading strategy.
     *
     * @var string
     */
    protected $strategy;

    /**
     * Create a new Trader instance.
     *
     */
    public function __construct()
    {
        $this->strategy = config('zahav.strategy');
    }

    public function start()
    {
        $strategy = $this->strategy;
        $coinspot = new Coinspot(config('coinspot'));

        switch($strategy)
        {
            case 'conservative':
                $this->conservative($coinspot);
                break;
            case 'moderate':
                $this->moderate($coinspot);
                break;
            case 'aggressive':
                $this->aggressive($coinspot);
                break;
        }
    }

    private function conservative($coinspot)
    {
        $latest = (float)$coinspot->latestPrices('BTC')->last;

        $buyAmount = $latest * ((1000-5) / 1000);
        $sellAmount = $latest * ((1000+5) / 1000);

        $coinspot->buyOrder('BTC', '0.0005', $buyAmount);
        sleep(10);
        $coinspot->sellOrder('BTC', '0.0005', $sellAmount);
    }

    private function moderate($coinspot)
    {
        $latest = (float)$coinspot->latestPrices('BTC')->last;

        $buyAmount = $latest * ((100-1) / 100);
        $sellAmount = $latest * ((100+1) / 100);

        $coinspot->buyOrder('BTC', '0.0005', $buyAmount);
        sleep(10);
        $coinspot->sellOrder('BTC', '0.0005', $sellAmount);
    }

    private function aggressive($coinspot)
    {
        $latest = (float)$coinspot->latestPrices('BTC')->last;

        $buyAmount = $latest * ((100-2) / 100);
        $sellAmount = $latest * ((100+2) / 100);

        $coinspot->buyOrder('BTC', '0.0005', $buyAmount);
        sleep(10);
        $coinspot->sellOrder('BTC', '0.0005', $sellAmount);
    }
}