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
        location.assign("orderform.php");
    }

    /*function handleClick(evt) {
        let node = evt.target;
        if(node.name == 'order') {
            node.value = "Modify";
        }
        console.log("HEllo there");
        $('#orderForm').toggle();
    } */
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
            //echo "<td> <button id={index} type='submit' name='order' value='Order'>Order </button> </td>\n";
            echo "<td> <button id='order' type='submit' name='order' value='Order'>Order </button> </td>\n";
            //<p> <input type="submit" name="submitted"/> </p>
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
        //$sql = "INSERT INTO `ArtOrders` (`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('Tom', '2314', 'hw@mail.com', '325 hugh street', 'hello world', '09')";
        // second query seems to inseret correctly??
        //$sql = "INSERT INTO `ArtOrders` (Name, Phone_num, Email, Address, Painting_name, ID) VALUES"
            //."($dbName, $dbPhoneNum, $dbEmail, $dbAddress)"; ////, '$dbPaintingName', '$dbID')";
        //."('$dbWidth', '$dbHeight', '$dbPostage', '$dbEmail', '$priceNoVat', now())";
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


<form  action="artlisting.php" id="orderForm" method="POST">
    <p> Name: <input type = "text" name = "name" value ="Name"/>
    </p>
    <p> Phone Number: <input type = "text" name = "phone_number" value ="Phone_num"/>
    </p>
    <p> Customer Email: <input type="email" name="email" value="Email" />


    <p>Postage Address: <input type="text" name="address" value="Address"
    </p>

    <p>
        <input type="submit" name="submit" value="Submit">
    </p>

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