<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 10/18/2017
 * Time: 1:11 PM
 */
function actorConn()
{
    $dsn = "mysql:host=localhost; dbname=phpclassfall2017";
    $username = "bjwaters";
    $password = "php";
    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("There was a problem connection to the database.");
    }
}