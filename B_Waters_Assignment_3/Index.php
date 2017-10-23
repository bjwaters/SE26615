<?php

/**
Benjamin Waters
 * SE266
 * Assignment2
 */

//This is the index page
require_once("assets/corpconn.php");
require_once("assets/corporation.php");
include_once ("assets/header.php");

$db = corpconn();
echo getCorportations($db);

include_once ("assets/footer.php");
?>