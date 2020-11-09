<?php

return [
    /*
     * The API KEY.
     *
     * You can generate API keys from the Telnyx web interface.
     * See https://developers.telnyx.com/docs/v2/development/authentication for details
     */
    'api_key' => env('TELNYX_API_KEY'),

    /*
     * The phone number or a text that is shown as sender
     *
     */
    'from' => env('TELNYX_FROM'), // Can be phone number or name

    /*
     * The messaging profile id.
     * Also generated from the Telnyx web interface.
     */
    'messaging_profile_id' => env('TELNYX_MESSAGING_PROFILE_ID'),
];
