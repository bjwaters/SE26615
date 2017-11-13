<?php
/**
 * Created by PhpStorm.
 * User: 001427082
 * Date: 11/6/2017
 * Time: 1:49 PM
 */

//Checks if there is a valid url in the text box
//Text is the input method
//The url is validated here


///Add function
function add_site( $db, $url)
{
    $valid = false;
    $already_input = false;

    //Validation here
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

    if($already_input == true)
    {
        echo("<br> Error. Site already stored. Please input another.");
    }
    //If it is valid and it hasn't been input
    if ($already_input == false && $valid == true) {
        $expression = "/(https?:\/\/[\da-z\.-]+\.[a-z\.]{2,6}[\/\w \.-]+)/";
        $file = file_get_contents("$url");

        //Matches all the links on the given url
        preg_match_all($expression, $file, $matches);
        //Then removes duplicates
        $noDuplicates = array_unique($matches[0]);

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


//Gets a list of the stored websites
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

//Grabbing the data of the selected site from the dropdown list, and its links
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
            $site["date"] = date("m/d/Y");
            $site_table .= "<tr><td>Site: " . $site["site"] . "</td>";
            $site_table .= "<td>Date: " . $site["date"] . "</td></tr>";
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


//Grabbing the links for a given site id
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

//Making a table with the links to a given site
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