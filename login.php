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
                <form action="{$_SERVER["PHP_SELF"]}" method="post">
                    <strong>Username: </strong><input type="text" name="username" value="$username" required /><br>
                    <strong>Password: </strong><input type="password" name="password" required /><br>
                    <h3>Invalid username-password combination. Please try again.</h3><br>
                    <input type="submit" name="login" value="Log In" />
                </form>
                <form action="createAccount.php" method="post">
                    &nbsp;or&nbsp;<input type="submit" name="createAccount" value="Create a new account" />
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
                <strong>Username: </strong><input type="text" name="username" required /><br>
                <strong>Password: </strong><input type="password" name="password" required /><br>
                <input type="submit" name="login" value="Log In" />
            </form>
            <form action="createAccount.php" method="post">
                <input type="submit" name="createAccount" value="Create a new account" />
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
                        <div class="row">
                             <div class="pull-left">
								<form action="index.html" method="post">
									<input type="image" src="DMV-logo.png" alt="Submit Form" />
								</form>
                            </div>
		
		<div class="pull-right">
			<form action="createAccount.php">
				<button class="btn btn-default btn-sm" type="submit" id="logout"> Sign Up </button>
				</form>
		</div>
                        </div>
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
