<?php
/*Creating a table start*/
$table = "<table> <tbody>";

/*The loop for the table creation, first rows and then columns*/
for($rows = 0; $rows <=9; $rows++)
{
    $table .= "<tr>";
    for($cols = 0; $cols <= 9; $cols++)
    {
        /*Generating the random numbers*/
        $number = mt_rand(1, 255);
        $number2 = mt_rand(1, 255);
        $number3 = mt_rand(1, 255);
        /*Inserting the random numbers into the styling of the table*/
        $table .= "<td style='background-color:rgb($number, $number2, $number3);'> " . dechex($number) . dechex($number2) . dechex($number3). "<br />";
        $table .= "<span style = 'color: #ffffff;'>" . dechex($number) . dechex($number2) . dechex($number3) . "</span></td>";
    }
    $table .= "</tr>";
}
/*ending the table*/
$table .= "</tbody></table>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<!-- Php goes here -->
<?php echo "$table"; ?>
</body>
</html>