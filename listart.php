<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Listing</title>
    <link href=table.css rel="stylesheet" type="text/css">
    <link href=style.css rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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

<body id="artlisting"  >

<div class="heading" >
    <h1 style="position: center"><u>Art Listing</u></h1>
</div>



<script>


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
    $numPerPage = 12;
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
        echo "<div id='light-paginationl' class='table1'>";
        echo "<table id='myTable'  class='table1'>\n";
        echo "<b> </b><thead>";
        echo "<b> <tr class='active-row'>";
        echo "<th><b>Name</b></th>";
        echo "<th><b>Price</b></th>";
        echo "<th><b>Thumbnail</b></th>";
        echo "<th><b>More</b></th>";
        echo "</tr>";

        echo "</thead>";

        $image = "";
        while($row = mysqli_fetch_array($resultData)) {
            echo "<p>";
            echo "<b><tr>\n";
            echo "<td>".$row[0]."</td>\n";
            echo "<td>".$row[4]."</td>\n";
            $id = $row[6];

            echo "<td>"."<img alt=".$row['Description'].". src='data:image/jpeg;base64,".base64_encode($row[7])." >' </td>";
            print '<td> <button id="moreButton" name="moreButton1"  value="'.$row[6].'"   onclick="saveID(' . $row[6] . ')">More</button></td>';
            echo "</tr>";
            echo "</p>";
        }

        echo "</table>\n";
    }

    echo "</div>";  // allows the buttons to be under table lets try style them better pos wise
    ?>
    <div id="underOrderTable" style="background-color: transparent">
    <ul class="pagination">
        <li><a href="listart.php?pageNum=1">First</a></li>
        <li class="<?php if($pageNum <= 1) {echo 'disabled';} ?>">
            <a href="<?php if($pageNum <= 1) {echo '#';} else {echo '?pageNum='.($pageNum-1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageNum >= $totalPages) {echo 'disabled'; } ?>">
            <a href="<?php if($pageNum >= $totalPages) {echo '#'; } else {echo '?pageNum='.($pageNum+1); } ?> ">Next</a>
        </li>
        <li><a href="?pageNum=<?php echo $totalPages; ?>">Last</a></li>
    </ul>
    </div>
    <?php

    mysqli_close($conn);


?>


<form action="details.php" id="artForm" method="POST">

    <input id="orderID" type="hidden" name="val"  onsubmit="saveID(document.getElementById('moreButton1'))">
        <script>

            function saveID(id) {
                let v = document.getElementById("moreButton").value = id;
                document.getElementById('orderID').value = id;
                let form = document.getElementById('artForm');
                form.submit();
                return v;
            }

        </script>



</form>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</body>

</html>