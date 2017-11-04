<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/3/2017
 * Time: 1:20 PM
 */
?>

<!--This is the form used for the update. -->
<form method="get" action = "#">
    Corporation: <input type="text" id="corp" name = "corp" value="<?php echo $corp;?>" />
    <br />
    Email: <input type="text" id="email" name="email" value="<?php echo $email;?>" />
    <br />
    Zip Code: <input type="text" id="owner" name="zipcode" value="<?php echo $zipcode;?>" />
    <br />
    Owner: <input type="text" id="owner" name="owner" value="<?php echo $owner;?>" />
    <br />
    Phone: <input type="text" id="phone" name="phone" value="<?php echo $phone;?>" />
    <br />
    <input type="hidden" id="incorp_dt" name="incorp_dt" value="<?php echo $incorp_dt;?>" />
    <br>
    <input type="hidden" id="id" name="id" value="<?php echo $id;?>"  />
    <input type="submit" name="action" value="Edit" />
    <a href=index.php?action=View>View</a>
</form>

