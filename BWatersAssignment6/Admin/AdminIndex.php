<?php
/**
* Created by PhpStorm.
 * User: Littleuser314
* Date: 12/2/2017
* Time: 2:19 PM
*/

if($_SESSION['user_id'] == null || !isset($_SESSION['user_id']))
{
    header(index.php);
}


$db = dbConnect();

//Used with finding a particular product
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? "";

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ??
    filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? NULL;

switch($action) {

    //Category management area

    //Call up the page for managing categories
    case 'Manage Categories':
        include_once('Admin/categoryAddForm.php');
        break;
    //Adds a new category, if valid
    case 'Add Category':
        add_category($db);
        include_once("Admin/categoryAddForm.php");
        echo "Category Added";
        break;
    //Brings up the update form for categories
    case 'updateCategory':
        populate_category_form($db, $id);
        break;
    //Edits the category and brings the user back to the category area
    case 'Edit Category':
        $result = update_category($db);
        read_category($db);
        include_once("Admin/categoryAddForm.php");
        break;
    //Deletes a category, if valid
    case 'deleteCategory':
        checkForCategoryDeletion($db, $id);
        break;

    //Product management area

    //Call up the page for managing products
    case 'Manage Products':
        $categories = get_category($db);
        include_once("Admin/productEntryForm.php");
        break;
    //This happens when trying to add a product
    case 'Add Product':
        add_product($db);
        $categories = get_category($db);
        include_once("Admin/productEntryForm.php");
        break;
    //Deletes a product
    case 'deleteProduct':
        remove_product($db, $id);
        $categories = get_category($db);
        include_once("Admin/productEntryForm.php");
        break;
    //Brings the user to the update product form
    case 'updateProduct':
        $cat_list = get_category($db);
        populate_product_form($db, $id, $cat_list);
        break;
    //Updates the product form
    case 'Edit Product':
        $result = update_product($db);
        $categories = get_category($db);
        include_once("Admin/productEntryForm.php");
        break;

    //Default options when the site opens
    default:
        include_once('Admin/ControlPanel.php');
        break;
}