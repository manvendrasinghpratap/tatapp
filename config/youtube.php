<?php

return [

    /**
     * Client ID.
     */
    'client_id' => env('GOOGLE_CLIENT_ID', '754110477572-7einuvvlser3hsf4bpa5h6c4nauth1ll.apps.googleusercontent.com'),

    /**
     * Client Secret.
     */
    'client_secret' => env('GOOGLE_CLIENT_SECRET', 'zSjYB0G3DYQrOe27O12_XAq3'),

    /**
     * Scopes.
     */
    'scopes' => [
        'https://www.googleapis.com/auth/youtube',
        'https://www.googleapis.com/auth/youtube.upload',
        'https://www.googleapis.com/auth/youtube.readonly'
    ],

    /**
     * Route URI's
     */
    'routes' => [

        /** 
         * Determine if the Routes should be disabled.
         * Note: We recommend this to be set to "false" immediately after authentication.
         */
        'enabled' => false,

        /**
         * The prefix for the below URI's
         */
        'prefix' => 'youtube',

        /**
         * Redirect URI
         */
        'redirect_uri' => 'callback',

        /**
         * The autentication URI
         */
        'authentication_uri' => 'auth',

        /**
         * The redirect back URI
         */
        'redirect_back_uri' => '/',

    ]

];
