<?php
	$body = <<<TEST
		<img src = fetchImage.php?name width=200 height=200>
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
                    </footer>
                </div>
            </body>
        </html>
PAGE;
    echo $page;
?>