<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 11/26/2017
 * Time: 4:26 PM
 */?>

<div class="container">
    <div class ="row">
        <div class ="col-md-6">
            <h3>Product Updates</h3>
            <section>
                <form method = 'post' action = "#"enctype = "multipart/form-data">
                    <br>
                    Product Name: <input type="text" name="product_entry" value="<?php echo $product_name;?>" /><br>
                    Product Category:
                    <select name='category_drop']>
                        <?php
                        echo("<option selected='selected' value=null>Please choose a category</option>");
                        foreach($cat_list as $cat)
                            if($cat_id == $cat['category_id'])
                            {
                                echo "<option selected = 'selected' value='" . $cat['category_id'] . "'>" . $cat['category'] . "</option>" . PHP_EOL;
                            }
                            else {
                            echo "<option value='" . $cat['category_id'] . "'>" . $cat['category'] . "</option>" . PHP_EOL;
                        }
                        ?>
                    </select>

                    <br> Product Price: <input type="text" name="product_price" value="<?php echo $product_price;?>" />
                    <br>Image file: <input type = 'file' name = 'file'> <br>
                    <input type="hidden" name="product_image" value="<?php echo $product_image;?>" />
                    <br> <input type="hidden" name="product_index" value="<?php echo $product_id;?>" />
                    <br><input type = "submit" name = "action" value = "Edit Product" />
                    <br><input type = "submit" name = "action" value = "Manage Products" />
                </form>
            </section>
        </div>
    </div>
</div>