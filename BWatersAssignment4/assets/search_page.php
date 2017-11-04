<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/4/2017
 * Time: 1:28 PM
 */
?>

<!-- Html search form used in an include, as requested -->
<section>
<form method='get' action = ''>
Search Column:
<select name='textColumn'>
    <?php

        foreach($cols as $col) {
            echo "<option value='" . $col . "'>" . $col . "</option>" . PHP_EOL;
        }
        "</select>";
?>
 Term: <input type='text' name='term' />
<input type = 'hidden' name='action' value = 'searching'>
<input type = 'submit' value = 'Submit Query' />
<input type = 'submit' name = 'action' value = 'Reset' />
</form>
</section>
<br>