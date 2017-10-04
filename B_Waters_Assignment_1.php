<?php
$table = "<table> <tbody>";
for($rows = 0; $rows <=9; $rows++)
{
    $table .= "<tr>";
    for($cols = 0; $cols <= 9; $cols++)
    {
        $table .= "<td>" . $rows * $cols . "</td>";
    }
    $table .= "</tr>";
}

$table += "</tbody></table>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php echo "$table"; ?>
</body>
</html>