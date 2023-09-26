<?php

namespace App\Utils;


final class Constants
{

    public static $ERROR_MESSAGE = [
        'success' => 'Success!',
        'user_not_found' => 'User not found!',
        'id_exist' => 'Id exist!',
        'id_not_exist' => 'Id not exist!',
        'invite_user_not_found' => 'Invitation not found / expired',
        'contact_msg' => 'Please call MediDent for assistance for details.',
        'no_email_password' => 'Your password or email is incorrect!',
        'link_expired' => 'Your password reset link has been expired!',
        'password_not_match' => 'Your current password does not match!',
        'id_expired' => 'The id expired or not exist!',
    ];

    public static $ERROR_CODE = [
        'success' => 200,
        'unauthorized' => 401,
        'not_found' => 404,
        'unprocessable_entity' => 422,
        'internal_server_error' => 500,
    ];

    public static $STATUS = [
        'active' => 'active',
        'inactive' => 'inactive',
        'invite' => 'invite',
    ];

}