<?php

//Call date method to get current date in dd/mm/yyyy format
$today=date("d/m/Y");
?>

<!DOCTYPE html>
<html>

<head>

    <!-- Import css file which I have created under styles folder -->
    <link rel="stylesheet" type="text/css" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
</head>

<body>


    <div class="jumbotron text-center"
        style="margin-bottom:0; background-image:url('images/Universe.jpg'); border-radius:0%">
        <h1 class="main">Status Posting System</h1>

    </div>

    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand">
            <img src="images/logo.png" alt="Hi Sir!" style="width:60px;">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <!-- &emsp is to add 4 empty white spaces. -->
                <a class="nav-link" href="index.html">&emsp;Home&emsp;</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="poststatusform.php">&emsp;Post a new status&emsp;&emsp;</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="searchstatusform.html">Search status&emsp;&emsp;</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.html">About this assignment</a>
            </li>

        </ul>
    </nav>



    <div class="container" style="margin-top:40px">

        <div class="col-sm-8">

            <!-- Post method for this form -->
            <form method="post" action="poststatusprocess.php" class="poststatusform">

                <!-- Status Code input -->
                <div class="form-group">
                    <label for="statusCode" class="a">1. Status Code:</label>
                    <input type="text" class="form-control" id="statusCode" name="statusCode" placeholder="e.g S1234" required>
                    <br>
                </div>

                <!-- Status input -->
                <div class="form-group">
                    <label for="status" class="a">2. Status:</label>
                    <textarea class="form-control" rows="5" id="status" name="status"
                        placeholder="Only allow letters, white space and !?,." required></textarea>
                    <br>
                </div>




                <!-- Share type input -->
                <label class="a">3. Share:&emsp;</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="public" name="share" value="Public" required>
                    <label class="custom-control-label" for="public">Public</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="friends" value="Friends" name="share">
                    <label class="custom-control-label" for="friends">Friends</label>
                </div>

                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="onlyMe" value="Only Me" name="share">
                    <label class="custom-control-label" for="onlyMe">Only Me</label>
                </div>


                <!-- Date input -->
                <div class="form-group">
                    <br>
                    <label for="date" class="a">4. Date:</label>
                    <input type="text" class="form-control" id="date" name="date" value=<?= $today ?> required>
                    <br>
                </div>


                <!-- Permissions checked input -->
                <label class="a">5. Permissions:</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="allowLike" name="additions[]" value="Allow Like">
                    <label class="custom-control-label" for="allowLike">Allow Like</label>
                </div>

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="allowComment" name="additions[]" value="Allow Comment">
                    <label class="custom-control-label" for="allowComment">Allow Comment</label>
                </div>

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="allowShare" name="additions[]" value="Allow Share">
                    <label class="custom-control-label" for="allowShare">Allow Share</label>
                    <br>
                    <br>
                </div>




                <input class="btn btn-primary" type="submit" name="submit" value="Post" />
                <input class="btn btn-warning" type="reset" name="reset" value="Reset" />

                
                <br>
                <br>
                <a href="index.html">Return to Home Page</a>
            </form>
            <br>
            <br>
        </div>
    </div>



</body>

</html>