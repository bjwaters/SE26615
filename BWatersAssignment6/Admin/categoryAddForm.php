<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 11/25/2017
 * Time: 4:35 PM
 */
?>

<div class="container">
    <div class ="row">
        <div class ="col-md-6">

            <h3>Categories</h3>
            <?php echo read_category($db);?>
            <section>
                <form method = 'post' action = "#">
                    <br>
                    Category Name: <input type="text" name="category_entry" value="" /><br>
                    <input type = "submit" name = "action" value = "Add Category" /> <br><br>
                    <input type = "submit" name = "action" value = "Back to Control Panel" />
                </form>
            </section>
        </div>
    </div>
</div>