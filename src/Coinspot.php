<?php

namespace Zahav\ZahavLaravel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Coinspot
{
    /**
     * The Coinspot API URL.
     *
     * @var string
     */
    protected $api_url;

    /**
     * The API key generated from the settings page.
     *
     * @var String
     */
    protected $api_key;

    /**
     * The API secret generated from the settings page.
     *
     * @var String
     */
    protected $api_secret;

    /**
     * The Guzzle client object.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Create a new Coinspot instance.
     *
     * @param  Array  $config
     */
    public function __construct($config)
    {
        $this->api_url = $config['url'];
        $this->api_key = $config['key'];
        $this->api_secret = $config['secret'];
        $this->client = new Client(['base_uri' => $this->api_url]);
    }

    /**
     * List the latest prices for a coin.
     * Example value 'BTC', 'LTC', 'DOGE'
     */
    public function latestPrices($coinType)
    {
        $coinType = strtolower($coinType);
        $client = new Client(['base_uri' => 'https://www.coinspot.com.au/pubapi/']);
        $response = $client->request('GET', 'latest');
        $response = json_decode($response->getBody());
        return $response->prices->$coinType;
    }

    /**
     * List the open orders on the exchange.
     * Example value 'BTC', 'LTC', 'DOGE'
     * 
     * @param  String  $coinType
     */
    public function orders($coinType)
    {
        return $this->request('orders', [
            'cointype' => $coinType
        ]);
    }

    /**
     * List of the last 1000 completed orders on the exchange.
     * Example value 'BTC', 'LTC', 'DOGE'
     * 
     * @param  String  $coinType
     */
    public function orderHistory($coinType)
    {
        return $this->request('orders/history', [
            'cointype' => $coinType
        ]);
    }

    /**
     * Generate a receive address for your wallet.
     * Example value 'BTC', 'LTC', 'DOGE'
     * 
     * @param  String  $coinType
     */
    public function depositCoins($coinType)
    {
        return $this->request('my/coin/deposit', [
            'cointype' => $coinType
        ]);
    }

    /**
     * Place an instant buy order.
     * Example value 'BTC', 'LTC', 'DOGE'
     * 
     * @param  String  $coinType
     * @param  Int  $amoount
     */
    public function quickBuy($coinType, $amount)
    {
        return $this->request('quote/buy', [
            'cointype' => $coinType,
            'amount' => $amount
        ]);
    }

    /**
     * Place an instant sell order.
     * Example value 'BTC', 'LTC', 'DOGE'
     * 
     * @param  String  $coinType
     * @param  Int  $amount
     */
    public function quickSell($coinType, $amount)
    {
        return $this->request('quote/sell', [
            'cointype' => $coinType,
            'amoount' => $amount
        ]);
    }

    /**
     * Show a list of total wallet balances for each coin.
     * 
     */
    public function myBalances()
    {
        return $this->request('my/balances');
    }

    /**
     * Show a list of available wallet balances for each coin.
     * These values are reduced when there are open orders on the exchange.
     *
     */
    public function availableBalances()
    {
        $totalBalance = $this->myBalances();
        $openOrders = $this->myOrders();

        $buyOrders = collect($openOrders['buyorders'])->sum('total');
        $sellOrders = collect($openOrders['sellorders'])->sum('amount');

        $availableBalance['aud'] = $totalBalance['balance']['aud'] - $buyOrders;
        $availableBalance['btc'] = $totalBalance['balance']['btc'] - $sellOrders;

        return $availableBalance;
    }

    /**
     * A list of your open orders by coin type, it will return a maximum of 100 results.
     * 
     */
    public function myOrders()
    {
        return $this->request('my/orders');
    }

    /**
     * Place an on-market buy order.
     * cointype - the coin shortname, example value 'BTC', 'LTC', 'DOGE'
     * amount - the amount of coins you want to buy, max precision 8 decimal places
     * rate - the rate in AUD you are willing to pay, max precision 6 decimal places
     * 
     * @param  String  $coinType
     * @param  String  $amoount
     * @param  String  $rate
     */
    public function buyOrder($coinType, $amount, $rate)
    {
        return $this->request('my/buy', [
            'cointype' => $coinType,
            'amount' => $amount,
            'rate' => $rate
        ]);
    }

    /**
     * Place an on-market sell order.
     * cointype - the coin shortname, example value 'BTC', 'LTC', 'DOGE'
     * amount - the amount of coins you want to sell, max precision 8 decimal places
     * rate - the rate in AUD you are willing to sell for, max precision 6 decimal places
     * 
     * @param  String  $coinType
     * @param  String  $amoount
     * @param  String  $rate
     */
    public function sellOrder($coinType, $amount, $rate)
    {
        return $this->request('my/sell', [
            'cointype' => $coinType,
            'amount' => $amount,
            'rate' => $rate
        ]);
    }

    /**
     * Cancel an on-market buy order
     * 
     * @param  Int  $id
     */
    public function cancelBuyOrder($id)
    {
        return $this->request('my/buy/cancel', [
            'id' => $id
        ]);
    }

    /**
     * Cancel an on-market sell order
     * 
     * @param  Int  $id
     */
    public function cancelSellOrder($id)
    {
        return $this->request('my/sell/cancel', [
            'id' => $id
        ]);
    }

    /**
     * Make a call to the Coinspot API.
     * Note: All requests and responses will be JSON.
     * Note: All requests should be made with the POST method.
     */
    private function request($method, $data = [])
    {
        $data['nonce'] = time();
        
        try {
            $response = $this->client->request('POST', $method, [
                'headers' => [
                    'key' => $this->api_key,
                    'sign' => $this->signature($data)
                ],
                'json' => $data
            ]);

            if ($response->getReasonPhrase() == 'OK') {
                sleep(3); // Avoid rate limiting
                return json_decode($response->getBody(), true);
            }
            else {
                return "No results";
            }
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
        }
    }

    /**
     * Sign the request data using the secret key according to HMAC-SHA512 method. 
     * 
     * @param  Array  $data
     */
    private function signature($data) 
    {
        return hash_hmac('sha512', json_encode($data), $this->api_secret);
    }
}