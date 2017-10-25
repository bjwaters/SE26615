<?php
/**
 *Intro on index page
 */
include_once ("assets/header.php");
include_once("assets/corpConnection.php");
require_once("assets/corporation.php");
include_once("assets/emptyForm.php");

$db = corpconn();
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
$corp = filter_input(INPUT_POST, 'corp', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
$owner = filter_input(INPUT_POST, 'owner', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

switch($action)
{
    case "Add":
        //Validation here
        $result = addRecord($db, $corp, $email, $owner, $phone, $zipcode);
        echo"$result company added.";
        break;
}
include_once ("assets/footer.php");