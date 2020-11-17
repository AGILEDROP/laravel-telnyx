<?php

namespace AGILEDROP\LaravelTelnyx\Messages;

class TelnyxSmsMessage extends TelnyxBaseMessage
{
    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public ?string $from = null;

    /**
     * The message text content.
     *
     * @var string
     */
    public ?string $content = null;

    /**
     * Set the from phone number for the sms message.
     *
     * @param $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the content of the the sms message.
     *
     * @param  string  $content
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }
}
