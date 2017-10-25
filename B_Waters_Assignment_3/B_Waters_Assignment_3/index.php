<?php
/**
Benjamin Waters
 * SE266
 * Assignment2
 */

//This is the index page
include_once("assets/corpConnection.php");
require_once("assets/corporation.php");
include_once ("assets/header.php");


$db = corpconn();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";
$corp = filter_input(INPUT_POST, 'corp', FILTER_SANITIZE_STRING) ?? "";
$incorp_dt = filter_input(INPUT_POST, 'incorp_dt', FILTER_SANITIZE_STRING) ?? "";
$email =  filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING) ?? "";
$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING) ?? "";
$owner = filter_input(INPUT_POST, 'owner', FILTER_SANITIZE_STRING)?? "";
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)?? "";


switch($action)
{
    case "Delete":
		$result = delete_record($db, $id);
		echo "Company # " . $result . " deleted.";
        break;
}


echo getCorportations($db);
include_once ("assets/footer.php");
?>