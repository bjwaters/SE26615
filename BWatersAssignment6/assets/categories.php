<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/15/2017
 * Time: 12:05 PM
 */

//Adding a category to the table
function add_category($db)
{
    $catName = $_POST['category_entry'];

    //If the text box isn't empty
    if($catName != "") {

        $alreadyUsed = false;

        try {
            $stmt = $db->prepare("SELECT * FROM categories");


            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $category) {
                    if ($catName == $category) {
                        $alreadyUsed = true;
                    }
                }
            }
        } catch (PDOException $e) {
            die("Error. Could not access the category table.");
        }

        //If the text box contains something that isn't in the table
        //And the dropdown has something selected
        if ($alreadyUsed == false)
        {
            try {
                $stmt = $db->prepare("INSERT INTO categories VALUES (null, :category)");
                $stmt->bindParam(':category', $catName);
                $stmt->execute();
            } catch (PDOException $e) {
                die("<br>Adding a category did not work. It already exists.");
            }
        }
    }
}

//Checking for category deletion
//Searches the product table for items in that category
//If there are products, do not delete
//If there are no products, continue deletion
function checkForCategoryDeletion($db, $id)
{
    $goodForDeletion = true;

    try {
        $stmt = $db->prepare("SELECT * FROM products");

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($products as $product)
            {
                if($product['category_id'] == $id)
                {
                    $goodForDeletion = false;
                }
            }
        }
    } catch (PDOException $e) {
        die("No products to grab.");
    }

    if($goodForDeletion == true)
    {
        remove_category($db, $id);
        include_once("Admin/categoryAddForm.php");

        echo "Category Deleted";
    }
    else
    {
        include_once("Admin/categoryAddForm.php");
        echo "Product in this category. No deletion processed.";
    }
}

//Simply deletes a category when called
function remove_category($db, $id)
{

    try {
        $sql = $db->prepare("DELETE FROM categories WHERE category_id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }catch(PDOException $e)
    {
        die("Deleting did not work.");
    }
}

//Gets a list of the existing categories for a dropdown
function get_category($db)
{
    try {
        $stmt = $db->prepare("SELECT * FROM categories");
        $category_list = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $category_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $category_list;
    } catch (PDOException $e) {
        die("No categories to grab.");
    }
}

//Reads the categories into a table, if applicable
function read_category($db)
{
    try{
        $stmt = $db->prepare("SELECT * FROM categories");

        $table = "<table>";

        if($stmt->execute() && $stmt->rowCount() > 0)
        {
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($categories as $category)
            {
                $table .= "<tr><td>" . $category['category'] . "</td>";
                $table .= "<td>" . "<a href=index.php?action=deleteCategory&id=" . $category['category_id'] . ">Delete</a>" . "</td>";
                $table .= "<td>" . "<a href=index.php?action=updateCategory&id=" . $category['category_id'] . ">Update</a>" . "</td>";
            }
        }
        else
        {
            $table .= "<tr><td>No categories stored </td></tr>";
        }

        $table .= "</table>";
        echo($table);
    }catch(PDOException $e)
    {
        die("Grabbing the user list didn't work.");
    }
}


//This code is responsible for adding data to the product update form
function populate_category_form($db, $id){

    $sql = $db->prepare("SELECT * FROM categories where category_id=:id");
    $binds = array(
        ":id" => $id
    );
    if ($sql->execute($binds) && $sql->rowCount() > 0) {
        $found_category = $sql->fetch(PDO::FETCH_ASSOC);
    }
    if (!isset($id)) {
        die("Record not found.");
    }
    $category_name = $found_category['category'];
    $category_id = $found_category['category_id'];

    include_once("Admin/categoryUpdateForm.php");

}

//This code updates a category name
function update_category ($db){

    $category = $_POST['category_edit'];
    $category_id = $_POST['category_index'];

    try{
        $sql = $db->prepare("UPDATE categories SET category=:category WHERE category_id=:category_id");
        $sql->bindparam(':category_id', $category_id);
        $sql->bindparam(':category', $category);
        $sql->execute();
        return $sql ->rowCount();
    }catch(PDOException $e)
    {
        die("Category update did not work.");
    }

}

//Sending in a category number, sending out a category name
function categoryNameGrab($db, $number)
{
    try{
        $stmt = $db->prepare("SELECT * FROM categories WHERE category_id = :category_id");
        $stmt->bindParam(':category_id', $number);

        if($stmt->execute() && $stmt->rowCount() > 0)
        {
            $categories = $stmt->fetch(PDO::FETCH_ASSOC);
            return $categories['category'];
        }
        else
        {
            echo("Nothing in the category table.");
        }

    }catch(PDOException $e)
    {
        die("Grabbing the category list didn't work.");
    }
}