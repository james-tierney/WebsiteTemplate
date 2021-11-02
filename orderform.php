<!DOCTYPE html>
<html lang="en">
<head>
    <title>ArtWork System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href=form.css rel="stylesheet" type="text/css">

    <!-- remember add in the jquery part to keep the navbar consistently throughout all pages in the site  -->

</head>
<body>
<?php
    //require("artlisting.php");
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "lohqu1PhaeSh";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);
    session_start();
    $idVal = "";

    function safePOST($conn, $fieldName)
    {
        if (isset($_POST[$fieldName])) {
            return $conn->real_escape_string(strip_tags($_POST[$fieldName]));
        } else {
            return "";
        }
    }

//echo "id = ".$_GET['id'];
    //$idVal = $_POST['button'];
    if( ($_SERVER['REQUEST_METHOD'] === "POST") && (!isset($_POST['submit'])) ) {
        $idVal = $_POST['idValue'];
        echo "id Value is supposed to = " . $idVal;
    }
    else if( ($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['submit'])) ) {
        $idVal = $_POST['IDValue'];
        echo "id Value is supposed to =========== " . $idVal;
        //$sql = "SELECT 'Name' FROM `ArtSystem` WHERE 'Name' = 'The forrest'";//"SELECT * FROM `ArtSystem`"; select name where id = idVal
        //$result = mysqli_query($conn, $sql);
        //$result = $conn->query($sql);
        $name = $conn->query("SELECT Name FROM `ArtSystem` WHERE ID = $idVal")->fetch_object()->Name;
        //echo "Result = ".$result[0];
        //$row = $result->fetch_assoc();
        echo "Name of painting selected to order was " . $name;//$row[0];

        // safely get all values to be inserted into the db
        $dbName = safePOST($conn, "name");
        $dbPhoneNum = safePOST($conn, "phone_number");
        $dbEmail = safePOST($conn, "email");
        $dbAddress = safePOST($conn, "address");
        echo "name = ".$name."<br>";
        echo "id vallllo = ".$idVal."<br>";
        echo "first name = ".$dbName."<br>";
        echo "number = ".$dbPhoneNum."<br>";
        echo "email = ".$dbEmail."<br>";
        echo "address = ".$dbAddress."<br>";
        //$sql = "INSERT INTO `ArtOrders` ('Name', 'Phone_num', 'Email', 'Address', 'Painting_name', 'ID') VALUES"
          //  . "($dbName, $dbPhoneNum, $dbEmail, $dbAddress, $name, $idVal)";

        $sql = "INSERT INTO `ArtOrders` (`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('$dbName', '$dbPhoneNum', '$dbEmail', '$dbAddress', '$name', '$idVal')";

        $result = mysqli_query($conn, $sql);
        echo $result;
        if($result) {
            echo "SUCCESSFUL INSERT";
        }
        else {echo "UNSUCESSFUL INSERT";}

    }
       /* $sql = "SELECT 'Name' FROM `ArtSystem` WHERE 'Name' = 'The forrest'";//"SELECT * FROM `ArtSystem`"; select name where id = idVal
        //$result = mysqli_query($conn, $sql);
        //$result = $conn->query($sql);
        $name = $conn->query("SELECT Name FROM `ArtSystem` WHERE ID = $idVal")->fetch_object()->Name;
        //echo "Result = ".$result[0];
        //$row = $result->fetch_assoc();
        echo "Name of painting selected to order was " . $name;//$row[0];

    // safely get all values to be inserted into the db
        $dbName = safePOST($conn, "name");
        $dbPhoneNum = safePOST($conn, "phone_number");
        $dbEmail = safePOST($conn, "email");
        $dbAddress = safePOST($conn, "address");
        echo "name = ".$name;
        echo "id vallllo = ".$idVal;
            */
    if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['submit']))) {
        echo "in here";
    //$sql = "INSERT INTO `ArtOrders` ('Name', 'Phone_num', 'Email', 'Address', 'Painting_name', 'ID') VALUES"
        //. "($dbName, $dbPhoneNum, $dbEmail, $dbAddress, $name, $idVal)";
    }


//mysqli_close($conn);


// what happens if we set hidden id val then set it = to id val from before and submit that val check if method === post and submit is set then new var for id = POST[IDValue]? and then select the name
?>




<form  action="orderform.php" id="orderForm" method="POST">
    <?php //echo "id val = ".$_POST['idValue'];
    //echo "name still = ".$name;?>
    <div>
        <input type = "text" id="name" name = "name" value ="" required placeholder="Please enter your name"/>
            <label for="name">Name</label>
    </div>

    <div>
          <input type = "text" id="phone_number"name = "phone_number" value ="" placeholder="Enter a valid Phone Number"/>
            <label for="phone_number">Phone Number</label>
    </div>

    <div>
          <input type="email" id="email" name="email" value="" required placeholder="Enter a valid email address"/>
            <label for="email">Email</label>

    </div>

    <div>
        <input type="text" id="address" name="address" value="" placeholder="Please Enter your address"/>
            <label for="address">Address</label>
    </div>

        <input id="ID" type="hidden" name="IDValue" value=<?php echo $idVal;?> >
        <script>
            console.log(document.getElementById('ID').value);
        </script>
        <!--<input id="Name" type="hidden" name="paintName" value=<?php//$name; ?> > -->

        <p>
            <input type="submit" name="submit" value="Submit">
        </p>


</form>

<?php /*if(($_SERVER["REQUEST_METHOD"] === "POST") && (($_POST['submit'] === 'Submit')) ) {
    $id = $_POST['IDValue'];
    $name = $_POST['paintName'];
    echo "ID ---------> = ".$id;
}*/ ?>

<?php   // maybe we do need to take it to the other file and get our values from the form and open the db conn again and then insert from there
    //}
    /*
// we can do what we done if the form failed so that if it is being submitted does this else
    else {
        function safePOST($conn, $fieldName)
        {
            if (isset($_POST[$fieldName])) {
                return $conn->real_escape_string(strip_tags($_POST[$fieldName]));
            } else {
                return "";
            }
        }

        $conn = new mysqli($host, $user, $pass, $dbname);
        // safely get all values to be inserted into the db
        $dbName = safePOST($conn, "name");
        $dbPhoneNum = safePOST($conn, "phone_number");
        $dbEmail = safePOST($conn, "email");
        $dbAddress = safePOST($conn, "address");
        $name = $_POST['paintName'];
        $idVal =  $_POST['IDValue'];
        echo "name = ".$name;
        echo "id vallllo = ".$idVal;

        if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['submit']))) {
            $sql = "INSERT INTO `ArtOrders` ('Name', 'Phone_num', 'Email', 'Address', 'Painting_name', 'ID') VALUES"
                . "($dbName, $dbPhoneNum, $dbEmail, $dbAddress, $name, $idVal)";

            //  $sql = "INSERT INTO `ArtOrders`(`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('$dbName', '$dbPhoneNum', '$dbEmail', '$dbAddress', 'hello world', '00120')";
            echo "form submitted";
            // carries out our query
            $result  = mysqli_query($conn, $sql);
            if($result) {
                echo "SUCCESSFUL INSERT";
            }
            else {echo "UNSUCESSFUL INSERT";}
            // carries out our query


            $sql = "INSERT INTO `wadFraming` (`width`, `height`, `postage`, `email`, `price`, `date_requested`) VALUES"
            ."('$dbWidth', '$dbHeight', '$dbPostage', '$dbEmail', '$priceNoVat', now())";

            // carries out our query
            mysqli_query($conn, $sql);


        }
    } */
?>
</body>
</html>





