<?php

    session_start();
    $sessionVal = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ArtWork System Admin</title>
    <link href="form.css" rel="stylesheet" type="text/css">
    <link href="table.css" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <div id="divNavBar" >

    </div>

    <script>
        $(document).ready(function(){
            $('#divNavBar').load("headerNav.html");
        });
    </script>

    <script src="validation.js"> // put in file of its own and just call script tag and this function for all the forms

    </script>
    <style>

        #adminTable {
            width: 85%;

        }
        #topSection, #bottomSection {
            border-bottom: .3rem solid #04AA6D;
            background: transparent;
        }
        #adminForm {
            width:85%;
        }
        #formSection {
            border-bottom: .3rem solid #04AA6D;
            background: transparent;
            width: 85%;
        }

        body {
            background: #202020;
        }



        section {
            width: 85%;
            background: white;
            margin: 0 auto;
            border-bottom: .3rem solid deeppink;
        }
    </style>

</head>
<body>


<?php

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

<form action = "admin.php" class="password"  method="POST">
    <p> <input type = "password" name ="pass" value ="" required placeholder="Enter the password"/>
        <input type="submit" name="submit" style="background: #0d9951;" onsubmit="checkForm()"/>

    </p>
</form>

<?php

    }

    else {


        $_SESSION['sessionVal'] = $password;

        if ( $_SESSION['sessionVal'] === $correctPass || ($_SERVER['REQUEST_METHOD'] === 'POST') && ($password === $correctPass)) {
            $_SESSION['sessionVal'] = $password;
            $sql = "SELECT * FROM `ArtOrders`";
            $result = $conn->query($sql);
            echo "<div id='adminTable'>";
            echo "<section id='topSection' >";

            if ($result->num_rows > 0) {


                echo "<div class=adminTable>";
                echo "<table id='adTable'  class='table1'>\n";
                echo "<b> </b><thead>";
                echo "<b> <tr class='active-row'>";
                echo "<th><b>Name</th>";
                echo "<th><b>Phone Number</th>";
                echo "<th><b>Email</th>";
                echo "<th><b>Address</th>";
                echo "<th><b>Painting Name</th>";
                echo "<th><b>ID</th>";
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

                    echo "</p>";
                }
            }
            echo "</table>\n";
            echo "</div>";
            echo "<button id=tab1Button onclick=tableDisplay('adTable') >Show/Hide Orders</button>";
            echo "</section>";




            echo "<section id=bottomSection >";

            $sql = "SELECT * FROM `TrackAndTrace`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {

                echo "<div class=adminTable>";
                echo "<table id='myTable' class='table1'>\n";
                echo "<b> </b><thead>";
                echo "<b> <tr class='active-row'>";
                echo "<th><b>Name</th>";
                echo "<th><b>Phone Number</th>";
                echo "<th><b>Appointment Time</th>";
                echo "<b></tr>";


                echo "<b></thead>";
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    echo "<p>";
                    echo "<b><tr>\n";
                    echo "<td>" . $row['Name'] . "</td>\n";
                    echo "<td>" . $row['Phone_number'] . "</td>\n";
                    echo "<td>" . $row['Appointment_time'] . "</td>\n";
                    echo "</tr>";

                }
            }

            echo "</table>\n";
            echo "</div>";
            echo "<button id=tab2Button onclick=tableDisplay('myTable')> Show/Hide Appointments</button>";
            echo "</section>";
            echo "</div>";


        }

        $conn = new mysqli($host, $user, $pass, $dbname);

        $paintingName = safePOSTSQL($conn, "paintName");
        $completionDate = safePOSTSQL($conn, "completeDate");
        $pHeight = safePOSTSQL($conn, "paintHeight");
        $pWidth = safePOSTSQL($conn, "paintWidth");
        $pPrice = safePOSTSQL($conn, "paintPrice");
        $pDescription = safePOSTSQL($conn, "description");
        $pID = safePOSTSQL($conn, "paintID");
        $pImage = safePOSTSQL($conn, "image");

        $nameErr = "";
        $dateErr = "";
        $heightErr = "";
        $widthErr = "";
        $priceErr = "";
        $descriptionErr = "";
        $IDErr = "";



    if(($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['submitPainting']))) {


        if(empty($_POST['paintName']) || empty($_POST['completeDate']) || empty($_POST['paintHeight']) || ($_POST['paintHeight']) <= 0 || ($_POST['paintWidth']) <= 0 || empty($_POST['paintWidth']) || empty($_POST['paintPrice']) || empty($_POST['description']) || empty($_POST['paintID']) || $_POST['paintPrice'] < 0 || $_POST['paintID'] < 0) {

            if(empty($_POST['paintName'])) {
                $nameErr = "Please enter a name for the painting";
            }
            else if(empty($_POST['completeDate'])) {
                $dateErr = "Please enter the date of completion";
            }
            else if(empty($_POST['paintHeight'])) {
                $heightErr = "Please enter a valid height";
            }
            else if(empty($_POST['paintWidth'])) {
                $widthErr = "Please enter a valid width";
            }
            else if(empty($_POST['paintPrice'])) {
                $priceErr = "Please enter a price";
            }
            else if(empty($_POST['description'])) {
                $descriptionErr = "Please enter a description";
            }
            else if(empty($_POST['paintID'])) {
                $IDErr = "Please enter an ID ";
            }
            else if($_POST['paintHeight'] <= 0) {
                $heightErr = "Enter a height greater than 0";
            }
            else if($_POST['paintWidth'] <= 0) {
                $widthErr = "Enter a width greater than 0";
            }
            else if($_POST['paintPrice'] < 0) {
                $priceErr = "Please enter a non-negaitve price";
            }
            else if($_POST['paintID'] < 0) {
                $IDErr = "Enter a non-negative ID ";
            }

        } else {
            $tmpImage = $_FILES['image']['tmp_name'];

            $query = "INSERT INTO `ArtSystem` (`Name`, `date_of_completion`, `Width`, `Height`, `Price`, `Description`, `ID`, `thumbnail`) VALUES ('$paintingName','$completionDate','$pHeight','$pWidth','$pPrice','$pDescription', '$pID', '$tmpImage')";

            $res = mysqli_query($conn, $query);
            if ($res) {
                echo "<p style='color: white;'>INSERT DONE</p>";
            } else {
                echo "<p style='color: white;'>INSERT FAILED</p>";
            }

        }
    }
        ?>

    <div id="adminForm">
        <section id="formSection">
       <form action = 'admin.php' enctype="multipart/form-data" class='newItems' method='POST'>
           <div> <input type = 'text' name ='paintName' value ="<?php if(isset($_POST['paintName'])) {echo $_POST['paintName'];}?>" placeholder="Painting name"/>
               <span class="error"><?php echo $nameErr;?></span>
           </div>
           <div> <input type="date" name="completeDate" value="<?php if(isset($_POST['completeDate'])) {echo $_POST['completeDate'];}?>" placeholder="Date Of Completion"/>
               <span class="error"><?php echo $dateErr;?></span>
           </div>
           <div> <input type='text' name="paintHeight" value="<?php if(isset($_POST['paintHeight'])) {echo $_POST['paintHeight'];}?>" placeholder="Height"/>
               <span class="error"><?php echo $heightErr;?></span>
           </div>
           <div> <input type='text' name="paintWidth" value="<?php if(isset($_POST['paintWidth'])) {echo $_POST['paintWidth'];}?>" placeholder="Width"/>
               <span class="error"><?php echo $widthErr;?></span>
           </div>
           <div> <input type="text" name="paintPrice" value="<?php if(isset($_POST['paintPrice'])) {echo $_POST['paintPrice'];}?>" placeholder="Price"/>
               <span class="error"><?php echo $priceErr;?></span>
           </div>
           <div> <input type='text' name="description" value="<?php if(isset($_POST['description'])) {echo $_POST['description'];}?>" placeholder="Description"/>
               <span class="error"><?php echo $descriptionErr;?></span>
           </div>
           <div> <input type='text' name="paintID" value="<?php if(isset($_POST['paintID'])) {echo $_POST['paintID'];}?>" placeholder="Painting ID"/>
               <span class="error"><?php echo $IDErr;?></span>
           </div>
           <div> <input type="file" name="image" value=""/>
               <label style="color:white;" for="image">No Files Greater than 64KB </label>

           </div>

           <button type='submit' style="margin-bottom: 1rem; box-shadow: none; background: #0d9951;" name='submitPainting' value="Submit" onsubmit="checkForm()">Add</button>


        </form>
        </section>
    </div>



    <script>
        // ensure reload of pages takes user back to top
        window.onbeforeunload = function () {
        window.scrollTo(0,0);
        }
    </script>

    <script src="validation.js">

    </script>

    <script>



        function tableDisplay(elementId) { // get the id if a button is clicked then change display status of the element ie the tables in this case
            let table = document.getElementById(elementId);
            if(table.style.display === "none") {
                table.style.display = "block";
            }
            else {
                table.style.display = "none";
            }
        }

    </script>

<?php

    }
?>

</body>
</html>