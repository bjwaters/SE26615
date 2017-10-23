<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 10/23/2017
 * Time: 11:57 AM
 */
function getCorportations($db){

    try {
        $sql = $db->prepare("SELECT * FROM corps"); //No numeric index on printing
        $sql->execute();
        $corporation = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0)
        {
            //If there is something in the table
            $table = "<table>" . PHP_EOL;
            foreach ($corporation as $acorp)
            {
                $table .= "<tr><td>" . $acorp['corp'];
                $table .= "</td><td>" . $acorp['incorp_dt'];
                $table .= "</td><td>" . $acorp['email'];
                $table .= "</td><td>" . $acorp['zipcode'];
                $table .= "</td><td>" . $acorp['owner'];
                $table .= "</td><td>" . $acorp['phone'];
                $table .= "</td><td>" . "<a href='Read.php' id='$acorp[id]'>Read</a> | <a href='Update.php' id='$acorp[id]'>Update</a> | <a href='Delete.php' id='$acorp[id]'>Delete</a></nav></header>";
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
        }
        else
        {
            //If the table is empty
            $table = "No corporations.";
        }
        return $table;
    } catch (PDOException $e){
        die("There was a problem retrieving the actors.");
    }
}