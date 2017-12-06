<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 12/3/2017
 * Time: 2:30 PM
 */

//This returns the value of a dropdown
function shopping_category()
{
    $value = $_GET['shopping_drop'];
    if($value == null) {
        echo ("Please try again. No value selected.");
    }
    else
    {
        //echo ("Value is: " . $value . "<br>");
        $returnedValue = $value;
    }
    return $returnedValue;
}


//This code is responsible for adding category data to a form
function products_by_category($db, $category_value){

    $product_bunch = null;

    $sql = $db->prepare("SELECT * FROM products where category_id=:category_id");
    $binds = array(
        ":category_id" => $category_value
    );
    if ($sql->execute($binds) && $sql->rowCount() > 0) {
        $product_bunch = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    if (!isset($category_value)) {
        die("<br>Record not found.");
    }

    if($product_bunch == null)
    {
        echo("Error. Category empty");
    }
    else {
        return $product_bunch;
    }

}

//Shows a nice table of products
function shopping_table($products)
{
    if($products != null) {
        $table = "<table><thead><br> ";
        $table .= "<tr><th>ID</th><th>Name</th><th>Price</th><th>Image</th></tr></thead>";

        foreach ($products as $product) {
            $table .= "<tbody><tr><td>" . $product['product_id'] . "</td>";
            $table .= "<td>" . $product['product'] . "</td>";
            $table .= "<td>" . $product['price'] . "</td>";
            $table .= "<td>" . "<img src = './Uploads/" . $product['image']. "' width='150'</td>";
            $table .= "<td>" . "<a href=index.php?action=AddToCart&id=" . $product['product_id'] . ">Add to Cart</a>" . "</td></tr>";
        }
        $table .= "</tbody></table>";
        echo $table;
    }
    else
    {
        echo "<br>No products in this category.";
    }

}

function get_a_number_for_a_glitchy_form($db)
{
    if (isset($_GET['shopping_drop'])) {
        $category_value = $_GET['shopping_drop'];
        $product_data = products_by_category($db, $category_value);
        echo shopping_table($product_data);
    }
}

//Shows the contents of the shopping cart in a table format
function show_cart($db, $id)
{
    $result = $_SESSION['cart_array'];
    $listing = array_unique($result);

    $table = "<table>";
    $table .= "<thead><th>Product ID</th><th>Product</th><th>Price</th><th>Picture</th></thead>";
    $table .= "<tbody>";
    foreach ($listing as $list) {
        $table .= "<tr>";
        $product = get_a_product($db, $list);
        $table .= "<td>" . $product['product_id'] . "</td>". "<td>" . $product['product'] . "</td><td>" . $product['price'] . "</td><td>";
        $table .=  "<td>" . "<img src = './Uploads/" . $product['image']. "' width='150'</td>";
        $table . "</td></tr>";
    }
    $table .= "</tbody></table>";
    return $table;
}

function total($db){
    $result = $_SESSION['cart_array'];

    $total = 0;

    $listing = array_unique($result);
    foreach ($listing as $list) {
        $product = get_a_product($db, $list);

        //$total += $product['price'] * $_GET['']

    }

}