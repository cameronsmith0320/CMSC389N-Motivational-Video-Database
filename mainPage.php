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
		 <div class="container">
                <div class="row">
                            <div class="pull-left">
								<form action="myVideos.php" method="post">
									<input type="image" src="DMV-logo.png" alt="Submit Form" />
									<input type="hidden" name="username" value="$username">
								</form>
                            </div>
							
							<div class="pull-right">
								<form action="index.html">
								<button class="btn btn-default btn-sm" type="submit" id="logout"> Logout </button>
								
							</form>
						</div>
                        </div>
						<div>
            </header>
            <hr>
		
		<?php
			if(isset($_POST['playlist_selected'])) {
				$username = $_POST['username'];
				$playlist_name = $_POST['playlist_selected'];
				
				$playlist_id = null;
				$list_of_video_ids = [];
				$video_player = '<iframe id="video" width="650" height="487" src="//www.youtube.com/embed/';
				
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
				
				$addToPlaylistForm = "";
				if(sizeof($list_of_video_ids) == 0) {
					echo "<bold>Error: no videos in playlist</bold>";
				} else {
					if(sizeof($list_of_video_ids) >= 2){
						$video_player .= $list_of_video_ids[0].'?playlist=';
						for($i = 1; $i < sizeof($list_of_video_ids); $i++) {
							$video_player .= $list_of_video_ids[$i].',';
						}
						$video_player = rtrim($video_player, ',');
					} else {
						$video_player .= $list_of_video_ids[0];
					}
					$video_player .= '"frameborder="0" allowfullscreen>></iframe>';
					echo '<div class="text-center">';
					echo $video_player;
					echo '</div>';
					$firstVideoUrl = "https://www.youtube.com/watch?v=".$list_of_video_ids[0];
					$addToPlaylistForm = <<<PLAYLIST
					<div class="text-center">'
						<form action="uploadVideo.php" method="post">
							<input type="hidden" name="video_url" value="$firstVideoUrl">
							<input class="btn btn-primary" type="submit" value="Add to my playlist"/>
						</form>
					</div>
PLAYLIST;	
				} 
				
				echo $addToPlaylistForm;
			}
		?>
	
	<br><br>
	

</html>
