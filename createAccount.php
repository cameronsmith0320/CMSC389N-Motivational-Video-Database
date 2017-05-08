<?php
    //TODO:: See other TODO below, session is opened so that I can test functionality of image in DB
    session_start();
    
    $body = "";
    $error_count = 0;
    $errors = "";
    $usernameForm = <<<USER
        <div class="row form-group">
            <label class="col-sm-1 col-form-label" for="username"> Username </label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="username" id="username" onblur="validate()" required />
                <small id="userHelp" class="form-text text-muted"> Username must be less than 20 characters long </small>
            </div>
        </div>
USER;
    $passwordForm = <<<PASS
        <div class="form-group">
            <div class="row">
                <label class="col-sm-1 col-form-label" for="password"> Password </label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" id="password" name="password" required />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-1 col-form-label" for="verifyPassword"> Confirm Password </label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" onblur="validate()" required />
                </div>
            </div>
        </div>
PASS;

    $emailForm = <<<EMAIL
        <div class="row form-group">
            <label class="col-sm-1 col-form-label" for="email"> Email </label>
            <div class="col-sm-3">
                <input type="email" class="form-control" id="email" name="email" onblur="validate()" required />
            <small id="emailHelp" class="form-text text-muted"> Email must be less than 30 characters long </small>
            </div>
        </div>
EMAIL;
    $imageForm = <<<IMAGE
        <div class="row form-group">
            <label class="col-sm-1 col-form-label" for="profileImage"> Profile Picture: </label>
            <div class="col-sm-3">
                <input type="file" class="form-control-file" id="profileImage" name="profileImage"/>
            </div>
        </div>
IMAGE;
    $submitButton = <<<SUBMIT
        <button type="submit" class="btn btn-primary" name="create"> Create Account </button>
SUBMIT;
    if (isset($_POST["create"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $verifyPassword = trim($_POST["verifyPassword"]);
        $email = trim($_POST["email"]);
        $imageFile = null;
        if($_FILES["profileImage"]["error"] == 0) {
            $imageFile=addslashes (file_get_contents($_FILES['profileImage']['tmp_name']));
        }
        
        $host = "localhost";
        $user = "server";
        $dbpassword = "terps";
        $database = "motivationaldb"; // max lengths in form to be updated with actual max lengths from database, if needed
        $table = "users";
        
        $db_connection = new mysqli($host, $user, $dbpassword, $database);
        if ($db_connection->connect_error) {
            die($db_connection->connect_error);
        }
        
        if (strlen($username) > 20) {
            $error_count++;
            $errors .= '<div class="alert alert-danger" id="usernameErrors">Invalid username.</div>';
        }
        else {
            $query1 = "select * from $table where username = '$username'";
        
            $result1 = $db_connection->query($query1);
            if (!$result1) {
                die("Database access failed: ".$db_connection->error);
            }
            else {
                $num_rows = $result1->num_rows;
                if ($num_rows !== 0) {
                    $error_count++;
                    $errors .= "<div id=\"usernameErrors\"><strong>Username taken.</strong><br></div>";
                }
                else {
                    $errors .= "<div id=\"usernameErrors\"></div>";
                    $usernameForm = <<<USER_VALID
                        <div class="row form-group">
                            <label class="col-sm-1 col-form-label" for="username"> Username </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="username" value="$username" id="username" onblur="validate()" required />
                            </div>
                            <small id="userHelp" class="form-text text-muted"> Username must be less than 20 characters long </small>
                        </div>
USER_VALID;
                }
            }
            $result1->close();
        }
        if ($verifyPassword !== $password) {
            $error_count++;
            $errors .= '<div class="alert alert-danger" id="passwordErrors">Passwords do not match.</div>';
        }
        else {
            $errors .= "<div id=\"passwordErrors\"></div>";
            $passwordForm = <<<PASS_VALID
                <div class="row form-group">
                    <label class="col-sm-1 col-form-label" for="password"> Password </label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" value="$password" id="password" name="password" required />
                    </div>
                </div>
				
				<div class="row form-group">
				<label class="col-sm-1" for="verifyPassword"> Verify Password </label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" value="$verifyPassword" name="verifyPassword" id="verifyPassword" onblur="validate()" required />
                </div>
				</div>
PASS_VALID;
        }
        if (strlen($email) > 30) {
            $error_count++;
            $errors .= '<div class="alert alert-danger" id="emailErrors">Invalid email address.</div>';
        }
        else {
            $errors .="<div id=\"emailErrors\"></div>";
            $emailForm = <<<EMAIL_VALID
                <div class="row form-group">
                    <label class="col-sm-1 col-form-label" for="email"> Email </label>
                    <div class="col-sm-3">
                        <input type="email" class="form-control" value="$email" id="email" name="email" onblur="validate()" required />
						<small id="emailHelp" class="form-text text-muted"> Email must be less than 30 characters long </small>
                    </div>
                    
                </div>
EMAIL_VALID;
        }
        if ($error_count !== 0) {
            $body = <<<BODY
                <form action="{$_SERVER["PHP_SELF"]}" method="post" enctype="multipart/form-data">
                    $usernameForm
                    $passwordForm
                    $emailForm
                    $imageForm
                    $submitButton
                </form>
BODY;
        }
        else {
            if($imageFile != null) {
                $query2 = "insert into $table values('$username', password('$password'), '$email', '$imageFile')";
            } else {
                $query2 = "insert into $table (username, password, email) values('$username', password('$password'), '$email')";
            }
            
            
            $result2 = $db_connection->query($query2);
            if (!$result2) {
                die("Insertion failed: " . $db_connection->error);
            }
            else {
                //TODO:: Storing the username in session was something I added just so I could test functionality
                $_SESSION['username'] = $username;
                
                header("Location: myVideos.php");
            }
            $result2->close();
            $db_connection->close();
        }
    }
    else {
	    $errors.= <<<ERROR
                <div class="" id="usernameErrors"></div>
                <div class="" id="passwordErrors"></div>
                <div class="" id="emailErrors"></div>
ERROR;
        $body = <<<FORM
            <form action="{$_SERVER["PHP_SELF"]}" method="post" enctype="multipart/form-data">
                $usernameForm
                $passwordForm
                $emailForm
                $imageForm
                $submitButton
            <form>
FORM;
    }
    $page = <<<PAGE
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
            <head> 
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                <link rel="stylesheet" href="main.css">
        <script src="createAccountValidation.js"></script>
                <title>Create Account - Database of Motivational Videos</title> 
            </head>
            
            <body>
                <div class="container">
                    <header>
         <div class="container">
                <div class="row">
                            <div class="pull-left">
                                <form action="index.html" method="post">
                                    <input type="image" src="DMV-logo.png" alt="Submit Form" />
                                </form>
                            </div>
<!--
                            <div class="pull-right">
                                <form action="login.php">
                                    <button class="btn btn-default btn-sm" type="submit" id="login"> Login </button>
                                </form>
                            </div>
-->
                        </div>
                        <div>
            </header>
                    <hr>
                       $errors
                    <h4>Create Account</h4>
                    $body
                    <hr>
                    <footer>
                &copy;2017 Database of Motivational Videos
                    </footer>
                </div>
            </body>
        </html>
PAGE;
    echo $page;
?>
