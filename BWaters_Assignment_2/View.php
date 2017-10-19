<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 10/18/2017
 * Time: 2:21 PM
 */
//Adding the required elements
require_once("assets/actorConn.php");
require_once("assets/actors.php");
include_once ("assets/header.php");

//Connecting, then filtering the aspects of the actor, as well as the action
$db = actorConn();
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? "";
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) ?? "";
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) ?? "";
$dob = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING) ?? "";
$height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_STRING)?? "";

//Show the table of actors
echo getActorsAsTable($db);
include_once ("assets/footer.php");
?>