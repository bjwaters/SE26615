<?php
/**
Benjamin Waters
 * SE266
 * Assignment2
 */

include_once("Assets/corpConnection.php");
include_once("assets/corporation.php");
include_once("assets/header.php");

$db=corpConn();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";

$record = populate_form($db, $id);

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? "";


$corp = filter_input(INPUT_GET, 'corp', FILTER_SANITIZE_STRING);
$incorp_dt = filter_input(INPUT_GET, 'incorp_dt', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_STRING);
$zipcode = filter_input(INPUT_GET, 'zipcode', FILTER_SANITIZE_STRING);
$owner = filter_input(INPUT_GET, 'owner', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_GET, 'phone', FILTER_SANITIZE_STRING);



switch ($action) {
    case "Save":
        $result = update_record($db, $id, $corp, $incorp_dt, $email, $zipcode, $owner, $phone);
        echo($result . "entries added.");
        break;
    }
include_once("assets/footer.php");
