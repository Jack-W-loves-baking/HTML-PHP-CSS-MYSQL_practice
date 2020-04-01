<?php



/**database hostname, username, password and databasename. As per the privacy purpose, we are required to leave it blank.
Therefore, currently database connection is off. Please use your credentials and database name to connect. 
I will create a table below under the database you have named by SQL.
Thank you! :) **/

$host     = "";
$user     = "";
$password = "";
$db       = "";




// Submit button has to been pressed to go through following steps.
if (isset($_POST["submit"])) {
    
    
    
    //Regex for status format, first upper S then follows four digits.
    $statusCodeFormat = "/^([S])[0-9]{4}$/";
    
    //Regex for status format, only allows letter, ?!,. and space.
    
    $statusFormat = "/^[A-Za-z!?., ]*$/";
    
    /**Regex for date format, days - 1.start with 0, then next digit can type from 1-9. 
    2. start without 0, next digit can type from 0-9.
    
    months - 1. start with 0, then next digit can type from 1-9.
    - 2. start without 0, next digit can type from 0-2.
    
    years - four digits, numbers from 0-9 for each.
    
    
    "/" to seperate days, monts, years.
    
    
    **/
    $dataformat = "/([0]?[1-9]|[1|2][0-9]|[3][0|1])\/([0]?[1-9]|[1][0-2])\/([0-9]{4})/";
    
    
    
    //Fetch the user input from poststatusform.php
    $statusCode = $_POST["statusCode"];
    $status     = $_POST["status"];
    $share      = $_POST["share"];
    $date       = $_POST["date"];
    $additions  = $_POST["additions"];
    
    
    //Initialize the trigger, if true then do database connection.
    $correctFormat = true;
    $tableName     = "Status";
    
    
    //If status code does not match up with the format, show error message.
    if (!preg_match($statusCodeFormat, $statusCode)) {
        echo "<br>";
        echo "<div class='alert alert-danger'>";
        echo "<strong>Error: </strong>";
        echo "The status code has to be upper S with four digits. E.g S1234";
        echo "</div>";
        $correctFormat = false;
    }
    
    
    //If status does not match up with the format, show error message.
    if (!preg_match($statusFormat, $status)) {
        
        echo "<br>";
        echo "<div class='alert alert-danger'>";
        echo "<strong>Error: </strong>";
        echo "Status can only allow letters, white space and !?,.";
        echo "</div>";
        $correctFormat = false;
        
    }
    
    //If date does not match up with the format, show error message.
    if (!preg_match($dataformat, $date)) {
        
        echo "<br>";
        echo "<div class='alert alert-danger'>";
        echo "<strong>Error: </strong>";
        echo "date format dd/mm/yyyy";
        echo "</div>";
        $correctFormat = false;
        
    }
    
    //If user has not checked any checkbox, show error message.
    if ((empty($additions))) {
        
        echo "<br>";
        echo "<div class='alert alert-danger'>";
        echo "<strong>Error: </strong>";
        echo "Please at least select one permission type";
        echo "</div>";
        $correctFormat = false;
    }
    
    
    
    //If the input matches up with all the format, go next to database connection.
    if ($correctFormat) {
        
        
        
        //Dont want user to see the details of the DB, if connetion failed, just return 'connection failed'.
        $connection = new mysqli($host, $user, $password, $db) or die("<p>Connection failed, please check hostname, username and password</p>");
        
        
        
        /**This is aiming to check if 'Status' table exists.
         * If the number of rows is not bigger than 0, means table does not exist, and we need to create a 'Status' table.
         Create a table in the database with five columns.**/
        $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
        $checkTable      = mysqli_query($connection, $checkTableQuery);
        $tableExist      = mysqli_num_rows($checkTable);
        
        if (!($tableExist > 0)) {
            
        $createTableQuery = "CREATE TABLE $tableName (
        StatusCode varchar(20),
        Status text,
        Share varchar(30),
        Date varchar(20),
        Additions varchar(40)
        )";
            mysqli_query($connection, $createTableQuery);
        }
        
        
        
        //Check if the status code is unique.
        $checkCodeDuplicateQuery = "SELECT * FROM $tableName WHERE StatusCode = '$statusCode'";
        
        $result  = mysqli_query($connection, $checkCodeDuplicateQuery);
        $numRows = mysqli_num_rows($result);
        
        //If DB returns anything based on the status code we received, then the code is not unique.
        if ($numRows != 0) {

            echo "<br>";
            echo "<div class='alert alert-danger'>";
            echo "<strong>Error: </strong>";
            echo "Please enter a unique status code. '$statusCode' has been used!";
            echo "</div>";

        }
        
        
        //If the code is unique
        else {
            
            
            //Initilize the variable for getting permission type string.
            $permission = "";
            
            
            //Assignment all the value from group check box to $permission, with a ';' to break each element.
            foreach ($additions as $select) {
                $permission .= (String) $select . ". ";
            }
            
            
            //Insert the record into database.
            $insertQuery = "INSERT INTO $tableName (StatusCode, Status, Share, Date, Additions) VALUES ('$statusCode','$status','$share','$date','$permission')";
            
            
            //Return the successful message.
            if (mysqli_query($connection, $insertQuery)) {
                echo "<br>";
                echo "<div class='alert alert-success'>";
                echo "<strong>Congradulations! </strong>";
                echo "Your status has successfully stored in the database! :)";
                echo "</div>";
            }
            
            //Error message
            else {
                echo "<br>";
                echo "<div class='alert alert-danger'>";
                echo "<strong>Error</strong>";
                echo "Unexpected error occurred";
                echo "</div>";
            }
            
            
        }
        
        //Clean up resultset, free up memory.
        mysqli_free_result($result);
        
        //Close connection
        mysqli_close($connection);
        
    }
    
    
    //Follow with a link to return to main page or postStatus page.
    echo "<br>";
    echo "<a href='poststatusform.php'>Go back</a>";
    echo "<br>";
    echo "<a href='index.html'>Return to Home Page</a>";

   
}



?>

<!-- import css codes. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
</head>