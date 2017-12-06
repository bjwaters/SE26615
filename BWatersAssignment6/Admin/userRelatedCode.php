<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/15/2017
 * Time: 12:04 PM
 */

//Looks for a user name in the database
function find_user($db)
{
    $email = $_POST['new_user'];
    $found = false;
    try{
        $stmt = $db->prepare("SELECT email FROM users");
        $users = array();

        if($stmt->execute() && $stmt->rowCount() > 0)
        {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($users as $user)
            {
                if($user['email'] == $email)
                {
                   $found = true;
                }
            }
        }
        else
            echo("No users in list <br>");
        return($found);
    }catch(PDOException $e)
    {
        die("Grabbing the user list didn't work.");
    }
}

//Tests to see if both passwords input match
function passwordTest($db, $found)
{
    $email = $_POST['new_user'];
    $password1 = $_POST['new_password1'];
    $password2 = $_POST['new_password2'];

    if($found == true) {
        include_once("Admin/LoginForm.php");
        echo("User already found. Please enter another name.");
    }else
    {

        if($email != "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if($password1 != "") {
                if ($password1 == $password2) {
                    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
                    add_user($db, $hashedPassword, $email);
                } else {
                    include_once("Admin/LoginForm.php");
                    echo("Error. Passwords do no match");
                }
            }
            else {
                include_once("Admin/LoginForm.php");
                echo("<br> Password needed.");
            }
        }
        else
        {
            include_once("Admin/LoginForm.php");
            echo("Error. Invalid email entered.");
        }
    }
}


//Called by the passwordTest function, if the passwords match
function add_user($db, $password, $user)
{
    try{
        $stmt = $db->prepare("INSERT INTO users VALUES (null, :email, :password, NOW())");
        $stmt->bindParam(':email', $user);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        include_once("Admin/LoginForm.php");
        echo("User added.");
    }catch(PDOException $e)
    {
        die("<br>Adding a user did not work");
    }
}

//This is the code for the login button.
//It searches the email and password for a given user
function loginTest($db)
{
    $successfulLogin = "";
    $email = $_POST['user_entry'];
    $password = $_POST['password_entry'];

    try {
        $stmt = $db->prepare("SELECT * FROM users");
        $users = array();

        if ($stmt->execute() && $stmt->rowCount() > 0) {

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $user) {
                if ($user['email'] == $email && password_verify($password, $user['password'])) {
                    $successfulLogin = $user['user_id'];
                }
            }
        } else
            echo("No users in list <br>");
        return ($successfulLogin);
    } catch (PDOException $e) {
        die("Grabbing the user list didn't work.");
    }
}