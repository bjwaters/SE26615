<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/6/2017
 * Time: 1:49 PM
 */

//Add function.
//This validates the user input data as a proper url, and adds it if conditions are met
// Otherwise, an error is returned.
function add_site( $db, $url)
{
    $valid = false;
    $already_input = false;

    //Validation here. Is it a proper url?
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $valid = true;
        echo("$url is a valid URL" . "<br>");
    }

    //If it is valid, search stored inputs for duplicate
    if ($valid == true) {
        try {
            $stmt = $db->prepare("SELECT * FROM sites");
            $sites = array();
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            foreach ($sites as $site) {
                if ($site['site'] == $url) {
                    $already_input = true;
                }
            }
        } catch (PDOException $e) {
            die("Grabbing site list didn't work.");
        }
    }
    else
    {
        echo("<br>Error. Invalid url.");
    }

    //If the entered url is a duplicate of a stored url, give an error.
    if($already_input == true)
    {
        echo("<br> Error. Site already stored. Please input another.");
    }

    //If the url is valid and it hasn't been input before
    if ($already_input == false && $valid == true) {
        $expression = "/(https?:\/\/[\da-z\.-]+\.[a-z\.]{2,6}[\/\w \.-]+)/";
        $file = file_get_contents("$url");

        //Matches all the links on the given url
        preg_match_all($expression, $file, $matches);
        //Then removes duplicates
        $noDuplicates = array_unique($matches[0]);

        //Continue if the url returns a proper array of links. If the site doesn't
        //allow this, it is not entered to the database
        if(count($noDuplicates) > 0) {
            try {
                $sql = "INSERT INTO sites VALUES (null, :site, NOW())";
                $stmt = $db->prepare($sql);
                $stmt->bindparam(':site', $url);

                $stmt->execute();
                $siteid = $db->lastInsertId();

                $stmt = $db->prepare("INSERT INTO sitelinks VALUES(:site_id, :link)");

                foreach ($noDuplicates as $var) {
                    $stmt->bindparam(':site_id', $siteid);
                    $stmt->bindparam(':link', $var);
                    $stmt->execute();
                }
                echo("Success!<br>");
                return $siteid;

            } catch (PDOException $e) {
                die("Adding did not work.");
            }
        }
        else
        {
            echo("No links in array, nothing added.");
        }
    } else {
        echo("<br>Nothing new added.");
    }
}


//Gets a list of the stored websites for the lookup page
function get_sites($db)
{
    try {
        $stmt = $db->prepare("SELECT * FROM sites ORDER BY date");
        $sites = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $sites;
    } catch (PDOException $e) {
        die("Grabbing site list didn't work.");
    }
}

//Grabbing the data of a site given the id of a dropdown option
//This displays the site and the time it was input
function get_site_data($db, $link_list){
    $id = $_POST['siteDrop'];

    try
    {
        $sql ="SELECT site, date FROM sites WHERE site_id=$id";
        $stmt = $db->prepare($sql);
        $stmt->bindparam(':site_id', $id);

        if($stmt->execute() && $stmt -> rowCount() >0)
        {
            $site = $stmt -> fetch(PDO::FETCH_ASSOC);
            $site_table = "<section><table>" . PHP_EOL;
            $site_table .= "<tr><td>Site: " . $site["site"] . "</td>";
            //Properly formatting the date
            $site_table .= "<td>Date: " . date("d-m-Y", strtotime($site['date'])) . "</td></tr>";
            $site_table .= count($link_list) . " links found.";

            $site_table .= "</table></section><br>" . PHP_EOL;
            echo($site_table);
        }
        else
        {
            return "Error here. Empty table.";
        }
    }catch(PDOException $e) {
        die("Getting site data did not wo.");
    }
}


//Grabbing the links for a given site id (from the dropdown) and putting them in an array
function get_links($db, $id)
{

    try
    {
        $sql ="SELECT link FROM sitelinks WHERE site_id=$id";
        $stmt = $db->prepare($sql);
        $stmt->bindparam(':site_id', $id);

        if($stmt->execute() && $stmt -> rowCount() >0)
        {
            $links = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            return $links;
        }
        else
        {
            return "Error here. Empty table.";
        }
    }catch(PDOException $e) {
        die("<br>No new site data or links stored.");
    }
}

//Building a table with the array of links to a given site
function buildTable($link_list)
{
    $table = "<section><table>" . PHP_EOL;
        foreach ($link_list as $var)
        {
            $table .= "<tr><td><a href=" . $var['link'] . " target='popup'> " . $var['link'] . "</a>";
            $table .= "</td></tr>";
        }
        $table .= "</table>" . PHP_EOL;
    $table .= "</section>";
    echo($table);

}