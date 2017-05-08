<!-- vim: set ft=html: -->
<!DOCTYPE html>

<?php
session_start();
require_once("db.php");

if(!isset($_POST['submit'])){
    // Page loaded for the first time, display playlist forms dynamically depending
    // on if there are playlists existing for the user

    $query = "SELECT * FROM playlist WHERE username='$username'";

    $result = $db_connection->query($query);
    if(!$result){
        die("Username query failed: ".$db_connection->error);
    }else{
        $num_rows = $result -> num_rows;
        if($num_rows === 0){
            // no playlists, display playlist creation
            $playlistForm = <<<CREATEPLAYLIST
                <div class="form-group">
                    <label for="playlist"> Add to playlist </label>
                    <input class="form-control" type="text" value="New Playlist" name="playlistCreate"/>
                    <small class="form-text text-muted"> This will create a new playlist to hold your video </small>
                </div>
CREATEPLAYLIST;
        }else{
            // existing playlists, display
            $playlistForm = <<<SELECTPLAYLIST
                <div class="form-group">
                    <label for="playlist"> Add to playlist </label>
                    <select class="form-control" id="playlistSelect" name="playlistSelect">
SELECTPLAYLIST;
            for($i = 0; $i < $num_rows; $i++){
                $result -> data_seek($i);
                $entry = $result->fetch_array(MYSQLI_ASSOC);
                $playlistForm .= '<option value="'.$entry['playlist_id'].'">'.$entry['playlist_name'].'</option>';
            }
            $playlistForm .= <<<ENDTAGS
                <option value="new"> New Playlist </option>
            </select>
        </div>
ENDTAGS;
        }
    }
    $db_connection->close();

}elseif(isset($_POST['submit'])){
    // Page loaded after submit button is pressed, insert relevant entries into
    // database and go back to main playlist page
    $link = sanitize($db_connection, $_POST['link']);
    if($_POST['playlistCreate']){
        $playlist_name = sanitize($db_connection, $_POST['playlistCreate']);
        $query = "INSERT INTO playlist (username, playlist_name) VALUES('$username', '$playlist_name')";
        $result = $db_connection->query($query);
        if(!$result){
            die("Playlist creation failed: ".$db_connection->error);
        }
        //get playlistid
        $query = "SELECT playlist_id FROM playlist WHERE username='$username' and playlist_name='$playlist_name'";
        $result = $db_connection->query($query);
        if(!$result){
            die("Playlist creation failed: ".$db_connection->error);
        }
        $num_rows = $result -> num_rows;
        //should only have one result
        if($num_rows == 1){
            $result->data_seek(0);
            $entry = $result->fetch_array(MYSQLI_ASSOC);
            $playlist_id = $entry['playlist_id'];
        }else{
            throw new Exception('playlist_id not found!');
        }
        $query = "INSERT INTO playlist_to_video VALUES($playlist_id, '$link') ";
        $result = $db_connection->query($query);
        if(!$result){
            die("Playlist-Video linking failed: ".$db_connection->error);
        }
    }elseif($_POST['playlistSelect']){
        $playlist_id = $_POST['playlistSelect'];
        $query = "INSERT INTO playlist_to_video VALUES($playlist_id, '$link') ";
        $result = $db_connection->query($query);
        if(!$result){
            die("Playlist-Video linking failed: ".$db_connection->error);
        }
    }
    $db_connection->close();
    header('Location: playlist.php');
}
?>


<html>
    <head>
        <title>Upload Video</title>
        <link rel="stylesheet" href="main.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>

    <body>

        <div class="container">
            <header>
                <div class="pull-left">
                    <h3>Database of Motivational Videos</h3>
                </div>
                <div class="pull-right">
                    <span class="loginbtn" id="loginbtn"></span>
                </div>
                <div class="pull-right">
                    <span class="username" id="username"></span>
                    &nbsp;
                </div>
                <div class="clearfix"></div>
            </header>

            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="upload"> Add a video link </label>
                    <input required class="form-control" type="text" placeholder="https://www.youtube.com/watch?v=6bdHBoG2bLY" name="link"/>
                </div>
<?php echo $playlistForm ?>
                <span id="newPlaylist"></span>

                    <br>

                    <input class="btn btn-primary" type="submit" name="submit" value="Add"/>
                    <a href="playlist.php" class="btn btn-default"> Cancel </a>
                </div>
            </form>

            <br/>
            <hr>
            <footer>
                <span id="footer"></span>
            </footer>
        </div>

        <span id="phpjs-username" style="display: none;"><?php echo $username ?></span>
        <script src="style.js"></script>
        <script src="uploadVideo.js"></script>

    </body>
</html>
