<style> <?php include 'styles/style.css'; ?> </style>


<?php



/**database hostname, username, password and databasename. As per the privacy purpose, we are required to leave it blank.
Therefore, currently database connection is off. Please use your credentials and database name to connect. 
I will create a table below under the database you have named by SQL.
Thank you! :) **/

$host     = "";
$user     = "";
$password = "";
$db       = "";



// View Status button has to been pressed to go through following steps.
if (isset($_GET["viewStatus"])) {
    

    
    //Fetch the user input from poststatusform.php
    $status = $_GET["status"];
    
    
    
    //Initialize table name.
    $tableName = "Status";
    
    
    /**Check if the user input for search is empty. If is empty, ask user the add a status. 
    If not empty, go further.*/
    if (empty($status)) {
        
        echo "<p>Please enter keywords for searching</p>";
    }
    
    else {
        
        //Dont want user to see the details of the DB, if connetion failed, just return 'connection failed'.
        $connection = new mysqli($host, $user, $password, $db) or die("<p>Connection failed</p>");
        
        
        
        /**This is aiming to check if 'Status' table exists.
         * If the number of rows is not bigger than 0, means table does not exist, user will be asked to create first status.
         Otherwise, query the database table.**/
        $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
        $checkTable      = mysqli_query($connection, $checkTableQuery);
        $tableExist      = mysqli_num_rows($checkTable);
        
        if (!($tableExist > 0)) {
            
            //If no table was found, means no record. The user needs to post a status first.
            echo "<br>";
            echo "<div class='alert alert-warning'>";
            echo "<strong>No database detected!: </strong>";
            echo "Means you can post your first status!!!!"; 
            echo "<a href='poststatusform.php'>Do it!</a>";
            echo "</div>";
            echo "<br>";
           
        }
        
        //If the table exists.
        else {
            
           
                //Initilize the variable for getting result.
                $result = "";
                
                
                /**Select the record from the database
                "%" is the wildcard in sql server, which represents zero or more characters.*/
                $Query = "SELECT * FROM $tableName WHERE Status Like '%$status%'";
                
                $result = mysqli_query($connection, $Query);
                
                //Return the successful message.
                if ($result) {

                    //Default record must be at least 1.
                    $count=1;

                    //Layout build starts.
                    echo "<div class='container' style='margin-top:40px'>";
                    echo "<div class='col-sm-8'>";

                    //Title
                    echo "<h1>Status search result: </h1>";
                    echo "<br>";
                   

                    while ($row = mysqli_fetch_assoc($result)){

                    
                    echo "<div>";
                    echo "<label class='a'>";
                    echo "Record ".$count.":";
                    echo "</label>";
                    echo "<div>";
                    //table starts
                    echo "<table class='table table-striped'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Attributes</th>";
                    echo "<th>Details</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                   
                        echo "<tr>";
                        echo "<td>Status</td>";
                        echo "<td>".$row['Status']."</td>";

                        echo "<tr>";
                        echo "<td>Status Code</td>";
                        echo "<td>".$row['StatusCode']."</td>";

                        echo "<tr>";
                        echo "<td>Share to</td>";
                        echo "<td>".$row['Share']."</td>";

                        echo "<tr>";
                        echo "<td>Date Posted</td>";
                        echo "<td>$row[Date]</td>";

                        echo "<tr>";
                        echo "<td>Permissions</td>";
                        echo "<td>$row[Additions]</td>";
                        echo "</tbody>";
                        echo "</table>";
                        echo"<br>";
                    //table ends
                    $count +=1;  
                    }

                    //End of the search
                    echo "<div>";
                    echo "<label class='a'>We found ".($count-1)." records based on your key word - '".$status."'";
                    echo"</div>";

                   

                    //If no result found
                    if (mysqli_num_rows($result)==0){
                        echo "<br>";
                        echo "<div class='alert alert-warning'>";
                        echo "<strong>No result found!: </strong>";
                        echo "Try with another keyword please :)";
                        echo "</div>";
                    

                    }

                }
                
                //If some error.
                else {
                    echo "<p>Error</p>";
                }
                
                
            }
            
            //Clean up resultset, free up memory.
            mysqli_free_result($result);
            
            //Close connection
            mysqli_close($connection);
            
        }
    
    
}
//Follow with a link to return to main page or search page.
echo "<a href='searchstatusform.html'>Go back</a>";
echo "<br>";
echo "<a href='index.html'>Return to Home Page</a>";

// end the layout build
echo "</div>";
echo "</div>";



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