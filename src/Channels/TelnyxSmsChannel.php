<?php

namespace AGILEDROP\LaravelTelnyx\Channels;

use AGILEDROP\LaravelTelnyx\Messages\TelnyxMessage;
use Illuminate\Notifications\Notification;

//use Telnyx\ApiOperations\Create;
use Telnyx\Telnyx;

class TelnyxSmsChannel
{
    //use Create;

    /**
     * The Telnyx profile ID
     *
     * @var string
     */
    protected $profileId;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new Telnyx channel instance.
     *
     * @param  string  $from
     * @return void
     */
    public function __construct($profileId, $from)
    {
        $this->profileId = $profileId;
        $this->from = $from;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @return \Telnyx\ApiResource|null
     */
    public function send($notifiable, Notification $notification)
    {
        // routeNotificationFor()  has to be overridden in the user model of the app
        if (! $to = $notifiable->routeNotificationFor('telnyx', $notification)) {
            return;
        }

        // toTelnyx() has to be implemented in the notification
        $message = $notification->toTelnyx($notifiable);

        if (is_string($message)) {
            $message = new TelnyxMessage($message);
        }

        Telnyx::setApiKey(config('laravel-telnyx.api_key'));

        $new_message = \Telnyx\Message::Create([
            "messaging_profile_id" => $this->profileId,
            'from' => $message->from ?: $this->from,
            'to' => $to,
            'text' => trim($message->content),
            //'subject' => 'Picture',
            //'media_urls' => ['https://picsum.photos/500.jpg']
            //'client_ref' => $message->clientReference,
        ]);

        return $new_message;
    }
}
