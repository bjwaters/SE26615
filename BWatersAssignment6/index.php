<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/15/2017
 * Time: 11:56 AM
 */

session_start();

require_once('session.php');
require_once('assets/categories.php');
require_once('assets/dbConnect.php');
require_once('Admin/userRelatedCode.php');
require_once('assets/products.php');
require_once('assets/shopping.php');
include_once('assets/header.php');

$db = dbConnect();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ??
    filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? NULL;


switch($action){

    //Choose which side to pick on the site

    //Go to shopping page
    case 'Shopping Page':
        $_SESSION['cart_array'] = array();
        $category_list = get_category($db);
        include_once("assets/ShoppingForm.php");
        break;
    //Go to the login page
    case 'Admin Side':
        include_once('Admin/LoginForm.php');
        break;
    case 'Back to Shopping Page':
        $category_list = get_category($db);
        include_once("assets/ShoppingForm.php");
        break;
    case 'Total':
        break;

    //This is a series of back buttons to earlier parts of the program
    case 'Back to Control Panel':
        include_once('Admin/ControlPanel.php');
        break;
    case 'Back to Start Page':
        include_once('assets/StartPage.php');
        break;
    case 'Back to Login Page':
        include_once("Admin/LoginForm.php");
        break;


    //Shopping area

    case 'Submit':
        $category_value = shopping_category();
        $category_list = get_category($db);
        $product_data = products_by_category($db, $category_value);
        include_once('assets/ShoppingForm.php');
        break;
    case 'AddToCart':
        array_push($_SESSION['cart_array'], $id);

        $category_list = get_category($db);
        include_once('assets/ShoppingForm.php');
        break;
    case 'Shopping Cart':

        include_once('assets/CheckoutForm.php');
        break;

    //The following options are sent to adminindex, which has a check for a session at the top
    case 'Manage Categories':
        echo ("Category selected from index.");
        include_once('Admin/AdminIndex.php');
        break;
    //Adds a new category, if valid
    case 'Add Category':
        include_once('Admin/AdminIndex.php');
        break;
    //Brings up the update form for categories
    case 'updateCategory':
        include_once('Admin/AdminIndex.php');
        break;
    //Edits the category and brings the user back to the category area
    case 'Edit Category':
        include_once('Admin/AdminIndex.php');
        break;
    //Deletes a category, if valid
    case 'deleteCategory':
        include_once('Admin/AdminIndex.php');
        break;

    //Goes to the product part of the admin
    case 'Manage Products':
        include_once('Admin/AdminIndex.php');
        break;
    //This happens when trying to add a product
    case 'Add Product':
        include_once('Admin/AdminIndex.php');
        break;
    //Deletes a product
    case 'deleteProduct':
        include_once('Admin/AdminIndex.php');
        break;
    //Brings the user to the update product form
    case 'updateProduct':
        include_once('Admin/AdminIndex.php');
        break;
    //Updates the product form
    case 'Edit Product':
        include_once('Admin/AdminIndex.php');
        break;


    //User login area

    //Verify the information for login
    case 'Login':
        $valid = loginTest($db);
        if($valid != "")
        {
            //Important session info here
            login_Admin($valid);
            include_once('Admin/AdminIndex.php');
        }
        else
        {
            include_once('Admin/LoginForm.php');
            echo("Error. No such user and password combination stored.\nPlease try again.");
        }
        break;
    //Creates a new user if the name is unused and the passwords match
    case 'Create':
        $user_found = find_user($db);
        passwordTest($db, $user_found);
        break;
    case 'Logoff':
        Login_stop();
        include_once('assets/StartPage.php');
        break;


    //Default options when the site opens
    default:
        include_once('assets/StartPage.php');
        break;
}