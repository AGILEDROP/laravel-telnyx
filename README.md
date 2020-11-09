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

You should publish the config file with:
```bash
php artisan vendor:publish --provider="AGILEDROP\LaravelTelnyx\LaravelTelnyxServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [

    /*
     * The API KEY.
     *
     * You can generate API keys from the Telnyx web interface. 
     * See https://developers.telnyx.com/docs/v2/development/authentication for details
     */
    'api_key' => env('TELNYX_API_KEY'),

    /*
     * The phone number or a text that is shown as sender
     * 
     */
    'from' => env('TELNYX_FROM'), // Can be phone number or name


    /*
     * The messaging profile id.
     * Also generated from the Telnyx web interface. 
     */
	'messaging_profile_id' => env('TELNYX_MESSAGING_PROFILE_ID'),
];
```

You should then add you your .env file the following variables with your parameters:
```
TELNYX_API_KEY=
TELNYX_FROM=
TELNYX_MESSAGING_PROFILE_ID=
```

## Usage

In your Laravel Notification you just need to 
- Specify the notification channel
- import the class and implement the toTelnyx() method.

### For SMS
``` php

use AGILEDROP\LaravelTelnyx\Messages\TelnyxMessage;

/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['telnyx-sms'];
}

/**
 * Get the Telnyx / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return TelnyxMessage
 */
public function toTelnyx($notifiable)
{
    return (new TelnyxMessage)
        ->content("The text content of the message");
}
```

### For MMS
``` php

use AGILEDROP\LaravelTelnyx\Messages\TelnyxMessage;

/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['telnyx-mms'];
}

/**
 * Get the Telnyx / SMS representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return TelnyxMessage
 */
public function toTelnyx($notifiable)
{
    return (new TelnyxMessage)
        ->content(
            "The content of the message",
            $theArrayWithImagesUrls,
        );
}
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
