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
     * The amount of coins to buy.
     *
     * @var string
     */
    protected $buyAmount;

    /**
     * The amount of coins to sell.
     *
     * @var string
     */
    protected $sellAmount;

    /**
     * Create a new Trader instance.
     *
     */
    public function __construct()
    {
        $this->strategy = config('zahav.strategy');
        $this->buyAmount = (float)config('zahav.buyAmount');
        $this->sellAmount = (float)config('zahav.sellAmount');
    }

    public function start()
    {
        $strategy = $this->strategy;

        switch($strategy)
        {
            case 'conservative':
                $this->conservative();
                break;
            case 'moderate':
                $this->moderate();
                break;
            case 'aggressive':
                $this->aggressive();
                break;
        }
    }

    private function conservative()
    {
        $coinspot = new Coinspot(config('coinspot'));
        $latest = (float)$coinspot->latestPrices('BTC')->last;

        $buyPrice = $latest * ((1000-5) / 1000);
        $sellPrice = $latest * ((1000+5) / 1000);

        if ($this->canTrade()) {
            $coinspot->buyOrder('BTC', $this->buyAmount, $buyPrice);
            sleep(10);
            $coinspot->sellOrder('BTC', $this->sellAmount, $sellPrice);
        }
    }

    private function moderate()
    {
        $coinspot = new Coinspot(config('coinspot'));
        $latest = (float)$coinspot->latestPrices('BTC')->last;

        $buyPrice = $latest * ((100-1) / 100);
        $sellPrice = $latest * ((100+1) / 100);

        if ($this->canTrade()) {
            $coinspot->buyOrder('BTC', $this->buyAmount, $buyPrice);
            sleep(10);
            $coinspot->sellOrder('BTC', $this->sellAmount, $sellPrice);
        }
    }

    private function aggressive()
    {
        $coinspot = new Coinspot(config('coinspot'));
        $latest = (float)$coinspot->latestPrices('BTC')->last;

        $buyPrice = $latest * ((100-2) / 100);
        $sellPrice = $latest * ((100+2) / 100);

        if ($this->canTrade()) {
            $coinspot->buyOrder('BTC', $this->buyAmount, $buyPrice);
            sleep(10);
            $coinspot->sellOrder('BTC', $this->sellAmount, $sellPrice);
        }
    }

    private function canTrade()
    {
        $coinspot = new Coinspot(config('coinspot'));
        $balance = $coinspot->myBalances()['balance'];

        $availableFunds = $balance['aud'] >= $this->buyAmount ?: false;
        $availableCoins = $balance['btc'] >= $this->sellAmount ?: false;

        return $availableFunds && $availableCoins;
    }
}