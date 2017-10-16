<?php
require_once("assets/dbconn.php");
require_once("assets/dogs.php");
include_once ("assets/header.php");
$db = dbconn();
var_dump( getDogsAsTable($db) );
include_once ("assets/footer.php");
?>