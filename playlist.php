<!-- vim: set ft=html: -->
<!DOCTYPE html>
<?php
session_start();
require_once("db.php");

if(!isset($_POST['submit'])){
    $query = "SELECT * FROM playlist WHERE username='$username' ORDER BY playlist_id";
    $result = $db_connection->query($query);
    if(!$result){
        die("Playlist query failed: ".$db_connection->error);
    }else{
        $num_rows = $result -> num_rows;
        if($num_rows === 0){
            $table = "You have no playlists! Add a video to create a playlist.";
        }else{
            $table = <<<TABLE
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th> Playlist Name </th>
            <th> Videos </th>
            <th> Actions </th>
        </tr>
    </thead>
TABLE;
            for($i = 0; $i < $num_rows; $i++){
                $result -> data_seek($i);
                $entry = $result->fetch_array(MYSQLI_ASSOC);
                $table .= "<tr> <td>".$entry['playlist_name']."</td>";
                //get video count
                $query = "SELECT COUNT(video_url) AS cnt FROM playlist_to_video WHERE playlist_id='".$entry['playlist_id']."'";
                $countresult = $db_connection->query($query);
                if(!$countresult){
                    die("Video Count failed: ".$db_connection->error);
                }else{
                    $countresult->data_seek(0);
                    $count = $countresult->fetch_array(MYSQLI_ASSOC);
                    $count = $count['cnt'];
                }
                $table .= "<td> $count </td>";
                $table .= <<<ACTIONS
<td>
<div class="form-group">
    <form method="POST">
        <button class="btn btn-primary" type="submit" name="rename"> Rename </button>
        <button class="btn btn-danger" type="submit" name="delete"> Delete </button>
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
                    <h3>Database of Motivational Videos</h3>
                </div>
                <div class="pull-right">
                    <form action="logout.php">
                        <button class="btn btn-default btn-sm" type="submit" id="logout"> logout </button>
                    </form>
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
            <hr>
            <footer>
                <span id="footer"></span>
            </footer>
        </div>

        <script src="style.js"></script>
    </body>
</html>
