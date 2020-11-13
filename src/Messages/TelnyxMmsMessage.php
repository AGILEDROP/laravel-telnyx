<?php

namespace AGILEDROP\LaravelTelnyx\Messages;

class TelnyxMmsMessage extends TelnyxBaseMessage
{
    /**
     * The message text content.
     *
     * @var string
     */
    public $content;

    /**
     * The message subject
     *
     * @var string
     */
    public $subject;

    /**
     * The message image urls
     *
     * @var string
     */
    public $images;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The message type.
     *
     * @var string
     */
    public $type = 'text';

    /**
     * The custom Telnyx client instance.
     *
     * @var \Telnyx\Client|null
     */
    public $client;

    /**
     * The client reference.
     *
     * @var string
     */
    public $clientReference = '';

    /**
     * Create a new message instance.
     *
     * @param  string  $from
     * @param  string  $content
     * @param  string  $subject
     * @param  array|null  $images
     */
    public function __construct(string $from, string $content, string $subject = '', array $images = null)
    {
        $this->content = $content;
        $this->subject = $subject;
        $this->images = $images;
        $this->from = $from;
    }

}
