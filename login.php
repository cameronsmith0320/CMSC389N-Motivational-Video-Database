<?php
	//TODO:: See other TODOs in createAccount, session is opened so I could test storing images in the DB
	session_start();
	
    $body = "";
    if (isset($_POST["login"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        
        $host = "localhost";
        $user = "server";
        $dbpassword = "terps";
        $database = "motivationaldb";
        $table = "users";
        
        $db_connection = new mysqli($host, $user, $dbpassword, $database);
        if ($db_connection->connect_error) {
            die($db_connection->connect_error);
        }
        
        $query = "select * from $table where username = '$username' and password = password('$password')";
        
        $result = $db_connection->query($query);
        if (!$result) {
            die("Database access failed: ".$db_connection->error);
        }
        else {
            $num_rows = $result->num_rows;
            if ($num_rows === 0) {
                $body = <<<INVALID
                <div class="alert alert-danger"> <strong>Invalid username-password combination.</strong> Please try again.</div>
                <form action="{$_SERVER["PHP_SELF"]}" method="post">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="username"> Username </label>
                        <div class="col-sm-5">
                            <input class="form-control" id="username" type="text" name="username" value="$username" required /><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="password"> Password </label>
                        <div class="col-sm-5">
                            <input class="form-control" id="password" type="password" name="password" required /><br>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="login"> Login </button>
                    <a href="createAccount.php" class="btn btn-secondary" type="submit" name="createAccount"> Create a new account </a>
                </form>
INVALID;
            }
            else {
				//TODO:: Storing username in session is for testing functionality
				$_SESSION['username'] = $username;
				
                header("Location: myVideos.php");
            }
        }
        $result->close();
        $db_connection->close();
    }
    else {
        $body = <<<FORM
                <form action="{$_SERVER["PHP_SELF"]}" method="post">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="username"> Username </label>
                        <div class="col-sm-5">
                            <input class="form-control" id="username" type="text" name="username" value="$username" required /><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="password"> Password </label>
                        <div class="col-sm-5">
                            <input class="form-control" id="password" type="password" name="password" required /><br>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="login"> Login </button>
                    <a href="createAccount.php" class="btn btn-secondary" type="submit" name="createAccount"> Create a new account </a>
                </form>
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
                <title>Login - Database of Motivational Videos</title>
            </head>
            
            <body>
                <div class="container">
                    <header>
								<form action="index.html" method="post">
									<input type="image" src="DMV-logo.png" alt="Submit Form" />
								</form>
                    </header>
                    <hr>
                    <h4>Login</h4>
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
