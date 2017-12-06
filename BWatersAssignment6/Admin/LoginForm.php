<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/15/2017
 * Time: 12:08 PM
 */
?>

<!-- This is the form for the login content -->
<div class="container">
    <div class ="row">
        <div class ="col-md-6">

            <h2>Login</h2>
            <section>
                <form method = "post" action = "#">
                    Email: <input type="text" name="user_entry" value="" /> <br>
                    Password: <input type="text" name="password_entry" value="" /> <br>
                    <input type = "submit" name = "action" value = "Login" /><br><br><br>
                    <input type = "submit" name = "action" value = "Back to Start Page" />
                </form>
            </section>

        </div>

        <div clas s ="col-md-6">

            <h2> Sign Up</h2>
            <section>
                <form method = 'post' action = "#">
                    Email: <input type="text" name="new_user" value="" /> <br>
                    Password: <input type="text" name="new_password1" value="" /> <br>
                    Input Password Again: <input type="text" name="new_password2" value="" /> <br>
                    <input type = "submit" name = "action" value = "Create" />
                </form>

            </section>
        </div>
    </div>