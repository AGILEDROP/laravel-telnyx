# Laravel Telnyx Driver

[![Latest Version on Packagist](https://img.shields.io/packagist/v/agiledrop/laravel-telnyx.svg?style=flat-square)](https://packagist.org/packages/agiledrop/laravel-telnyx)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/agiledrop/laravel-telnyx/run-tests?label=tests)](https://github.com/agiledrop/laravel-telnyx/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/agiledrop/laravel-telnyx.svg?style=flat-square)](https://packagist.org/packages/agiledrop/laravel-telnyx)

This package enables Telnyx driver functionality using the Sms facade in Laravel 7+.   


## Installation

You can install the package via composer:

```bash
composer require agiledrop/laravel-telnyx
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="AGILEDROP\LaravelTelnyx\LaravelTelnyxServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="AGILEDROP\LaravelTelnyx\LaravelTelnyxServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'api_key' => '',
    'messaging_profile_id' => '',
    'from' => '',
];
```

## Usage

``` php
$laravel-telnyx = new AGILEDROP\LaravelTelnyx();
echo $laravel-telnyx->echoPhrase('Hello, AGILEDROP!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Davide Casiraghi](https://github.com/DavideCasiraghi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
