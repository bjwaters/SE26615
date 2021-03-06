<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 10/16/2017
 * Time: 12:15 PM
 */
function getDogsAsTable($db){

    try {
        $sql = $db->prepare("SELECT * FROM animals"); //No numeric index on printing
        $sql->execute();
        $dogs = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0)
        {
            $table = "<table>" . PHP_EOL;
            foreach ($dogs as $dog)
            {
                $table .= "<tr><td>" . $dog['name'];
                $table .= "</td><td>" . $dog['gender'];
                $table .= "</td><td>" . $dog['fixed'];
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
        }
        else
        {
            $table = "Life is sad. There are no dogs.";
        }
        return $table;
    } catch (PDOException $e){
        die("There was a problem retrieving the dogs.");
    }

    /*if(count($results) ) {
        foreach ($results as $dog) {
            print_r($dog);
        }
    }
    */
}

function getDog($db, $id){
    $sql = $db->prepare("SELECT * FROM animals WHERE id=:id");
    $sql -> bindParem('id', $id, PDO::PARAM_INT);
    $sql->execute();
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function addDog($db, $name, $gender, $fixed){

    try{
        $sql = $db->prepare("INSERT INTO animals VALUES (null, :name, :gender, :fixed)");
        $sql->bindparam(':name', $name);
        $sql->bindparam(':gender', $gender);
        $sql->bindparam(':fixed', $fixed);
        $sql->execute();
        return $sql ->rowCount();
    }catch(PDOException $e)
    {
        die("There was a problem giving birth to the puppy.");
    }
}