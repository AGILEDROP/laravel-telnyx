<?php

namespace AGILEDROP\LaravelTelnyx\Messages;

class TelnyxSmsMessage extends TelnyxBaseMessage
{
    /**
     * The message text content.
     *
     * @var string
     */
    public $content;

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
     */
    public function __construct(string $from, string $content)
    {
        $this->content = $content;
        $this->from = $from;
    }
}
