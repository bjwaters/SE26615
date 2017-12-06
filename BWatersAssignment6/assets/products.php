<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/15/2017
 * Time: 12:04 PM
 */

/*
function product_picture()
{
    $message = "";
    $name = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];

    echo("In the product picture function<br>");

    if(isset($name))
    {
        if(!empty($name))
        {
            $location = 'Uploads/';
            move_uploaded_file($tmp_name, $location.$name);
            $message = "Uploaded";
        }
        else
        {
            $message =  "Not Uploaded";
        }
    }
    return $message;
}
*/

//This function checks if there are duplicate entries to add, and if not, adds a product
function add_product($db)
{
    $productName = $_POST['product_entry'];

    //If the text box isn't empty
    if($productName != "") {

        $alreadyUsed = false;

        try {
            $stmt = $db->prepare("SELECT * FROM products");


            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($products as $product) {
                    if ($product['product'] == $productName) {
                        $alreadyUsed = true;
                    }
                }
            }
        } catch (PDOException $e) {
            die("Error. Could not access the category table.");
        }


        //File area
        $name = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];

        if(isset($name))
        {
            if(!empty($name))
            {
                $location = 'Uploads/';
                move_uploaded_file($tmp_name, $location.$name);
            }
        }

        if(!empty($name)) {
            //Grabbing the date from the product form
            $id = $_POST['category_drop'];
            $name = $_POST['product_entry'];
            $price = $_POST['product_price'];
            $image = $_FILES['file']['name'];

            //If the text box contains something that isn't in the table
            //And the dropdown has something selected
            if ($alreadyUsed == false && $id != null) {
                if (filter_var($price, FILTER_VALIDATE_FLOAT)) {
                    try {
                        $stmt = $db->prepare("INSERT INTO products VALUES (null, :category_id, :product, :price, :image)");
                        $stmt->bindParam(':category_id', $id);
                        $stmt->bindParam(':product', $name);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':image', $image);
                        $stmt->execute();
                        echo "Product entry valid.";
                    } catch (PDOException $e) {
                        die("<br>Adding a product did not work. No category entered.");
                    }
                } else {
                    echo("Invalid price. Please enter a proper number.");
                }
            } else {
                echo("Error. Product already exists, or no category entered. Please look over your data.");
            }
        }
        else
            die ("No file selected at add");
    }
}

function remove_product($db, $id)
{

    try {
        $sql = $db->prepare("DELETE FROM products WHERE product_id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }catch(PDOException $e)
    {
        die("Deleting did not work.");
    }
}

//Produces a table of the products and their information
function read_products($db)
{
    try{
        $stmt = $db->prepare("SELECT * FROM products");

        $table = "<table>";

        if($stmt->execute() && $stmt->rowCount() > 0)
        {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $table .= "<br>";
            $table .= "<tr><td>Product</td><td>Category</td><td>Price</td><td>Image</td></tr><tr></tr>";
            foreach($products as $product)
            {
                $table .= "<tr><td>" . $product['product'] . "</td>";

                $table .= "<td>" . categoryNameGrab($db, $product['category_id']) . "</td>";

                $table .= "<td>" .  $product['price'] . "</td>";
                $table .= "<td>" . "<img src = './Uploads/" . $product['image']. "' width='150'</td>";
                $table .= "<td>" . "<a href=index.php?action=deleteProduct&id=" . $product['product_id'] . ">Delete</a>" . "</td>";
                $table .= "<td>" . "<a href=index.php?action=updateProduct&id=" . $product['product_id'] . ">Update</a>" . "</td>";
            }
        }
        else
        {
            $table .= "<tr><td>No products stored. </td></tr>";
        }

        $table .= "</table>";
        echo($table);
    }catch(PDOException $e)
    {
        die("Grabbing the user list didn't work.");
    }
}

//This code is responsible for adding category data to a form
function populate_product_form($db, $id, $cat_list){

    $sql = $db->prepare("SELECT * FROM products where product_id=:id");
    $binds = array(
        ":id" => $id
    );
    if ($sql->execute($binds) && $sql->rowCount() > 0) {
        $found_product = $sql->fetch(PDO::FETCH_ASSOC);
    }
    if (!isset($id)) {
        die("Record not found.");
    }
    $product_name = $found_product['product'];
    $product_price = $found_product['price'];
    $product_image = $found_product['image'];
    $cat_id = $found_product['category_id'];
    $product_id = $found_product['product_id'];

    include_once("Admin/ProductUpdateForm.php");

}

//This code is responsible for getting a product's info
function get_a_product($db, $id){

    $sql = $db->prepare("SELECT * FROM products where product_id=:id");
    $binds = array(
        ":id" => $id
    );
    if ($sql->execute($binds) && $sql->rowCount() > 0) {
        $product = $sql->fetch(PDO::FETCH_ASSOC);

        return $product;
    }
    if (!isset($id)) {
        die("Record not found.");
    }
}

//Updating an entry in the product database
function update_product($db){

    $category_id = $_POST['category_drop'];
    $product = $_POST['product_entry'];
    $price = $_POST['product_price'];
    $image = $_POST['product_image'];
    $product_id = $_POST['product_index'];

    if(filter_var($price, FILTER_VALIDATE_FLOAT)) {
        try {
            $sql = $db->prepare("UPDATE products SET category_id = :category_id,  product=:product, price=:price, image=:image WHERE product_id=:product_id");
            $sql->bindparam(':category_id', $category_id);
            $sql->bindparam(':product', $product);
            $sql->bindparam(':price', $price);
            $sql->bindparam(':image', $image);
            $sql->bindparam(':product_id', $product_id);
            $sql->execute();
            return $sql->rowCount();
        } catch (PDOException $e) {
            die("Product update did not work.");
        }
    }
    else
    {
        echo("Error. Invalid price entered. Please use a proper number.");
    }

}