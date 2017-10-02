<?php
$table  = "<table>";
for($rows = 0; $rows < 9; $rows++)
{
    $table .= "\t<tr>";
    $table .= "</tr>\n";
}

$table .= "</table>";
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