<?php

namespace AGILEDROP\LaravelTelnyx\Channels;

use AGILEDROP\LaravelTelnyx\Messages\TelnyxMessage;
use Illuminate\Notifications\Notification;
use Telnyx\Telnyx;

class MmsChannel extends BaseChannel
{
    /**
     * Send the given notification trough MMS.
     *
     * The Telnyx API knows to send an MMS message when media_urls is specified.
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

        return \Telnyx\Message::Create([
            "messaging_profile_id" => $this->profileId,
            'from' => $message->from ?: $this->from,
            'to' => $to,
            'text' => trim($message->content),
            'subject' => 'Alert from NUM',
            'media_urls' => $message->images,
        ]);
    }
}
