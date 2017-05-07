<!-- vim: set ft=html: -->
<!DOCTYPE html>

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
                    <span class="username"></span>
                    <form action="logout.php">
                        <button class="btn btn-default btn-sm" type="submit" id="logout"> logout </button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </header>
            <hr>
            <form action="" method="POST">
                <div class="form-group">

                    <label for="upload"> Add a video link </label>
                    <input class="form-control" type="text" placeholder="https://www.youtube.com/watch?v=6bdHBoG2bLY"/>

                    <br>

                    <input class="btn btn-primary" type="submit" value="Add"/>
                    <a href="playlist.php" class="btn btn-default"> Cancel </a>
                </div>
            </form>

            <br/>
            <hr>
            <footer>
                <span id="footer"></span>
            </footer>
        </div>

        <script src="style.js"></script>

    </body>
</html>
