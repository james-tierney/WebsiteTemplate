<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Frame Price Estimator</title>
</head>
<body>

<?php
    //Connect to MySQL
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "lohqu1PhaeSh";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    //sif (empty($_POST["database"]) || $_POST["database"] != "WannaTellMeHow" ) {

    //}
?>

<form action = "getrequests.php" method="POST">
    <p> <input type = "password" name ="database" value =""/> <input type="submit" name="submit"/>

    </p>
</form>


</body>
</html>