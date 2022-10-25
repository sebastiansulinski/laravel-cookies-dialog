<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cookie Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of the cookie that will be
    | installed on user's machine to indicate that
    | third party cookies were enabled.
    |
    */

    'name' => 'third_party_cookies',

    /*
    |--------------------------------------------------------------------------
    | Shared Variables Names
    |--------------------------------------------------------------------------
    |
    | These values represent names of the shared variables
    | accessible via Share->all() or Share->get()
    | methods, which will be passed to js
    | components and view files.
    |
    */

    'show' => 'showCookiesDialog',

    'third_party' => 'thirdPartyCookies',

];