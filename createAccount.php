<?php
    $body = "";
    $error_count = 0;
    $errors = "";
    $usernameForm = <<<USER
        Username: <input type="text" name="username" id="username" onblur="validate()" required />&nbsp;&nbsp;<em>Usernames must be no longer than 20 characters.</em><br>
USER;
    $passwordForm = <<<PASS
        Password: <input type="password" id="password" name="password" required /><br>
        Verify Password: <input type="password" name="verifyPassword" id="verifyPassword" onblur="validate()" required /><br>
PASS;
    $emailForm = <<<EMAIL
        Email: <input type="email" id="email" name="email" onblur="validate()" required />&nbsp;&nbsp;<em>Email addresses must be no longer than 30 characters.</em><br>
EMAIL;
    $submitButton = <<<SUBMIT
        <input type="submit" name="create" value="Create Account" />
SUBMIT;
    if (isset($_POST["create"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $verifyPassword = trim($_POST["verifyPassword"]);
        $email = trim($_POST["email"]);
        
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
            $errors .= "<div id=\"usernameErrors\"><strong>Invalid username.</strong><br></div>";
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
                        Username: <input type="text" name="username" id="username" value="$username" onblur="validate()" required />
                        &nbsp;&nbsp;<em>Usernames must be no longer than 20 characters.</em><br>
USER_VALID;
                }
            }
            $result1->close();
        }
        if ($verifyPassword !== $password) {
            $error_count++;
            $errors .= "<div id=\"passwordErrors\"><strong>Passwords do not match.</strong><br></div>";
        }
        else {
            $errors .= "<div id=\"passwordErrors\"></div>";
            $passwordForm = <<<PASS_VALID
                Password: <input type="password" id="password" name="password" value="$password" required /><br>
                Verify Password: <input type="password" name="verifyPassword" id="verifyPassword" value="$verifyPassword" onblur="validate()" required /><br>
PASS_VALID;
        }
        if (strlen($email) > 30) {
            $error_count++;
            $errors .= "<div id=\"emailErrors\"><strong>Invalid email address.</strong><br></div>";
        }
        else {
            $errors .="<div id=\"emailErrors\"></div>";
            $emailForm = <<<EMAIL_VALID
                Email: <input type="email" id="email" name="email" value="$email" onblur="validate()" required />
                &nbsp;&nbsp;<em>Email addresses must be no longer than 30 characters.</em><br>
EMAIL_VALID;
        }
        if ($error_count !== 0) {
            $body = <<<BODY
                $errors
                <form action="{$_SERVER["PHP_SELF"]}" method="post">
                    $usernameForm
                    $passwordForm
                    $emailForm
                    $submitButton
                </form>
BODY;
        }
        else {
            $query2 = "insert into $table values('$username', password('$password'), '$email')";
            
            $result2 = $db_connection->query($query2);
        	if (!$result2) {
        		die("Insertion failed: " . $db_connection->error);
        	}
            else {
        		header("Location: myVideos.html");
        	}
            $result2->close();
            $db_connection->close();
        }
    }
    else {
        $body = <<<FORM
            <div id="usernameErrors"></div>
            <div id="passwordErrors"></div>
            <div id="emailErrors"></div>
            <form action="{$_SERVER["PHP_SELF"]}" method="post">
                $usernameForm
                $passwordForm
                $emailForm
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
                <script src="createAccountValidation.js"></script>
                <title>Create Account - Database of Motivational Videos</title>	
            </head>
            
            <body>
                <div class="container">
                    <header>
                        <div class="row">
                            <div class="col-xs-10">
                                <h3>Database of Motivational Videos</h3>
                            </div>
                        </div>
                    </header>
                    <hr>
                    <h4>Create Account</h4>
                    $body
                    <hr>
                    <footer>
                    </footer>
                </div>
            </body>
        </html>
PAGE;
    echo $page;
?>
