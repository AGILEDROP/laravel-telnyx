<?php

namespace AGILEDROP\LaravelTelnyx\Messages;

class TelnyxMmsMessage extends TelnyxBaseMessage
{
    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public string $from;

    /**
     * The message text content.
     *
     * @var string
     */
    public string $content;

    /**
     * The message subject
     *
     * @var string
     */
    public string $subject;

    /**
     * The message image urls
     *
     * @var array
     */
    public array $images;

    /**
     * Set the from phone number for the mms message.
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
     * Set the content of the the mms message.
     *
     * @param  string  $content
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the subject of the mms message.
     *
     * @param $subject
     *
     * @return $this
     */
    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set the images of the the mms message.
     *
     * @param  array  $images
     * @return $this
     */
    public function images(array $images)
    {
        $this->images = $images;

        return $this;
    }
}
