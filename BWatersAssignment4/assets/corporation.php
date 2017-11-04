<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/1/2017
 * Time: 1:43 PM
 */


//Grabbing the unsorted information from the database
function getCorpInfo($db) {
    try {
        $sql = "SELECT `corps`.`corp`, `corps`.`email`, `corps`.`id`, `corps`.`incorp_dt`, `corps`.`owner`, `corps`.`phone`,
        `corps`.`zipcode` FROM `corps`";

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $corporation = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("There was a problem getting the table of employees");
    }
    //var_dump( $corporation);
    return $corporation;
}

//Adding a corporation to the database
function add_corp($db, $corp, $email, $owner, $phone, $zipcode ){

    try{
        $sql = $db->prepare("INSERT INTO corps VALUES (null, :corp, NOW(), :email, :zipcode, :owner, :phone)");
        $sql->bindparam(':corp', $corp);
        $sql->bindparam(':email', $email);
        $sql->bindparam(':zipcode', $zipcode);
        $sql->bindparam(':owner', $owner);
        $sql->bindparam(':phone', $phone);
        $sql->execute();
        return $sql ->rowCount();
    }catch(PDOException $e)
    {
        die("Adding did not work.");
    }
}

//Deleting an entry from the database
function delete_corp($db, $id) {

    try {
        $sql = $db->prepare("DELETE FROM corps WHERE id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        return $id;
    }catch(PDOException $e)
    {
        die("Deleting did not work.");
    }
}

//Updating an entry in the database
function update_record($db, $id,  $corp, $incorp_dt,  $email, $owner, $phone, $zipcode){

    try{
        $sql = $db->prepare("UPDATE corps SET corp=:corp, incorp_dt=:incorp_dt, email=:email, owner=:owner, phone=:phone, zipcode=:zipcode WHERE id=:id");
        $sql->bindparam(':corp', $corp);
        $sql->bindparam(':incorp_dt', $incorp_dt);
        $sql->bindparam(':email', $email);
        $sql->bindparam(':owner', $owner);
        $sql->bindparam(':phone', $phone);
        $sql->bindparam(':zipcode', $zipcode);
        $sql->bindparam('id', $id);
        $sql->execute();
        return $sql ->rowCount();
    }catch(PDOException $e)
    {
        die("Updating did not work.");
    }

}
