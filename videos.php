<!-- vim: set ft=html: -->
<!DOCTYPE html>
<?php
session_start();
require_once("db.php");

if(isset($_POST)){
    if(isset($_POST['delete'])){
        $video_url = $_POST['delete'];
        $query = "DELETE FROM playlist_to_video WHERE video_url='$video_url'";
        $result = $db_connection->query($query);
        if(!$result)
            die("Video deletion failed: ".$db_connection->error);
    }elseif(isset($_POST['view'])){
        $video_url = $_POST['view'];
        $db_connection->close();
        // view video
        header("Location: $video_url");
    }
}
if(!isset($_GET['playlist_id'])){
    echo "Oops! You shouldn't be here!";
    header("Location: playlist.php");
}
$playlist_id = $_GET['playlist_id'];
$query = "SELECT * FROM playlist WHERE playlist_id='$playlist_id'";
$result = $db_connection->query($query);
if(!$result)
    die("Username query failed: ".$db_connection->error);
$num_rows = $result -> num_rows;
if($num_rows === 0){
    $table = "Playlist does not exist!";
}else{
    $result->data_seek(0);
    $entry = $result->fetch_array(MYSQLI_ASSOC);
    if($entry['username'] != $username){
        $table = "You do not have permission to view this playlist.";
    }else{
        $query = "SELECT * FROM playlist_to_video WHERE playlist_id='$playlist_id'";
        $result = $db_connection->query($query);
        if(!$result)
            die("Videos query failed: ".$db_connection->error);
        $num_rows = $result -> num_rows;
        if($num_rows === 0){
            $table = "This playlist has no video! Add some!";
        }else{
            $table = <<<TABLE
        <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th> Video Title </th>
                <th> Video Link </th>
                <th> Actions </th>
            </tr>
        </thead>
TABLE;
            for($i = 0; $i < $num_rows; $i++){
                $result->data_seek($i);
                $entry = $result->fetch_array(MYSQLI_ASSOC);
                $video_url = $entry['video_url'];
                $page = file_get_contents($video_url);
                $doc = new DOMDocument();
                $doc->loadHTML($page);
                $title_div = $doc->getElementById('eow-title');
                $video_title = $title_div->nodeValue;
                if(!$video_title)
                    $video_title = "Untitled Video";
                $table .= "<tr> <td>".$video_title."</td> <td>".$video_url."</td>";
                $table .= <<<ACTIONS
<td>
<div class="form-group">
<form method="POST">
    <button class="btn btn-primary" type="submit" name="view" value="$video_url"> View </button>
    <button class="btn btn-danger" type="submit" onclick="return(confirm('Are you sure you want to delete this video?'));" name="delete" value="$video_url"> Delete </button>
</form>
</div>
</td>
ACTIONS;
                $table .= "</tr>";
            }
            $table .= "</table>";

        }

    }
}
    $db_connection->close();

?>

<html>
    <head>
        <title>User Playlist</title>
        <link rel="stylesheet" href="main.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>

    <body>

        <div class="container">
            <header>
                <div class="pull-left">
                    <form action="myVideos.php" method="post">
                        <input type="image" src="DMV-logo.png" alt="Submit Form" />
                        <input type="hidden" name="username" value="$username">
                    </form>
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

            <?php echo $table?>

            <br/>
            <a href="uploadVideo.php" class="btn btn-primary"> Add Video </a>
            <a href="playlist.php" class="btn btn-default"> Back </a>
            <br/>
            <hr>
            <footer>
                <span id="footer"></span>
            </footer>
        </div>

        <span id="phpjs-username" style="display: none;"><?php echo $username ?></span>
        <script src="style.js"></script>
    </body>
</html>
