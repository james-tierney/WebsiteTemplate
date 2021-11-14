<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace</title>
    <link rel="stylesheet" type="text/css" href="form.css">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <div id="divNavBar" >

    </div>

    <script>
        $(document).ready(function(){
            $('#divNavBar').load("headerNav.html");
        });
    </script>
</head>
<body>
<h2><b>Please Book Your Art Viewing Appointment</b></h2>

<?php

    $nameError = "";
    $phoneError = "";
    function safePOSTSQL($conn, $fieldName) {
        if (isset($_POST[$fieldName])) {
            return $conn->real_escape_string(strip_tags($_POST[$fieldName]));
        } else {
            return "";
        }
    }
    $host = "devweb2021.cis.strath.ac.uk";
    $user = "cxb19188";
    $pass = "Aev2Eeceiwef";
    $dbname = $user;
    $conn = new mysqli($host, $user,$pass, $dbname);

    $noErrors = true;
    if( ($_SERVER["REQUEST_METHOD"] === 'POST') && (isset($_POST['traceSubmit'])) )  {
        // check for errors then if there is check if we have tried to post form yet if not then must be initial load of the

        $pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";  // pattern sourced from https://stackoverflow.com/questions/8099177/validating-uk-phone-numbers-in-php/8099255
        if((empty($_POST['visitorName']) || !(preg_match($pattern, $_POST['phoneNum'])) && $noErrors === true ) ) {

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // check for exact error and set error variables
                if(empty($_POST['visitorName'])) {
                    $nameError = "Please Enter A Name";  //SWITCH THE IF AND ELSE ORDER AROUND AND TRY THIS
                    $noErrors = false;
                }
                else if(!(preg_match($pattern, $_POST['phoneNum'])) ) {
                    $phoneError = "Please Enter A Valid UK Phone Number";
                    $noErrors = false;
                }
            }
            ?>
            <div id="trackTraceForm">
                <form action = 'track&trace.php' class='newItems' method='POST'>
                    <div> <input type = 'text' name ='visitorName' value ="<?php if(isset($_POST['visitorName'])) {echo $_POST['visitorName']; } ?>" placeholder="Enter Your Name" required/> </div>
                    <span class="error"> <?php echo $nameError ?></span>
                    <div> <input type='text' name="phoneNum" value="<?php if(isset($_POST['phoneNum'])) {echo $_POST['phoneNum']; } ?>" placeholder="Enter Your Phone Number" required/>
                        <span class="error"> <?php echo $phoneError ?></span>
                    </div>
                    <div> <input type="datetime-local" name="appointment" value="<?php if(isset($_POST['appointment'])) {echo $_POST['appointment']; } ?>" placeholder="Date & Time Of Appointment" required/>

                    </div>



                    <input type='submit' name='traceSubmit'/>


                </form>
            </div>
            <?php
        }
        else {
            // then use an if to run this code underneath if there is no error occured so above we will check the fields of the form for erros and if an error occurs set our boolean
            // and give back the form
            echo "Appointment booked see you there";
            $appointName = safePOSTSQL($conn, "visitorName");
            $appointPhoneNum = safePOSTSQL($conn, "phoneNum");
            $appointTime = safePOSTSQL($conn, "appointment");

            // lets work on inserting into the db again
            $sql = "INSERT INTO `TrackAndTrace` (`Name`, `Phone_number`,`Appointment_time`) VALUES ('$appointName','$appointPhoneNum','$appointTime')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "INSERT WAS SUCCESSFUL APPOINTMENT BOOKED";
            } else {
                "INSERT WAS UNSUCCESSFUL TRY TO BOOK AGAIN PLEASE";
            }
        }
    }
    else {//if($_SERVER['REQUEST_METHOD' === 'POST'] && ()) {


?>

<div id="trackTraceForm">
    <form action = 'track&trace.php' class='newItems' method='POST'>
        <div> <input type = 'text' name ='visitorName' value ="<?php if(isset($_POST['visitorName'])) {echo $_POST['visitorName']; } ?>" placeholder="Enter Your Name" required/> </div>
            <span class="error"> <?php echo $nameError ?></span>
        <div> <input type='text' name="phoneNum" value="<?php if(isset($_POST['phoneNum'])) {echo $_POST['phoneNum']; } ?>" placeholder="Enter Your Phone Number" required/>
            <span class="error"> <?php echo $phoneError ?></span>
        </div>
            <div> <input type="datetime-local" name="appointment" value="<?php if(isset($_POST['appointment'])) {echo $_POST['appointment']; } ?>" placeholder="Date & Time Of Appointment" required/>

        </div>



        <input type='submit' name='traceSubmit'/>


    </form>
</div>

<?php
 }
?>

</body>
</html>