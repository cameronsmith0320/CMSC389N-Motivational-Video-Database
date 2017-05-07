<?php
// this file is basically so we don't have to put the db info for every php file
// that deals with the database. it automatically creates a connection (but
// doesn't close it!)
    $host = "localhost";
    $user = "server";
    $dbpassword = "terps";
    $database = "motivationaldb"; // max lengths in form to be updated with actual max lengths from database, if needed
    $table = "users";
    $username = 'test';
    //$username = $_SESSION['username'];

    $db_connection = new mysqli($host, $user, $dbpassword, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }

function sanitize($db_connection, $string){
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    return htmlentities($db_connection -> real_escape_string($string));
}
?>
