<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 10/16/2017
 * Time: 12:15 PM
 */
function getDogsAsTable($db){

    $sql = $db->prepare("SELECT * FROM animals"); //No numeric index on printing
    $sql -> execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $results;
    /*if(count($results) ) {
        foreach ($results as $dog) {
            print_r($dog);
        }
    }
    */
}