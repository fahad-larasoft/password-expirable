<?php

return [

    // # of Days: After which user password gets expired and user should receive password reset email/notification
    'expiry_days' => 2,

    // Expiry message to send in password email/notification
    'expiry_message' => 'It has been over :number days since you reset your password. Please update it now.',

    'strong_password_rules' => 'case_diff|numbers|letters|symbols'
];