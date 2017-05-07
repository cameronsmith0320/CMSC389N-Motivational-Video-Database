<?php
	session_start();
	$username = $_SESSION['username'];
	
	$playlists_form = "";
	
	$host = "localhost";
	$user = "server";
	$dbpassword = "terps";
	$database = "motivationaldb"; // max lengths in form to be updated with actual max lengths from database, if needed
	$table = "playlist";
	
	$db_connection = new mysqli($host, $user, $dbpassword, $database);
	if ($db_connection->connect_error) {
		die($db_connection->connect_error);
	}
	
	$query = "select * from $table where username = '$username'";
	$result = $db_connection->query($query);
	
	if (!$result) {
		die("Database access failed: ".$db_connection->error);
	}
	else {
		$num_rows = $result->num_rows;
		if ($num_rows !== 0) {
			for($i = 0; $i < $num_rows; $i++){
				$result->data_seek($i);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$playlists_form .= '<input type="radio" name="playlist_selected" value="'.$row['playlist_name'].'">'.$row['playlist_name'].'</br>';
			}
		}
	}

	$body = <<<TEST
		<img src = fetchImage.php?name width=200 height=200>
		</br></br>
		<h1>Welcome $username</h1>
		Select your playlist:
		<form action="mainPage.php" method="post">
			$playlists_form
			<input type="submit" value="submit">
		</form>
TEST;
	
    $page = <<<PAGE
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
            <head> 
                <meta charset="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
                <script src="createAccountValidation.js"></script>
                <title>Login - Database of Motivational Videos</title>
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
