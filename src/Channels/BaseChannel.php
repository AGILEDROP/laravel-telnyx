<?php

namespace AGILEDROP\LaravelTelnyx\Channels;

use Illuminate\Notifications\Notification;
use Telnyx\Telnyx;

abstract class BaseChannel
{

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
     * @param string $from
     *
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
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return \Telnyx\ApiResource|null
     */
    abstract public function send($notifiable, Notification $notification);
}
