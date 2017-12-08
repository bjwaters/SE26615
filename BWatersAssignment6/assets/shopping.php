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

//Shows a nice table of products for the shopping page
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

//Makes a table for the checkout page
function checkout_table($products, $counter, $subtotal)
{
    if($products != null) {
        $table = "<table><thead><br> ";
        $table .= "<tr><th>Number</th><th>Name</th><th>Price</th><th>Image</th><th>Subtotal</th></tr></thead>";

        foreach ($products as $product) {
            $table .= "<tbody><tr><td>" . $_SESSION['cart'][$counter]['qty']. "</td>";
            $table .= "<td>" . $product['product'] . "</td>";
            $table .= "<td>" . $product['price'] . "</td>";
            $table .= "<td>" . "<img src = './Uploads/" . $product['image']. "' width='150'</td>";
            $table .= "<td>" . $subtotal. "</td>";

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
    $table .= "<thead><th>ID</th><th>Product</th><th>Price</th><th>Picture</th></thead>";
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

//Creates a session with each product
function ShoppingSession($db){


    //$checkoutArray =  array();

    try{
        $stmt = $db->prepare("SELECT * FROM products");

        if($stmt->execute() && $stmt->rowCount() > 0)
        {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($products as $product)
            {
                $var = array('id' =>$product['product_id'], 'price'=>$product['price'], 'qty'=>0);
                array_push($_SESSION['cart'], $var);
            }
        }
        else
        {
            echo "No products stored.";
        }
    }catch(PDOException $e)
    {
        die("Grabbing the user list didn't work.");
    }


}

//Adds an item to the cart, or rather, the session counter
function addToCart($id)
{
    $results = $_SESSION['cart'];
    $counter = 0;

    foreach($results as $result)
    {
        if($result['id'] == $id)
        {
            //This is the part of the session to change
            //var_dump($_SESSION['cart'][$counter]);
            $_SESSION['cart'][$counter]['qty']++;
            echo"<br>";
            //var_dump($_SESSION['cart'][$counter]['qty']);
        }
        $counter++;
    }
}

//clears the cart
function clearCart()
{
    $results = $_SESSION['cart'];
    $_SESSION['counter'] = 0;
    $counter = 0;

    foreach($results as $result)
    {
       $_SESSION['cart'][$counter]['qty'] = 0;
       $counter++;
    }
    //var_dump($_SESSION['cart']);
}

//Gives the total of the purchases
function printTotal($db)
{
    $results = $_SESSION['cart'];
    $subtotal = "";
    $total = "";
    $counter = 0;


    foreach($results as $result)
    {
        if($result['qty'] > 0)
        {
            $subtotal = $_SESSION['cart'][$counter]['qty'] * $_SESSION['cart'][$counter]['price'];
            //echo $_SESSION['cart'][$counter]['qty'] . "and " . $_SESSION['cart'][$counter]['price'];
            echo "<br>";
            $id = $_SESSION['cart'][$counter]['id'];
            $product = array();
            array_push($product, get_a_product($db,$id));
            checkout_table($product, $counter, $subtotal);
            $total += $subtotal;
        }
        $counter++;
    }
    echo "The total comes to: $" . $total;

}