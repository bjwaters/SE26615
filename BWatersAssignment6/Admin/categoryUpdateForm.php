<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/27/2017
 * Time: 11:35 AM
 */?>

<div class="container">
    <div class ="row">
        <div class ="col-md-6">
            <section>
                <form method = 'post' action = "#">
                    Category Name: <input type="text" name="category_edit" value="<?php echo $category_name;?>" /><br>
                    <input type = "submit" name = "action" value = "Edit Category" />
                    <input type="hidden" name="category_index" value="<?php echo $category_id;?>" /><br>
                    <input type = "submit" name = "action" value = "Manage Categories" />

                </form>
            </section>
        </div>
    </div>
</div>