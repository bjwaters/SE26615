<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 11/7/2017
 * Time: 5:26 PM
 */
function dbConnect()
{
    $dsn = "mysql:host=localhost; dbname=phpclassfall2017";
    $username = "bjwaters";
    $password = "php";
    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        //Error message
        die("There was a problem connection to the database.");
    }
}
