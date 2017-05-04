<?php
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
                header("Location: myVideos.html");
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
                &nbsp;or&nbsp;<input type="submit" name="createAccount" value="Create a new account" />
            </form>
FORM;
    }
    
    $page = <<<PAGE
        <!doctype html>
        <html>
            <head> 
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <link rel="stylesheet" href="style.css">
                <title>Login - Database of Motivational Videos</title>	
            </head>
            
            <body>
                <h2>Log In</h2>
                $body
            </body>
        </html>
PAGE;
    echo $page;
?>
