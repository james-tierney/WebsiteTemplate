<?php

    session_start();
    $sessionVal = "";
    //$_SESSION['sessionVal'] = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ArtWork System Admin</title>
    <link href="form.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php

    //session_start();
    //Connect to MySQL
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "lohqu1PhaeSh";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);
    $correctPass = 'caraART21';
    $password = "";

    function safePOSTNotSQL($name) {
        if(isset($_POST[$name])) {
            return strip_tags($_POST[$name]);
        } else {
            return "";
        }
    }

    //$password = $_SESSION['password'];
    //sif (empty($_POST["database"]) || $_POST["database"] != "WannaTellMeHow" ) {
    if(isset($_SESSION['sessionVal'])) {
        $password = $_SESSION['sessionVal'];
        echo $password;
        //echo "session val = ".$sessionVal;
        $sessionVal = $_SESSION['sessionVal'];
        echo "session val = ".$sessionVal;
    }
    else {
        $sessionVal = "";
        $password = safePOSTNotSQL('pass');
        echo "password from post".$password;
    }
    //}

    if(empty($password) || $password != $correctPass) {
        echo "password from post".$password;
        //if(empty($_POST['pass']) || ($_POST['pass'] != $correctPass) ){


?>

<form action = "admin.php" class="password" method="POST">
    <p> <input type = "password" name ="pass" value ="" required placeholder="Enter the password"/>
        <input type="submit" name="submit"/>

    </p>
</form>

<?php
        //echo $_POST['admin'] ;
    }

    else {

        //$password = $_POST['admin'];
        //$password = $_POST['pass'];
        $_SESSION['sessionVal'] = $password;

        if ( $_SESSION['sessionVal'] === $correctPass || ($_SERVER['REQUEST_METHOD'] === 'POST') && ($password === $correctPass)) {
            $_SESSION['sessionVal'] = $password;
            $sql = "SELECT * FROM `ArtOrders`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // `Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`
                echo "<b> </b><thead>";
                echo "<b> <tr class='active-row'>";
                echo "<td><b>Name</td>";
                echo "<td><b>Phone Number</td>";
                echo "<td><b>Email</td>";
                echo "<td><b>Address</td>";
                echo "<td><b>Painting Name</td>";
                echo "<td><b>ID</td>";
                echo "<b></tr>";


                echo "<b></thead>";
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    echo "<p>";
                    echo "<b><tr>\n";
                    echo "<td>" . $row['Name'] . "</td>\n";
                    echo "<td>" . $row['Phone_num'] . "</td>\n";
                    echo "<td>" . $row['Email'] . "</td>\n";
                    echo "<td>" . $row['Address'] . "</td>\n";
                    echo "<td>" . $row['Painting_name'] . "</td>\n";
                    echo "<td>" . $row['ID'] . "</td>\n";
                }
            }
        }
    }
?>

</body>
</html>