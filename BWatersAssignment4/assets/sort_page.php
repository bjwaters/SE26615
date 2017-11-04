<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/4/2017
 * Time: 1:28 PM
 */
?>

<!-- Html sort form used in an include, as requested -->
<section>
    <form method='get' action = ''>
        Sort Column:
        <select name='orderColumn'>
            <?php
            foreach($cols as $col) {
                echo "<option value='" . $col . "'>" . $col . "</option>" . PHP_EOL;
            }
            "</select>";
            ?>

            <input type= 'radio' name='Sort_type' value='ASC' checked> Ascending
            <input type='radio' name='Sort_type' value='DESC'> Descending
            <input type = 'hidden' name='action' value = 'sorting'>
            <input type = 'submit' value = 'Submit Query' />
            <input type = 'submit' name = 'action' value = 'Reset' />
    </form>
</section>