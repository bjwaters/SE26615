<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/1/2017
 * Time: 1:35 PM
 */

//Code which puts a list of all the corporation names and links to other functions
function get_Corporations($db){

    try {
        $sql = $db->prepare("SELECT * FROM corps"); //No numeric index on printing
        $sql->execute();
        $corporation = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0)
        {
            $table = "<section><table>" . PHP_EOL;
            foreach ($corporation as $acorp)
            {
                $table .= "<tr><td>" . $acorp['corp'];
                $table .= "</td><td>" . "<a href=index.php?action=read&id=" . $acorp['id'] . ">Read</a>";
                $table .= "</td><td>" . "<a href=index.php?action=update&id=" . $acorp['id'] .">Update</a>";
                $table .= "</td><td>" . "<a href=index.php?action=delete&id=" . $acorp['id'] .">Delete</a>";
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
            $table .= "<a href='index.php?action=new'>Create</a>";
        }
        else
        {
            $table = "No corporations.";
        }
        $table .= "</section>";
        return $table;
    } catch (PDOException $e){
        die("There was a problem retrieving the list.");

    }
}

//Reads a specific entry in the database
function read_corp($db, $id) {

    try
    {
        $sql = $db -> prepare("SELECT * FROM corps WHERE id=$id");

        $binds = array(":id=>$id)");
        if($sql->execute($binds) && $sql -> rowCount() >0)
        {
            $corporation = $sql -> fetch(PDO::FETCH_ASSOC);

            $properDate = $corporation['incorp_dt'];
            $properDate = date("m/d/Y");

            $table = "<table>" . PHP_EOL;
            $table .="<tr>";
            $table .= "<td> <b>Company: </b>" . $corporation['corp'] . "</td>";
            $table .= "<td> <b>Incorporated </b>" . $properDate . "</td>";
            $table .= "<td> <b>Email</b> " . $corporation['email'] . "</td>";
            $table .= "<td> <b>Zip</b> " . $corporation['zipcode'] . "</td>";
            $table .= "<td> <b>Owner</b> " . $corporation['owner'] . "</td>";
            $table .= "<td> <b>Phone</b> " . $corporation['phone'] . "</td>";
            $table .= "<td>" . "<a href=index.php?action=update&id=" . $corporation['id'] . ">Update</a>" . "</td>";
            $table .= "<td>" . "<a href=index.php?action=delete&id=" . $corporation['id'] . ">Delete</a>" . "</td>";
            $table .= "<td>" . "<a href=index.php>View</a>" . "</td>";
            $table .= "</tr></table>";
        }
        else
        {
            $table = "Error here. Empty table.";
        }
        return $table;
    }catch(PDOException $e) {
        die("Getting a record did not work.");
    }
}

//Gives a form for the search criteria
function query_form($cols)
{
    $form = "<section>";
    $form .= "<form method='get' action = ''>";
    $form .= "Sort Column: ";
    $form .= "<select name='orderColumn'>" . PHP_EOL;
    foreach($cols as $col){
        $form .= "<option value='" . $col . "'>" . $col . "</option>" . PHP_EOL;
    }
    $form .= "</select>";
    $form .= "<input type= 'radio' name='Sort_type' value='ASC' checked> Ascending ";
    $form .=  "<input type='radio' name='Sort_type' value='DESC'> Descending ";
    $form .=  "<input type = 'hidden' name='action' value = 'sorting'>";
    $form .= "<input type = 'submit' value = 'Submit Query' />";
    $form .= "<input type = 'submit' name = 'action' value = 'Reset' />";
    $form .= "</form></section>";

    $form .= "<section>";
    $form .= "<form method='get' action = ''>";
    $form .= "Search Column: ";
    $form .= "<select name='textColumn'>" . PHP_EOL;
    foreach($cols as $col){
        $form .= "<option value='" . $col . "'>" . $col . "</option>" . PHP_EOL;
    }
    $form .= "</select>";
    $form .= " Term: <input type='text' name='term' />";
    $form .= "<input type = 'hidden' name='action' value = 'searching'>";
    $form .= "<input type = 'submit' value = 'Submit Query' />";
    $form .= "<input type = 'submit' name = 'action' value = 'Reset' />";
    $form .= "</form></section><br>";
    return $form;
}

//This code is responsible for adding data to the update form
function populate_form($db, $id){

    $sql = $db->prepare("SELECT * FROM corps where id=:id");
    $binds = array(
        ":id" => $id
    );
    if ($sql->execute($binds) && $sql->rowCount() > 0) {
        $results = $sql->fetch(PDO::FETCH_ASSOC);
    }
    if (!isset($id)) {
        die("Record not found.");
    }
    $corp = $results['corp'];
    $email = $results['email'];
    $zipcode = $results['zipcode'];
    $owner = $results['owner'];
    $phone = $results['phone'];
    $incorp_dt = $results['incorp_dt'];
    $id = $results['id'];

    include_once("assets/updateForm.php");

}

//This runs when the submit button with the hidden sorting attribute is clicked
function sort_list($db){

    try {
        $direction = $_GET ['Sort_type'];
        //var_dump($direction);

        $column = $_GET ['orderColumn'];
        //var_dump($column);

        $sql = $db->prepare("SELECT * FROM corps ORDER BY $column $direction"); //No numeric index on printing
        $sql->execute();
        $corporation = $sql->fetchAll(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            $size = $sql ->rowCount();
            $table = "$size rows returned. <br> <br>";
            $table .= "<table>" . PHP_EOL;
            foreach ($corporation as $acorp) {
                $table .= "<tr><td>" . $acorp['corp'];
                $table .= "</td><td>" . "<a href=index.php?action=read&id=" . $acorp['id'] . ">Read</a>";
                $table .= "</td><td>" . "<a href=index.php?action=update&id=" . $acorp['id'] . ">Update</a>";
                $table .= "</td><td>" . "<a href=index.php?action=delete&id=" . $acorp['id'] . ">Delete</a>";
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
            $table .= "<a href='index.php?action=new'>Create</a>";
        } else {
            $table = "No corporations.";
        }
        return $table;
        } catch (PDOException $e) {
            die("There was a problem retrieving the list.");
    }
}

//This runs when the submit button with the hidden searching attribute is clicked
function search_list($db){

    $text = $_GET['term'];
    try {
        $column = $_GET ['textColumn'];
        //var_dump($column);

        $sql = $db->prepare("SELECT * FROM corps WHERE $column LIKE '%$text%'"); //No numeric index on printing
        $sql->execute();
        $corporation = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0)
        {
            $size = $sql ->rowCount();
            $table = "$size rows returned. <br> <br>";
            $table .= "<table>" . PHP_EOL;
            foreach ($corporation as $acorp)
            {
                $table .= "<tr><td>" . $acorp['corp'];
                $table .= "</td><td>" . "<a href=index.php?action=read&id=" . $acorp['id'] . ">Read</a>";
                $table .= "</td><td>" . "<a href=index.php?action=update&id=" . $acorp['id'] .">Update</a>";
                $table .= "</td><td>" . "<a href=index.php?action=delete&id=" . $acorp['id'] .">Delete</a>";
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
            $table .= "<a href='index.php?action=new'>Create</a>";
        }
        else
        {
            $table = "No corporations.";
        }
        return $table;
    } catch (PDOException $e){
        die("There was a problem retrieving the list.");

    }
}
