<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/6/2017
 * Time: 1:43 PM
 */

//Benjamin Waters
//Assignment 5
//SE266

require_once('assets/basicHeader.php');
require_once('assets/functions.php');
require_once('assets/dbConnect.php');

$db = dbConnect();

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ??
    filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? NULL;

$url = "";

switch($action) {

    //Checks if the site is valid
    // It it is, and add function is called and a table with the added links in the site is displayed
    //Gives an error message if not
    case 'Add':
        $url = $_POST['url_entry'];
        include_once('assets/standardForm.php');
        $id = add_site($db, $url);
        $link_list = get_links($db, $id);
        buildTable($link_list);
        break;

    //Uses the id of the selected dropdown option to look up the links associated with it
    //Populates a table with a list of the links upon clicking the button
    case 'Lookup':
        $sitelist = get_sites($db);
        $id = $_POST['siteDrop'];
        include_once('assets/SiteLookup.php');
        $link_list = get_links($db, $id);
        get_site_data($db,$link_list);
        buildTable($link_list);
        break;

    //Populates the site lookup form with a dropdown of stored websites
    case 'sitelookup':
        $sitelist = get_sites($db);
        include_once('assets/SiteLookup.php');
        break;

    default:
        include_once('assets/standardForm.php');
        break;
}