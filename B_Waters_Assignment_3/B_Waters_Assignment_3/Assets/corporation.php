<?php
/**
 *Intro on index page
 */

//The code for adding a record to the database
//Called from the create.php page
function addRecord($db, $corp, $email, $owner, $phone, $zipcode){

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


//The code for grabbing a single record
function get_record($db, $id) {

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
            $table .= "<td>" . "<a href=Update.php?action=Update&id=" . $corporation['id'] . ">Update</a>" . "</td>";
            $table .= "<td>" . "<a href=Delete.php?action=Delete&id=" . $corporation['id'] . ">Delete</a>" . "</td>";
            $table .= "<td>" . "<a href=index.php?action=View>View</a>" . "</td>";
            $table .= "</tr></table>";
        }
        else
        {
            $table = "Error here. Empty table.";
        }
        return $table;
    }catch(PDOException $e)
    {
        die("Getting a record did not work.");
    }


}

//This code deletes a specific record from the database
function delete_record($db, $id) {

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

//Called at the index page. It gives a full list of all companies and links
//to further pages
function getCorportations($db){

    try {
        $sql = $db->prepare("SELECT * FROM corps"); //No numeric index on printing
        $sql->execute();
        $corporation = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0)
        {
            $table = "<table>" . PHP_EOL;
            foreach ($corporation as $acorp)
            {
                $table .= "<tr><td>" . $acorp['corp'];
                $table .= "</td><td>" . "<a href=Read.php?action=Read&id=" . $acorp['id'] . ">Read</a>";
                $table .= "</td><td>" . "<a href=Update.php?action=Update&id=" . $acorp['id'] .">Update</a>";
                $table .= "</td><td>" . "<a href=Delete.php?action=Delete&id=" . $acorp['id'] .">Delete</a>";
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
            $table .= "<a href='Create.php'>Create</a>";
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

//This code is responsible for updating a given record
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
            die("Adding did not work.");
        }
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