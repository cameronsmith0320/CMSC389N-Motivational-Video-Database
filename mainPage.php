<!doctype html>

<html lang="en">
	<head> 
     <title>Upload Video</title>
        <link rel="stylesheet" href="main.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
	
	<body>
		 <header>
                <div class="pull-left">
                    <h3>Database of Motivational Videos</h3>
                </div>
                <div class="pull-right">
                    <span class="username"></span>
                    <form action="logout.php">
                        <button class="btn btn-default btn-sm" type="submit" id="logout"> logout </button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </header>
            <hr>
		
		<?php
			if(isset($_POST['playlist_selected'])) {
				session_start();
				$username = $_SESSION['username'];
				$playlist_name = $_POST['playlist_selected'];
				
				$playlist_id = null;
				$list_of_video_ids = [];
				$video_player = '<iframe id="video" width="420" height="315" src="//www.youtube.com/embed/';
				
				$host = "localhost";
				$user = "server";
				$dbpassword = "terps";
				$database = "motivationaldb"; // max lengths in form to be updated with actual max lengths from database, if needed
				$table1 = "playlist";
				$table2 = "playlist_to_video";
				
				$db_connection = new mysqli($host, $user, $dbpassword, $database);
				if ($db_connection->connect_error) {
					die($db_connection->connect_error);
				}
				
				$query1 = "select * from playlist where username='$username' and playlist_name='$playlist_name'";
				$result1 = $db_connection->query($query1);
				
				if (!$result1) {
					die("Database access failed: ".$db_connection->error);
				}
				else {
					$num_rows = $result1->num_rows;
					if ($num_rows !== 0) {
						$row = $result1->fetch_array(MYSQLI_ASSOC);
						$playlist_id = $row['playlist_id'];
					}
				}
				
				$query2 = "select * from playlist_to_video where playlist_id = $playlist_id";
				$result2 = $db_connection->query($query2);
				
				if (!$result2) {
					die("Database access failed: ".$db_connection->error);
				}
				else {
					$num_rows = $result2->num_rows;
					if ($num_rows !== 0) {
						for($i = 0; $i < $num_rows; $i++){
							$result2->data_seek($i);
							$row = $result2->fetch_array(MYSQLI_ASSOC);
							$video_url = $row['video_url'];
							$video_id = explode("?v=", $video_url)[1];
							array_push($list_of_video_ids, $video_id);
						}
					}
				}
				
				if(sizeof($list_of_video_ids) >= 2){
					$video_player .= $list_of_video_ids[0].'?playlist=';
					for($i = 1; $i < sizeof($list_of_video_ids); $i++) {
						$video_player .= $list_of_video_ids[$i].',';
					}
					$video_player = rtrim($video_player, ',');
					$video_player .= '"frameborder="0" allowfullscreen>></iframe>';
					echo $video_player;
				} else if(sizeof($list_of_video_ids) == 1){
					$video_player .= $list_of_video_ids[0];
					$video_player .= '"frameborder="0" allowfullscreen>></iframe>';
					echo $video_player;
				} else {
					echo "<bold>Error: no videos in playlist</bold>";
				}
			}
		?>
	
	<br><br>
	
	<input class="btn btn-primary" type="submit" value="Add to my playlist"/>
	<form action="main.html">
			
	</form>
	

</html>