<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 12/6/2017
 * Time: 11:34 AM
 */

?>

<div class="container">
    <div class ="row">
        <div class ="col-md-3">
        <h2>Checkout Page</h2>
            <br>

            <?php
            if (count($_SESSION['cart_array'])) {
                echo show_cart($db, $id);
            }
            else
                echo("Nothing added, sorry.")
            ?>

            <form method = 'get' action = "#">
            <br><br><input type = "submit" name = "action" value = "Back to Shopping Page" />
            </form>

        </div>
    </div>
</div>
