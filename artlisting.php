<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Listing</title>
    <link href=table.css rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!--<script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->

    <!--<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <script> type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script> type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
           $("#table1").DataTable();
        });
    </script> -->
    <!--Navigation bar-->
    <!--<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>-->
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>


    <div id="divNavBar" >


    </div>



    <script>
        $(document).ready(function(){
            $('#divNavBar').load("headerNav.html");
        });
    </script>

    <!--end of Navigation bar-->
</head>
<body id="artlisting">


<script>

   /* function handleClick(evt) {
        let node = evt.target;
        console.log("The function is running");
        console.log("The event to occur is " + evt);
        console.log("event target = " + evt.target);
        console.log((evt.target.id));

    } */

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

    function redirect(url) {
        location.href = url;
    }
</script>

    <!--<script>
        document.getElementById("moreButton").onclick = function () {
            location.href = "details.php";
        };
    </script>-->

<?php
    // Connect to MySQL
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "Aev2Eeceiwef";
    $dbname = $user;
    $conn = new mysqli($host,$user,$pass,$dbname);



    if(isset($_GET['pageNum'])) {
        $pageNum = $_GET['pageNum'];
    }
    else {
        $pageNum = 1;
    }

    // lets try sort a formula of some sort for the pagination
    $numPerPage = 3;
    $offset = ($pageNum-1) * $numPerPage;

    // get the number of total pages
    $totalPagesSQL = "SELECT COUNT(*) FROM `ArtSystem`";
    $result = mysqli_query($conn, $totalPagesSQL);
    $totalRows = mysqli_fetch_array($result)[0];
    $totalPages = ceil($totalRows / $numPerPage);

    //  new sql query for pagination
    $sql = "SELECT * FROM `ArtSystem` LIMIT $offset, $numPerPage";
    $resultData = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM `ArtSystem`";
    $qResult = $conn->query($sql);
    if($qResult->num_rows > 0) {
        echo "<div id='light-paginationl' class='pagination'>";
        echo "<table id='myTable' onclick='handleClick(event)' class='styled-table'>\n";
        echo "<b> </b><thead>";
        echo "<b> <tr class='active-row'>";
        echo "<td><b>Name</b></td>";
        echo "<td><b>Price</b></td>";
        echo "</tr>";

        echo "</thead>";

        while($row = mysqli_fetch_array($resultData)) {
            echo "<p>";
            echo "<b><tr>\n";
            echo "<td>".$row[0]."</td>\n";
            echo "<td>".$row[1]."</td>\n";
            print '<td> <button id="moreButton" name="moreButton" onclick=redirect("details.php")>More </td>';
            echo "</tr>";
            echo "</p>";
        }

        /* while($curRow = $qResult->fetch_assoc()) {
            echo "<p>";
            echo "<b><tr>\n";
            echo "<td>".$curRow['Name']."</td>\n";
            echo "<td>".$curRow['Price']."</td>\n";
            print '<td> <button id="moreButton" name="moreButton" onclick=redirect("details.php")>More </td>';
            echo "</tr>";
            echo "</p>";
        } */
        echo "</table>\n";
        echo "</div>";
    }

    /*while($row = mysqli_fetch_array($resultData)) {
        echo "NAME = ".$row[0];
    } */
    echo "sql = ".$sql;
    ?>

    <ul class="pagination">
        <li><a href="artlisting.php?pageNum=1">First</a></li>
        <li class="<?php if($pageNum <= 1) {echo 'disabled';} ?>">
            <a href="<?php if($pageNum <= 1) {echo '#';} else {echo '?pageNum='.($pageNum-1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageNum >= $totalPages) {echo 'disabled'; } ?>">
            <a href="<?php if($pageNum >= $totalPages) {echo '#'; } else {echo '?pageNum='.($pageNum+1); } ?> ">Next</a>
        </li>
        <li><a href="?pageNum=<?php echo $totalPages; ?>">Last</a></li>
    </ul>

    <?php
    $sql = "SELECT * FROM `ArtSystem`";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        echo "<div id='light-pagination' class='pagination'>";
        echo "<table id='myTable' onclick='handleClick(event)' class='styled-table'>\n";
        echo "<b> </b><thead>";
        echo "<b> <tr class='active-row'>";
        echo "<td><b>Name</td>";
        echo "<td><b>Price</td>";
        echo "<b></tr>";


        echo "<b></thead>";
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<p>";
            echo "<b><tr>\n";
            echo "<td>".$row['Name']."</td>\n";
            echo "<td>".$row['Price']."</td>\n";
            print '<td> <button id="moreButton" name="moreButton" onclick=redirect("details.php") >More </td>';
            //print '<td> <button id="button" name="idButton"<a href="artlisting.php?id=button" onclick="saveID('.$row['ID'].')">More</a>  </td>';
            echo "</tr>\n";
            echo "</p></b>";

        }
    echo "</table>\n";
    echo "</div>";
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