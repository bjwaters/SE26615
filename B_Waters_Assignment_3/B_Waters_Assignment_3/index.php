<?php
/**
Benjamin Waters
 * SE266
 * Assignment3

 */

//This is the main page, where everything starts properly

include_once("assets/corpConnection.php");
require_once("assets/corporation.php");
include_once ("assets/header.php");

//Establishing variables used later on
$db = corpconn();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";
$corp = filter_input(INPUT_POST, 'corp', FILTER_SANITIZE_STRING) ?? "";
$incorp_dt = filter_input(INPUT_POST, 'incorp_dt', FILTER_SANITIZE_STRING) ?? "";
$email =  filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING) ?? "";
$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING) ?? "";
$owner = filter_input(INPUT_POST, 'owner', FILTER_SANITIZE_STRING)?? "";
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)?? "";

//This is used every time the index page is shown.
echo getCorportations($db);
include_once ("assets/footer.php");
?>