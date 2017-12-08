<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 12/2/2017
 * Time: 4:49 PM
 */
?>

<div class="container">
    <div class ="row">
        <div class ="col-md-3">

            <section>
                <form method = 'get' action = "#">
                    <br>
                    <p>Please choose your category, and the available products will be shown.</p>
                    Product Category:
                    <select name='shopping_drop']>
                        <?php
                        foreach($category_list as $category)
                        {
                            echo "<option value='" . $category['category_id'] . "' selected='selected'>" . $category['category'] . "</option>" . PHP_EOL;
                        }
                        ?>
                    </select>

                    <input type = "submit" name = "action" value = "Submit" /><br><br>
                    <?php
                        echo $_SESSION['counter'] . " Items added." ?>
                    <br><br>
                    <input type = "submit" name = "action" value = "Shopping Cart" />
                    <input type = "submit" name = "action" value = "Logoff" />
                    <br> <input type = "submit" name = "action" value = "Clear Cart" />
                </form>
            </section>
        </div>

        <div class ="col-md-9">
            <?php echo get_a_number_for_a_glitchy_form($db) ?>
        </div>
    </div>

</div>