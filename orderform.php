<html lang="en">
<head>
    <title>ArtWork System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href=form.css rel="stylesheet" type="text/css">

    <style>
        body {
            background: url(images/mistyForrest.jpg) center center no-repeat  fixed;
            height: 100%;
        }
    </style>

<?php
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "Aev2Eeceiwef";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);
    //session_start();
    $idVal = "";
    $nameErr = "";
    $phoneError = "";
    $emailError = "";
    $addressErr = "";
    $name = "";
    function safePOST($conn, $fieldName)
    {
        if (isset($_POST[$fieldName])) {
            return $conn->real_escape_string(strip_tags($_POST[$fieldName]));
        } else {
            return "";
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['submit'])) {
        $idVal = $_POST['idValue'];
        $name = $conn->query("SELECT Name FROM `ArtSystem` WHERE ID = $idVal")->fetch_object()->Name;
    }

     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $idVal = $_POST['IDValue'];
        $name = $conn->query("SELECT Name FROM `ArtSystem` WHERE ID = $idVal")->fetch_object()->Name;
        $pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";
        $noError = true;
        if (!(preg_match($pattern, $_POST['phone_number']))) {
            $phoneError = "Please Enter A Valid UK Phone Number";

        }
        else if(empty($_POST['name'])) {
            $nameErr = "Please enter a name";
        }
        else if(empty($_POST['address'])) {
            $addressErr = "Please enter an address";
        }
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $emailError= "ERR: Email format invalid";
        }
        else {



            // safely get all values to be inserted into the db
            $dbName = safePOST($conn, "name");
            $dbPhoneNum = safePOST($conn, "phone_number");
            $dbEmail = safePOST($conn, "email");
            $dbAddress = safePOST($conn, "address");
            echo "<p style='color: white; font-size: 5rem;'>Order Placed</p>";



            $sql = "INSERT INTO `ArtOrders` (`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('$dbName', '$dbPhoneNum', '$dbEmail', '$dbAddress', '$name', '$idVal')";

            $result = mysqli_query($conn, $sql);
            if($result) {
                //echo "SUCCESSFUL ";
            }
            else {
                //echo "NOT SUCCESSFUL";
            }
            exit();

        }
    }


?>



<script src="//code.jquery.com/jquery.min.js"></script>




<script>
    $(document).ready(function(){
        $('#divNavBar').load("headerNav.html");
    });
</script>



</head>
<body>

<div id="divNavBar" >

</div>


<script src="validation.js"> // put in file of its own and just call script tag and this function for all the forms

</script>

<div id="orderFormDiv"  class="container">
    <form action="orderform.php" id="orderForm" class="form-container" method="POST">

        <div class="logo"></div>

            <h1 class="orderHeader">Order Form</h1>

        <div>
            <span style="color: white; background: red;" class="error"><?php echo $nameErr;?></span>
            <label for="name">Name</label>
            <input type = "text" id="name" name = "name" value ="<?php if(isset($_POST['name'])) {echo $_POST['name'];}?>" required placeholder="Please enter your name"/>

        </div>

        <div>
            <span style="color:white; background:red;" class="error"><?php echo $phoneError;?></span>
            <label for="phone_number">Phone Number</label>
            <input type = "text" id="phone_number" name = "phone_number"  value ="<?php if(isset($_POST['phone_number'])) {echo $_POST['phone_number'];}?>" required placeholder="Enter a valid Phone Number"/>

        </div>

        <div>
            <span style="color:white; background:red;" class="error"><?php echo $emailError;?></span>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];}?>"  required placeholder="Enter a valid email address"/>


        </div>

        <div>
            <span style="color:white; background:red;" class="error"><?php echo $addressErr; ?></span>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php if(isset($_POST['address'])) {echo $_POST['address'];}?>" required placeholder="Please Enter your address"/>

        </div>

        <div>
            <label for="paintName">Painting Name</label>
            <input type="text" id="paintName" name="paintName" required value="<?php echo $name;?>">
        </div>

        <div>
            <label for="ID">ID</label>
            <input id="ID" type="text" name="IDValue" required value="<?php echo $idVal;?>" >
        </div>

            <p>
                <button  type="submit" name="submit" value="Submit" onsubmit="return checkForm();" >Submit</button> <!--onclick=location.href="index.php"-->
            </p>


    </form>
</div>

</body>
</html>





