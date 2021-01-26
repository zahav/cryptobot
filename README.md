# Cryptocurrency trading bot for Laravel

This package provides an easily customisable trading bot to implement in your own projects.
It follows a conservative trading strategy and supports the [Coinspot](https://www.coinspot.com.au/api) API.


## Installation Via Composer

Add zahav/zahav-laravel to your composer.json

```php
composer require "zahav/zahav-laravel": "dev-main"
```

Register our service provider in `config/app.php`, within the `providers` array.

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

Optionally, you can register an alias in config/app.php:

```php
'aliases' => [
    // ...
    'Zahav' => Zahav\ZahavLaravel\Facades\Zahav::class,
],
```

## Configuration

Publish the default config file to your application so you can make modifications.

```console
$ php artisan vendor:publish
```