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
		<iframe id="video" width="420" height="315" src="//www.youtube.com/embed/9B7te184ZpQ?rel=0" frameborder="0" allowfullscreen></iframe>
		<?php
		/*
			require_once "databaseLogin.php";
			$db_connection = new mysqLi($host, $user, $password, $database);
			if($db_connection->connect_error) {
				die($db_connection->connect_error);
			} else {
			}
			
			$selected = $_POST['selected'];
			

			$query = "select ".implode(", ", $selected)." from applicants";
			
			if($_POST['filter'] != '') {
				$query .= " where ".$_POST['filter'];
			}
			
			$query .= " order by ".$_POST['sorter'];
			
			$result = $db_connection->query($query);
		*/
			
			/*Update profile login information if available*/
			
			/*Grab first video on the playlist and embed in iFrame*/
			
			/*Have the list of videos on the side*/
			
			/*On video click, refresh page*/
			
			
			
			
		?>
	
	<br><br>
	
	<input class="btn btn-primary" type="submit" value="Add to my playlist"/>
	<form action="main.html">
			
	</form>
	

</html>