<?php
	header("content-type:image/jpg");
	
	session_start();
	
	$host = "localhost";
	$user = "server";
	$dbpassword = "terps";
	$database = "motivationaldb"; // max lengths in form to be updated with actual max lengths from database, if needed
	$table = "users";
	$username = $_SESSION['username'];
	
	if(isset($_SESSION['search_username'])){
		$username = $_SESSION['search_username'];
	}

	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	}

	$name=$_GET['name'];

	$select_image="select * from users where username='$username'";

	$result = $db_connection->query($select_image);

	$row = $result->fetch_array(MYSQLI_ASSOC);
	$image_content=$row["profile_image"];

	echo $image_content;
?>