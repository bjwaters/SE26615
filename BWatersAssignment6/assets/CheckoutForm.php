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
        <h3>Checkout results</h3>
            <h4> (Scroll down for longer checkouts)</h4>
            <br>

            <?php echo printTotal($db)?>
            <form method = 'get' action = "#">
            <br><br><input type = "submit" name = "action" value = "Back to Shopping Page" />
            </form>

        </div>
    </div>
</div>
