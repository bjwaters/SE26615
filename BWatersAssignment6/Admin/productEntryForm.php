<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 11/25/2017
 * Time: 7:29 PM
 */
?>


<div class="container">
    <div class ="row">

        <div class="col-md-6">
            <section>
                <form method = 'post' action = "#" enctype = "multipart/form-data">
                    <br>
                    Product Name: <input type="text" name="product_entry" value="" /><br>
                    Product Category:
                    <select name='category_drop']>
                        <?php
                        echo("<option selected='selected' value=null>Please choose a category</option>");
                        foreach($categories as $category)
                        {
                            echo "<option value='" . $category['category_id'] . "'>" . $category['category'] . "</option>" . PHP_EOL;
                        }
                        ?>
                    </select>

                    <br> Product Price: <input type="text" name="product_price" value="" /><br><br>


                    <br>Image file: <input type = 'file' name = 'file'> <br>

                    <br><br><input type = "submit" name = "action" value = "Add Product" /><br><br>

                    <input type = "submit" name = "action" value = "Back to Control Panel" />
                </form>
            </section>
        </div>

        <div class ="col-md-3">
            <?php echo read_products($db);?>
        </div>
    </div>
</div>
