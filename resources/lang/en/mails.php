<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'reset.subject' => 'Reset System Password',
    'reset.greeting' => 'Hello, :Name',
    'reset.first.line' =>
       'You are receiving this email because we received a password reset request for your account.',
    'reset.button.action' => 'Reset Password',
    'reset.second.line' =>
       'If you did not request a password reset, no further action is required.',
    'reset.salutation' => 'Regards',
    'reset.footer' => 'If you’re having trouble clicking the ":actionText" button, copy and paste the URL below
    into your web browser: [:url](:url)',



    //default reset.footer in resources/views/vendor/notifications/email.blade.php
    //If you’re having trouble clicking the "{{ $actionText }}" button
    //, copy and paste the URL below  into your web browser: [{{ $actionUrl }}]({{ $actionUrl }})

];
