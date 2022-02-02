# Cryptocurrency trading bot for Laravel

This package provides an easily customisable trading bot to implement in your own projects.
It follows a conservative trading strategy and supports the [Coinspot](https://www.coinspot.com.au/api) API.


## Installation via Composer

Add zahav/zahav-laravel to your composer.json:

```php
composer require "zahav/cryptobot"
```

Register our service provider in `config/app.php`, within the `providers` array:

```php
'providers' => [
    // ...
    Zahav\ZahavLaravel\ZahavServiceProvider::class,
    // ...
],
```

To use the configured Zahav client, import the facade each time:

```php
use Zahav\ZahavLaravel\Facades\Zahav;
```

Optionally, you can register an alias in `config/app.php`:

```php
'aliases' => [
    // ...
    'Zahav' => Zahav\ZahavLaravel\Facades\Zahav::class,
],
```

## Configuration

Publish the default config file to your application so you can make modifications:

```console
foo@bar:~$ php artisan vendor:publish
```

Next, you should configure your CoinspotAPI keys in your application's `.env` file. You can retrieve your Coinspot API keys from the Coinspot settings page:

```console
COINSPOT_KEY=
COINSPOT_SECRET=
```

```console
ZAHAV_STRATEGY=conservative
ZAHAV_BUY_AMOUNT=0.0025
ZAHAV_SELL_AMOUNT=0.025
```

## Usage

Zahav includes an Artisan command that will complete a buy/sell trade pair. You may run the worker using the `zahav:work` Artisan command.

```console
foo@bar:~$ php artisan zahav:work
```

For regular trading, you can add a cron entry to keep your `zahav:work` process running.

```console
0 * * * * php /home/forge/app.com/artisan zahav:work >> /dev/null 2>&1
```