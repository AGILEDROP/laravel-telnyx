<?php

namespace AGILEDROP\LaravelTelnyx\Channels;

use Illuminate\Notifications\Notification;
use Telnyx\Message;
use Telnyx\Telnyx;

class MmsChannel extends BaseChannel
{
    /**
     * Send the given notification trough MMS
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @return \Telnyx\ApiResource|void
     */
    public function send($notifiable, Notification $notification)
    {
        // routeNotificationFor()  has to be overridden in the user model of the app
        if (! $to = $notifiable->routeNotificationFor('telnyx', $notification)) {
            return;
        }

        // toTelnyx() has to be implemented in the notification
        $message = $notification->toTelnyx($notifiable);

        Telnyx::setApiKey(config('laravel-telnyx.api_key'));

        return Message::Create([
            "messaging_profile_id" => $this->profileId,
            'from' => $message->from ?: $this->from,
            'to' => $to,
            'text' => trim($message->content),
            'subject' => $message->subject,
            'media_urls' => $message->images,
        ]);
    }
}
