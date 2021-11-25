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
    $nameError = "";
    $phoneError = "";
    $pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";  // pattern sourced from https://stackoverflow.com/questions/8099177/validating-uk-phone-numbers-in-php/8099255
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['traceSubmit'])) {
        $appointName = safePOSTSQL($conn, "visitorName");
        $appointPhoneNum = safePOSTSQL($conn, "phoneNum");
        $appointTime = safePOSTSQL($conn, "appointment");
        $appointTime = date("Y-m-d H:i:s", strtotime($_POST['appointment']));

        if(!(isset($appointName))) {
            $nameError = "Please enter a name";
        }

        if(!preg_match($pattern, $appointPhoneNum)) {
            $phoneError = "Please Enter A Valid UK Phone Number";
        }
        else {

            echo "<p style='color: white; font-size: 5rem;'>Appointment booked see you there</p>";
            // lets work on inserting into the db again
            $sql = "INSERT INTO `TrackAndTrace` (`Name`, `Phone_number`,`Appointment_time`) VALUES ('$appointName','$appointPhoneNum','$appointTime')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                //echo "INSERT WAS SUCCESSFUL APPOINTMENT BOOKED";
            } else {
                //"INSERT WAS UNSUCCESSFUL TRY TO BOOK AGAIN PLEASE";
            }
        }

    }



    function createCalendar() {

        $dates[] = array();

        $curDate = strtotime("now");
        $dates[0] = date("Y-m-d");
        $startDate = strtotime("tomorrow", $curDate);
        $endTime = strtotime("+28 days", $curDate);
        for($i=$startDate; $i<$endTime; $i+=86400) {
            $dates[] = date("Y-m-d", $i);
        }

        $dayCount = 0;
        for($i=0; $i < 4; $i++) {
            echo "<div id=calendar class='calendarRow'> </div>";
            for($j=0; $j < 7; $j++) {
                $dateDay = $dates[$dayCount];
                echo "<button name='bookApp' style='width: 6rem; margin: .3rem;' id='calButton' class='calendarButton'  onclick='getSelected(\"".$dateDay."\")'>$dateDay</button>";
                $dayCount++;
            }
        }
    }

    function bookSlot() {
        // when one of the calendar buttons are clicked this funtion should display a select menu with times 10-1600
        // and then the select menu val will be stored and also put into the sql query that is carried out
    echo '<div class="custom-select" style="width:200px;">';
        echo "<select id='selectMenu' onclick='getSelected()'>";
            echo '<option value="0">Select A Time:</option>';
            echo '<option value="10:00:00" >10:00</option>';
            echo '<option value="11:00:00" >11:00</option>';
            echo '<option value="12:00:00" >12:00</option>';
            echo '<option value="13:00:00" >13:00</option>';
            echo '<option value="14:00:00" >14:00</option>';
            echo '<option value="15:00:00" >15:00</option>';
            echo '<option value="16:00:00" >16:00</option>';
        echo '</select>';
    echo '</div>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace</title>
    <link rel="stylesheet" type="text/css" href="form.css">
    <link rel="stylesheet" type="text/css" href="table.css">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <style>
        .calendarButton {
            color:green;
            padding: 0.5rem;
            width: auto;
            height: auto;
            display: inline-block;

        }

    </style>

    <script>
        function getSelected(date) {
            console.log("date = " + date);
            let select = document.getElementById('selectMenu');
            let val = select.options[select.selectedIndex].value;
            console.log("Value selected = " + val);
            document.getElementById('calButton').value = date;
            let buttonValue = document.getElementById('calButton').value; //date + " ";//document.getElementById('calButton').value;
            buttonValue += " " + val;
            console.log("Button value = " + buttonValue );
            document.getElementById('app').value = buttonValue;
            return buttonValue; // return value so we can set the value of the calendar buttons to this or a variable
            // then we can use that as the value to input into the db
        }
    </script>

    <script src="validation.js"> // put in file of its own and just call script tag and this function for all the forms

    </script>

    <script>
        $(document).ready(function(){
            $('#divNavBar').load("headerNav.html");
        });
    </script>
</head>
<body style="background: #04AA6D">

<div id="divNavBar" >

</div>
<h2 id="trackTraceHeading" style="margin: 6rem;" class="heading"><b>Please Book Your Art Viewing Appointment</b></h2>

<?php
/*
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

*/
?>

<div id="trackTraceForm" class="container">
    <form action = 'track&trace.php' class='form-container' method='POST'>

        <h1 id="appointmentHeader">Appointment Booking</h1>
        <div> <input type = 'text' name ='visitorName' value ="<?php if(isset($_POST['visitorName'])) {echo $_POST['visitorName']; } ?>" placeholder="Enter Your Name" required/> </div>
            <span class="error"> <?php echo $nameError ?></span>
        <div> <input type='text' name="phoneNum" value="<?php if(isset($_POST['phoneNum'])) {echo $_POST['phoneNum']; } ?>" placeholder="Enter Your Phone Number" required/>
            <span class="error"> <?php echo $phoneError ?></span>
        </div>

        <div> <input type="text" id="app" name="appointment" value="<?php if(isset($_POST['bookApp'])) {echo $_POST['bookApp']; } ?>" placeholder="Date & Time Of Appointment" />

        </div>



        <!-- set value of the button originally to be the date from that button and concat that with the
        time we get from the select menu -->
        <button type='submit' name='traceSubmit' onsubmit="checkForm()">Confirm Booking</button>


    </form>
</div>

<?php
echo "<p style='font-size: 3rem; color:white;'>Please Choose a time first then a date!</p>";
createCalendar();
bookSlot();

?>

</body>
</html>