<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Listing</title>
    <link href=table.css rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">


    <style>


        .group {
            width: 100%;
            height: 100%;
            justify-content: center;
        }
        .details {
            margin: 1rem;
            padding: 1rem;
            justify-content: center;
            display: flex;

        }
        .box p {
            font-weight: bold;
            font-size: 4rem;
        }

        .images {
            justify-content: center;
            display: flex;
        }
        .images img  {
            width: 66%;
            height: 66%;
            justify-content: center;

            display: flex;
        }
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>


    <script src="//code.jquery.com/jquery.min.js"></script>
    <div id="divNavBar" >

    </div>

    <script>
        $(document).ready(function(){
            $('#divNavBar').load("headerNav.html");
        });
    </script>
</head>
<body style="background: #202020;">

<script>

    function handleClick(evt) {
        let node = evt.target;
        console.log("The function is running");
        console.log("The event to occur is " + evt);
        console.log("event target = " + evt.target);
        console.log((evt.target.id));

    }


    function redirect(url) {
        location.href = url;
    }

    function submitForm(id) {
        document.getElementById('orderForm').submit();
        console.log("form has been submitted");
        console.log("id = " + id);
        return id;
    }


</script>


<div id="backButton">
    <button class=detailsButton name="back" onclick=redirect("listart.php")>Back</button>
</div>
<div id="detailsHeader">
    <h1 >Details About Painting</h1>
</div>
<?php
// Connect to MySQL
$host = "devweb2021.cis.strath.ac.uk";
$user = "cxb19188";
$pass = "Aev2Eeceiwef";
$dbname = $user;
$conn = new mysqli($host,$user,$pass,$dbname);


$idVal = $_POST["val"];

if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['idButton'])) {
    $idVal = $_POST['val'];


$sql = "SELECT * FROM `ArtSystem` WHERE ID = $idVal";
$result = $conn->query($sql);
if($result->num_rows > 0) {


    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $image = "";
        if (isset($row['thumbnail'])) {
            $image = "<img src='data:image/jpeg;base64," . base64_encode($row['thumbnail']) . "'/>";
        }

        echo '<div class="group">';
        echo '<div class="images"> <img alt='.$row["Description"].' src="data:image/jpeg;base64,'.base64_encode($row['thumbnail']).' "/>';
        echo '</div>';
        echo '<div class="details">';
        echo '<button id="button" class=detailsButton name="idButton" value="'.$row['ID'].'"<a href="listart.php?id=button" onclick="saveID(' . $row['ID'] . ')">Order</a>';
        echo '</div>';
        echo '<div class="description">';



            echo '<div  class="box">';
            echo '<p>'."Name - ".$row["Name"]."\n".'</p>';
            echo '<p>'."Price - ".$row['Price']."\n".'</p>';
            echo '<p>'."Width ".$row['Width']." x Height ".$row['Height']."\n".'</p>';
            echo '</div>';

            echo '<div  class="box">';

            echo '<p>'."Description\n".'</p>';
            echo '<p>'.$row['Description']."\n".'</p>';

            echo '</div>';



        echo '</div>';




    }
    echo "</table>\n";
    mysqli_close($conn);
    }
}

$conn = new mysqli($host,$user,$pass,$dbname);

if( ($_SERVER["REQUEST_METHOD"] === "POST") && (isset($_POST['submit'])) ) {
    $dbName = strip_tags(isset($_POST['name']) ? $_POST['name'] : "");
    $dbPhoneNum = strip_tags(isset($_POST['phone_number']) ? $_POST['phone_number'] : "");
    $dbEmail = strip_tags(isset($_POST['email']) ? $_POST['email'] : "");
    $dbAddress = strip_tags(isset($_POST['address']) ? $_POST['address'] : "");

    $sql = "INSERT INTO `ArtOrders`(`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('$dbName', '$dbPhoneNum', '$dbEmail', '$dbAddress', 'hello world', '00120')";

    $result = mysqli_query($conn, $sql);

    // carries out our query

}
?>


<form action="orderform.php" id="orderForm" method="POST">

    <input id="orderID" type="hidden" name="idValue" onsubmit="saveID(document.getElementById('button'))">
    <script>

        function saveID(id) {
            console.log("Id value = " + id);
            let v = document.getElementById("button").value = id;
            console.log("document elements id = " + v);
            document.getElementById('orderID').value = id;
            let form = document.getElementById('orderForm');

            form.submit();
            return v;
        }

    </script>



</form>






<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>



    $(document).ready(function () {
        $("#order").click(function () {
            $("#orderForm").toggle();
            console.log("hello this function is running");
        });
    });
</script>
</body>
</html>