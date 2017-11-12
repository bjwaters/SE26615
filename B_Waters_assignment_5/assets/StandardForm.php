<?php
/**
 * Created by PhpStorm.
 * User: Littleuser314
 * Date: 11/7/2017
 * Time: 9:09 PM
 */
?>

<!-- The text box for the url is populated by the php variable $url. It is "" at first, but is populated by the last input sent afterward -->
<section>
    <form method="post" action = "#">
        <br>
        URL:<input type="text" name="url_entry" value="<?php echo $url; ?>" />
        <input type = "submit" name = "action" value = "Add" />

    </form>
</section>
