<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Listing</title>
    <link href=table.css rel="stylesheet" type="text/css">
</head>
<body>

<script>

    function handleClick(evt) {
        let node = evt.target;
        console.log("The function is running");
        console.log("The event to occur is " + evt);
        console.log("event target = " + evt.target);
        console.log((evt.target.id));

    }

    function setVal() {
        return document.getElementById('orderID').value = myFunc();

    }

    function myFunc(flag, buttonID) {

        //let id = buttonID.getAttribute('data-id');
        let id = document.getElementById("myButton").value;
        console.log("The value of the id from the doc.getId = " + id);
        if(flag === true) {
        }
        return id;
    }

    function rowID() {

    }

    function submitForm(id) {
        document.getElementById('orderForm').submit();
        console.log("form has been submitted");
        console.log("id = " + id);
        return id;
    }
</script>


<?php
    // Connect to MySQL
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "lohqu1PhaeSh";
    $dbname = $user;
    $conn = new mysqli($host,$user,$pass,$dbname);


    $sql = "SELECT * FROM `ArtSystem`";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        echo "<table id='table1' onclick='handleClick(event)' class='styled-table'>\n";
        echo "<b> </b><thead>";
        echo "<b> <tr class='active-row'>";
        echo "<td><b>Name</td>";
        echo "<td><b>Completion Date</td>";
        echo "<td><b>Width</td>";
        echo "<td><b>Height</td>";
        echo "<td><b>Price</td>";
        echo "<td><b>Description</td>";
        echo "<td><b>ID</td>";
        echo "<b></tr>";


        echo "<b></thead>";
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<p>";
            echo "<b><tr>\n";
            echo "<td>".$row['Name']."</td>\n";
            echo "<td>".$row['date_of_completion']."</td>\n";
            echo "<td>".$row['Width']."</td>\n";
            echo "<td>".$row['Height']."</td>\n";
            echo "<td>".$row['Price']."</td>\n";
            echo "<td>".$row['Description']."</td>\n";
            echo "<td>".$row['ID']."</td>\n";
            print '<td> <button id="button" name="idButton"<a href="artlisting.php?id=button" onclick="saveID('.$row['ID'].')">Order</a>  </td>';
            echo "</tr>\n";
            echo "</p></b>";

        }
    echo "</table>\n";
    mysqli_close($conn);
    }

    $conn = new mysqli($host,$user,$pass,$dbname);

    if( ($_SERVER["REQUEST_METHOD"] === "POST") && (isset($_POST['submit'])) ) {
        $dbName = strip_tags(isset($_POST['name']) ? $_POST['name'] : "");
        $dbPhoneNum = strip_tags(isset($_POST['phone_number']) ? $_POST['phone_number'] : "");
        $dbEmail = strip_tags(isset($_POST['email']) ? $_POST['email'] : "");
        $dbAddress = strip_tags(isset($_POST['address']) ? $_POST['address'] : "");

        echo "this post has went through";
        echo isset($_POST['submit']);

        $sql = "INSERT INTO `ArtOrders`(`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('$dbName', '$dbPhoneNum', '$dbEmail', '$dbAddress', 'hello world', '00120')";
        echo "sql = ".$sql;

        $result = mysqli_query($conn, $sql);
        echo $result;
        if($result) {
            echo "SUCCESSFUL INSERT";
        }
        else {echo "UNSUCESSFUL INSERT";}
        // carries out our query

    }
?>


<form  action="orderform.php" id="orderForm" method="POST">

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




<!--
    when form is clicked the data inserted within the form should be sent to the art orders database
-->

<!--
    Need to add code to insert the order into the database for orders when submit button is clicked
-->

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