<?php
/**
 *Intro on index page
 */

include_once("assets/corpConnection.php");
require_once("assets/corporation.php");
include_once ("assets/header.php");

$db = corpconn();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";

switch($action)
{
    case "Delete":
        $result = delete_record($db, $id);
        $message =  "Company # " . $result . " deleted." .  "<br><a href=index.php?action=View>View</a>";
        echo  $message;
        break;
}
include_once ("assets/footer.php");