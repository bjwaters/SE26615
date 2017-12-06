<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 12/5/2017
 * Time: 9:45 PM
 */

function Login_admin($number)
{
    $_SESSION['user_id'] = $number;
    //echo "Login session" . var_dump($_SESSION);
}

function Login_stop()
{
    session_destroy();
}