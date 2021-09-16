# Laravel Telnyx Driver

[![Latest Version on Packagist](https://img.shields.io/packagist/v/agiledrop/laravel-telnyx.svg?style=flat-square)](https://packagist.org/packages/agiledrop/laravel-telnyx)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/agiledrop/laravel-telnyx/Tests?label=tests)](https://github.com/agiledrop/laravel-telnyx/actions?query=workflow%Tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/agiledrop/laravel-telnyx.svg?style=flat-square)](https://packagist.org/packages/agiledrop/laravel-telnyx)

This package enables to send SMS and MMS notifications from your Laravel application.

Requires Laravel 7+

## Prerequisites


You first need to register a [Telnyx](https://telnyx.com/) account, generate a **phone number** a **messaging profile**, 
and an **API key**.  

Notice that at the moment just American phone numbers are allowed to send SMS, so you will need to generate an American number.

## Installation

You can install the package via composer:

```bash
composer require agiledrop/laravel-telnyx
```

You should publish and run the migrations with:

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



## Sending an SMS notification
This is an example of SMS notification.

### Create a notification

Generate a notification with an artisan command:
```
php artisan make:notification SmsNotification
```

This will create for you the file at ```app/Notifications/SmsNotification.php```

Then paste in that the following code:


``` php

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use AGILEDROP\LaravelTelnyx\Messages\TelnyxSmsMessage;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification
{
    use Queueable;

    private string $from;
    private string $content;

    /**
     * Create a new notification instance.
     *
     * @param string $from
     * @param string $content
     */
    public function __construct(string $from, string $content)
    {
        $this->from = $from;
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['telnyx-sms'];
    }


    /**
     * Get the Telnyx / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return TelnyxSmsMessage
     */
    public function toTelnyx($notifiable): TelnyxSmsMessage
    {
        return (new TelnyxSmsMessage())
           ->from($this->from)
           ->content($this->content);
    }
}
```

Then to use this notification, just import it in where you need it and run it like below:
```php
use App\Notifications\Alerts\SmsNotification;
// ...
$from = env('TELNYX_FROM');
$content = 'The text of your sms…';
$admin->notify(new SmsNotification($from, $content));
```

### Override the RouteNotificationFor in your user model
This metod is used to determine where to route the notification to.

```php
    /**
     * Override the RouteNotificationFor
     *
     * The routeNotificationFor() method exists in the Notifications\RoutesNotifications trait,
     * this trait is used inside the Notifications\Notifiable trait that a User model uses
     * by default in a fresh laravel installation,
     * this method is used to determine where to route the notification to.
     *
     * @param string $driver
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|string
     */
    public function routeNotificationFor(string $driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor' . Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->email; // set here the name of your user mail field
            case 'telnyx':
                return $this->phone; // set here the name of your user phone field
        }
    }
```

## Sending an MMS notification (available just for US)

This is an example of MMS notification.

### Create a notification with an artisan command:
```
php artisan make:notification MmsNotification
```
This will create: ```/App/Notification/MmsNotification.php.```

Then paste in that the following code:

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use AGILEDROP\LaravelTelnyx\Messages\TelnyxMmsMessage;
use Illuminate\Notifications\Notification;

class MmsNotification extends Notification
{
    use Queueable;

    private string $content;
    private string $subject;
    private array $images;
    private string $from;

    /**
     * Create a new notification instance.
     *
     * @param string $content
     * @param string $subject
     * @param array $images
     * @param string $from
     */
    public function __construct(string $from, string $content, string $subject, array $images)
    {
        $this->from = $from;
        $this->content = $content;
        $this->subject = $subject;
        $this->images = $images;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['telnyx-mms'];
    }


    /**
     * Get the Telnyx / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return TelnyxMmsMessage
     */
    public function toTelnyx($notifiable): TelnyxMmsMessage
    {
        return (new TelnyxMmsMessage())
            ->from($this->from)
            ->content($this->content)
            ->subject($this->subject)
            ->images($this->images);
    }
}
```

Then to use this notification, just import it where you need and run it like below:

```php
use App\Notifications\Alerts\MmsNotification;
…

$from = env('TELNYX_FROM');
$content = 'The text of your mms…';
$subject = 'The mms subject';
$photos = []; //Array with images urls
$member->notify(new MmsNotification($from, $content, $subject, $photos));
```



## Testing

To test you need to create a `.env` file with the Telnyx credentials.
eg.
```
TELNYX_API_KEY=0000000000
TELNYX_FROM=+10000000000
TELNYX_MESSAGING_PROFILE_ID=0000000-0000-0000-000000000
```

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
- [Jernej Beg](https://github.com/jernejbeg)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
