<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 10/18/2017
 * Time: 1:48 PM
 */
function addActor($db, $firstname, $lastname, $height, $dob){

    try{
        $sql = $db->prepare("INSERT INTO actors VALUES (null, :firstname, :lastname, :height, :dob)");
        $sql->bindparam(':firstname', $firstname);
        $sql->bindparam(':lastname', $lastname);
        $sql->bindparam(':height', $height);
        $sql->bindparam(':dob', $dob);
        $sql->execute();
        return $sql ->rowCount();
    }catch(PDOException $e)
    {
        die("Adding an actor did not work.");
    }
}

function getActorsAsTable($db){

    try {
        $sql = $db->prepare("SELECT * FROM actors"); //No numeric index on printing
        $sql->execute();
        $actors = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0)
        {
            $table = "<table>" . PHP_EOL;
            foreach ($actors as $actor)
            {
                $table .= "<tr><td>" . $actor['firstname'];
                $table .= "</td><td>" . $actor['lastname'];
                $table .= "</td><td>" . $actor['height'];
                $table .= "</td><td>" . $actor['dob'];
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
        }
        else
        {
            $table = "No actors in the list.";
        }
        return $table;
    } catch (PDOException $e){
        die("There was a problem retrieving the actors.");
    }
}