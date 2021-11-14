<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Listing</title>
    <link href=table.css rel="stylesheet" type="text/css">

    <!--<script> type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script> type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#table1").DataTable();
        });
    </script> -->

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
<body style="background-color: cornflowerblue">

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

<!--style the back button to bottom left of the page -->
<button id="backButton" name="back" onclick=redirect("artlisting.php")>Back</button>

<?php
// Connect to MySQL
$host = "devweb2021.cis.strath.ac.uk";
$user = "cxb19188";
$pass = "Aev2Eeceiwef";
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
    echo "<td><b>Thumbnail</td>";
    echo "<td><b>Order Button</td>";
    echo "<b></tr>";


    echo "<b></thead>";
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $image = "";
        if(isset($row['thumbnail'])) {
            $image = "<img src='data:image/jpeg;base64,".base64_encode($row['thumbnail'])."'/>";
        }
        echo "<p>";
        echo "<b><tr>\n";
        echo "<td>".$row['Name']."</td>\n";
        echo "<td>".$row['date_of_completion']."</td>\n";
        echo "<td>".$row['Width']."</td>\n";
        echo "<td>".$row['Height']."</td>\n";
        echo "<td>".$row['Price']."</td>\n";
        echo "<td>".$row['Description']."</td>\n";
        echo "<td>".$row['ID']."</td>\n";
        //echo "<td>".$row['thumbnail']."</td>\n";
        echo "<td>".$image."</td>\n";
        //echo "<img src='data:image/jpeg;base64,".base64_encode($row['thumbnail'])."'/>";
        //echo "<td>".'<img src="data:image/jpeg;base64,'.base64_encode($row['thumbnail']->load()) .'" />'."</td>";
        print '<td> <button id="button" name="idButton"<a href="artlisting.php?id=button" style="border-radius: 8px; background-color: #008CBA; " onclick="saveID(' .$row['ID'].')">Order</a>   </td>';
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




<!--
    when form is clicked the data inserted within the form should be sent to the art orders database
-->

<!--
    Need to add code to insert the order into the database for orders when submit button is clicked
-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>

    // Pagination jquery
   /* $(document).ready(function () {
        $('#table1').DataTable({
            "paging": true
            "pagingType": "simple"
        });
    }) */

    $(document).ready(function () {
        $("#order").click(function () {
            $("#orderForm").toggle();
            console.log("hello this function is running");
        });
    });
</script>
</body>
</html>