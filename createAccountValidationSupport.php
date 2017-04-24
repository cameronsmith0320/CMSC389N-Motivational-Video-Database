<?php
    $username = trim($_GET["username"]);
    $password = trim($_GET["password"]);
    $verifyPassword = trim($_GET["verifyPassword"]);
    $email = trim($_GET["email"]);
    
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
        echo "<strong>Invalid username.</strong><br>|";
    }
    else {
        $query = "select * from $table where username = '$username'";
    
        $result = $db_connection->query($query);
        if (!$result) {
            die("Database access failed: ".$db_connection->error);
        }
        else {
            $num_rows = $result->num_rows;
            if ($num_rows !== 0) {
                echo "<strong>Username taken.</strong><br>|";
            }
            else {
                echo "|";
            }
        }
        $result->close();
    }
    $db_connection->close();
    if ($verifyPassword !== $password) {
        echo "<strong>Passwords do not match</strong><br>|";
    }
    else  {
        echo "|";
    }
    if (strlen($email) > 30) {
        echo "<strong>Invalid email address</strong><br>";
    }
    else {
        echo "";
    }
?>