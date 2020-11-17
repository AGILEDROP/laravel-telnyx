<?php

namespace AGILEDROP\LaravelTelnyx\Tests\Channels;

use AGILEDROP\LaravelTelnyx\Channels\SmsChannel;
use AGILEDROP\LaravelTelnyx\Messages\TelnyxSmsMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use AGILEDROP\LaravelTelnyx\Tests\TestCase;
use Mockery as m;
//use Nexmo\Client;
use Telnyx\Message;
use Telnyx\Telnyx;


class SmsChannelTest extends TestCase
{
    public function testSmsIsSentViaTelnyx() {
        $notification = new NotificationTelnyxSmsChannelTestNotification;
        $notifiable = new NotificationTelnyxSmsChannelTestNotifiable;

        Telnyx::setApiKey(config('laravel-telnyx.api_key'));

        $channel = new SmsChannel(
            config('laravel-telnyx.messaging_profile_id'),
            config('laravel-telnyx.from'),
        );

        $message = m::mock(Message::class);
        $message->shouldReceive('Create')
            ->with([
                'from' => config('laravel-telnyx.from'),
                'to' => '5555555555',
                'text' => 'this is my message',
            ])
            ->once();

        $channel->send($notifiable, $notification);
    }
}

class NotificationTelnyxSmsChannelTestNotification extends Notification
{
    public function toTelnyx($notifiable)
    {
        return (new TelnyxSmsMessage)
            ->from(config('laravel-telnyx.from'))
            ->content('this is my message');
    }
}

class NotificationTelnyxSmsChannelTestNotifiable
{
    use Notifiable;

    public $phone_number = '5555555555';

    public function routeNotificationForTelnyx($notification)
    {
        return $this->phone_number;
    }
}