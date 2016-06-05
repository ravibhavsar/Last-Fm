<?php

/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 6/5/16
 * Time: 12:32 AM
 */
class Message
{

    public static $zeroResponse = [
        'code' => '0',
        'message' => 'Zero artist found.'
    ];
    public static $zeroResponsePage = [
        'code' => '0',
        'message' => 'No artist returned by Last Fm on this page.'
    ];


    /* Errors */
    public static $invalidCountry = [
        'code' => '6',
        'message' => 'Invalid country.'
    ];
    public static $operationFailed = [
        'code' => '8',
        'message' => 'Something went wrong. Your operation did not work.'
    ];

}