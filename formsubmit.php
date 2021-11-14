

<?php
    echo "form was submitted successfully";
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "Aev2Eeceiwef";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    $nameVal = $_POST['paintName'];
    $id =  $_POST['IDValue'];
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
    //$name = $_POST['paintName'];
    //$idVal =  $_POST['IDValue'];
echo "id vallllo = ".$id;
    echo "name = ".$nameVal;


    //if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_POST['submit']))) {
        $sql = "INSERT INTO `ArtOrders` ('Name', 'Phone_num', 'Email', 'Address', 'Painting_name', 'ID') VALUES"
            . "($dbName, $dbPhoneNum, $dbEmail, $dbAddress, $nameVal, $id)";

        //  $sql = "INSERT INTO `ArtOrders`(`Name`, `Phone_num`, `Email`, `Address`, `Painting_name`, `ID`) VALUES ('$dbName', '$dbPhoneNum', '$dbEmail', '$dbAddress', 'hello world', '00120')";
        echo "form submitted";
        // carries out our query
        $result  = mysqli_query($conn, $sql);
        if($result) {
            echo "SUCCESSFUL INSERT";
        }
        else {echo "UNSUCESSFUL INSERT";}
        // carries out our query


        //$sql = "INSERT INTO `wadFraming` (`width`, `height`, `postage`, `email`, `price`, `date_requested`) VALUES"
          //  ."('$dbWidth', '$dbHeight', '$dbPostage', '$dbEmail', '$priceNoVat', now())";

        // carries out our query
        mysqli_query($conn, $sql);
?>


