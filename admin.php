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
    <link href="table.css" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <div id="divNavBar" >

    </div>

    <script>
        $(document).ready(function(){
            $('#divNavBar').load("headerNav.html");
        });
    </script>
</head>
<body>

<?php

    //session_start();
    //Connect to MySQL
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "Aev2Eeceiwef";
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

    function safePOSTSQL($conn, $fieldName)
    {
        if (isset($_POST[$fieldName])) {
            return $conn->real_escape_string(strip_tags($_POST[$fieldName]));
        } else {
            return "";
        }
    }

    if(isset($_SESSION['sessionVal'])) {
        $password = $_SESSION['sessionVal'];

        $sessionVal = $_SESSION['sessionVal'];
    }
    else {
        $sessionVal = "";
        $password = safePOSTNotSQL('pass');
    }

    if(empty($password) || $password != $correctPass) {

?>

<form action = "admin.php" class="password" method="POST">
    <p> <input type = "password" name ="pass" value ="" required placeholder="Enter the password"/>
        <input type="submit" name="submit"/>

    </p>
</form>

<?php

    }

    else {

    echo "<div id='adminTable'>";
        $_SESSION['sessionVal'] = $password;

        if ( $_SESSION['sessionVal'] === $correctPass || ($_SERVER['REQUEST_METHOD'] === 'POST') && ($password === $correctPass)) {
            $_SESSION['sessionVal'] = $password;
            $sql = "SELECT * FROM `ArtOrders`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // `Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`
                echo "<table id='adminTable' class='styled-table'>\n";
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
            echo "</table>\n";
            $sql = "SELECT * FROM `TrackAndTrace`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // `Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`
                echo "<table id='trackTable' class='styled-table'>\n";
                echo "<b> </b><thead>";
                echo "<b> <tr class='active-row'>";
                echo "<td><b>Name</td>";
                echo "<td><b>Phone Number</td>";
                echo "<td><b>Appointment Time</td>";
                echo "<b></tr>";


                echo "<b></thead>";
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    echo "<p>";
                    echo "<b><tr>\n";
                    echo "<td>" . $row['Name'] . "</td>\n";
                    echo "<td>" . $row['Phone_number'] . "</td>\n";
                    echo "<td>" . $row['Appointment_time'] . "</td>\n";

                }
            }
            echo "</table>\n";

        }
        $conn = new mysqli($host, $user, $pass, $dbname);

        $paintingName = safePOSTSQL($conn, "paintName");
        $completionDate = safePOSTSQL($conn, "completeDate");
        $pHeight = safePOSTSQL($conn, "paintHeight");
        $pWidth = safePOSTSQL($conn, "paintWidth");
        $pPrice = safePOSTSQL($conn, "paintPrice");
        $pDescription = safePOSTSQL($conn, "description");
        $pID = safePOSTSQL($conn, "paintID");


    if(($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['submitPainting']))) {
        $sql = "INSERT INTO `ArtSystem` (`Name`, `date_of_completion`, `Width`, `Height`, `Price`, `Description`, `ID`) VALUES ('$paintingName','$completionDate','$pHeight','$pWidth','$pPrice','$pDescription', $pID)";

        $result = mysqli_query($conn, $sql);

    }
        ?>
    <div id="adminForm">
       <form action = 'admin.php' class='newItems' method='POST'>
           <div> <input type = 'text' name ='paintName' value ="" placeholder="Painting name"/> </div>
           <div> <input type="date" name="completeDate" value="" placeholder="Date Of Completion"/></div>
           <div> <input type='text' name="paintHeight" value="" placeholder="Height"/></div>
           <div> <input type='text' name="paintWidth" value="" placeholder="Width"/></div>
           <div> <input type="number" name="paintPrice" value="" placeholder="Price"/></div>
           <div> <input type='text' name="description" value="" placeholder="Description"/></div>
           <div> <input type='text' name="paintID" value="" placeholder="Painting ID"/></div>

            <input type='submit' name='submitPainting'/>


        </form>
    </div>


<?php

    }
?>

</body>
</html>