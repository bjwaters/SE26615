<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/1/2017
 * Time: 1:25 PM
 */

require_once('assets/dbConnect.php');
require_once('assets/corpView.php');
require_once('assets/corporation.php');

$db = corpConn();
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ??
    filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? NULL;


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";

//For the adding and updating
$corp =filter_input(INPUT_POST, 'corp', FILTER_SANITIZE_STRING)
    ?? filter_input(INPUT_GET, 'corp', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)
    ?? filter_input(INPUT_GET, 'email', FILTER_SANITIZE_STRING);
$owner = filter_input(INPUT_POST, 'owner', FILTER_SANITIZE_STRING)
    ?? filter_input(INPUT_GET, 'owner', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)
    ?? filter_input(INPUT_GET, 'phone', FILTER_SANITIZE_STRING);
$zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING)
    ?? filter_input(INPUT_GET, 'zipcode', FILTER_SANITIZE_STRING);
$incorp_dt = filter_input(INPUT_POST, 'incorp_dt', FILTER_SANITIZE_STRING)
    ?? filter_input(INPUT_GET, 'incorp_dt', FILTER_SANITIZE_STRING);

include_once('assets/header.php');

switch($action){
    //This reads the information for one company and displays it
    case 'read':
        //This executes the function responsible for giving a single line of information
        echo read_corp($db, $id);
        break;
    //This is what happens when the create link is clicked and an empty form is created
    case 'new':
        include_once('assets/corp_form.php');
        break;
    //This saves the new information in the empty form
    case 'Save':
        $addition = add_corp($db, $corp, $email, $owner, $phone, $zipcode);
        $message = $addition .  " record added.";
        echo $message;
        include_once('assets/corp_form.php');
        break;
    //This takes the code from the update form, and updates the values to the databse
    case 'Edit':
        $result = update_record($db, $id,  $corp, $incorp_dt,  $email, $owner, $phone, $zipcode);
        echo $result . " record updated.";
        echo "<br> <a href='index.php?'>View</a>";
        break;
    //This code populates a form with the data from a company
    case 'update':
        populate_form($db, $id);
        break;
    //This is what happens when delete is selected
    case 'delete':
        $deletion = delete_corp($db, $id);
        $message = "Company " . $deletion . " removed." . "<br> <a href='index.php?'>View</a>";
        echo $message;
        break;
    //This is what is called when the search uses the column name and asc/desc
    case 'sorting':
        $result = sort_list($db);
        $cols = getColumnNames($db, 'corps');
        include_once('assets/sort_page.php');
        include_once('assets/search_page.php');
        echo $result;
        break;
    //This is what is called when a text string is searched
    case 'searching':
        $result = search_list($db);
        $cols = getColumnNames($db, 'corps');
        include_once('assets/sort_page.php');
        include_once('assets/search_page.php');
        echo $result;
        break;
    case 'Reset':
        //Getting the information about the corporations
        $corporations = getCorpInfo($db);
        //Getting the column names
        $cols = getColumnNames($db, 'corps');
        //Showing the query form for searches
        include_once('assets/sort_page.php');
        include_once('assets/search_page.php');
        //Showing the Corporation list default
        echo get_Corporations($db);
        break;
    //Default, no conditional showing
    default:
        //Getting the information about the corporations
        $corporations = getCorpInfo($db);
        //Getting the column names
        $cols = getColumnNames($db, 'corps');
        //Showing the query form for searches
        include_once('assets/sort_page.php');
        include_once('assets/search_page.php');
        //Showing the Corporation list default
        echo get_Corporations($db);
        break;
}