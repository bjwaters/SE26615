<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 11/7/2017
 * Time: 10:22 PM
 */
?>

<!-- A little php is needed to populate the site dropdown list and to ensure the last selected value is highlighted -->
<section>
    <br>
    <form method="post" action = "#">
        <select name='siteDrop']>
            <?php
            echo("<option selected='selected' value='Pick a site'>Please choose a website</option>");
            foreach($sitelist as $site) {
                if($id == $site['site_id'])
                {
                    echo "<option selected = 'selected' value='" . $site['site_id'] . "'>" . $site['site'] . "</option>" . PHP_EOL;
                }
                else {
                    echo "<option value='" . $site['site_id'] . "'>" . $site['site'] . "</option>" . PHP_EOL;
                }
            }
            ?>
        </select>
        <input type = "submit" name = "action" value = "Lookup" />

        </select>

    </form>
</section>

