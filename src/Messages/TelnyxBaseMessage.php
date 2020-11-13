<?php

namespace AGILEDROP\LaravelTelnyx\Messages;

abstract class TelnyxBaseMessage
{
    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the message type.
     *
     * @return $this
     */
    public function unicode()
    {
        $this->type = 'unicode';

        return $this;
    }

    /**
     * Set the client reference (up to 40 characters).
     *
     * @param  string  $clientReference
     * @return $this
     */
    public function clientReference($clientReference)
    {
        $this->clientReference = $clientReference;

        return $this;
    }

    /**
     * Set the Telnyx client instance.
     *
     * @param $client
     *
     * @return $this
     */
    public function usingClient($client)
    {
        $this->client = $client;

        return $this;
    }
}
