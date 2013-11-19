<?php
session_save_path('./savepath/');
session_start();

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="src/css/bootstrap.css" media="all" rel="stylesheet" type="text/css">
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="src/js/bootstrap.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">cs304</a>
            </div>
            <div class="collapse navbar-collapse" id="#bs-navbar">
                <ul class="nav navbar-nav">
                    <li> <a href="index.php">Index</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                        <ul class="dropdown-menu">
							<li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </li>
					<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Companies <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="signout.php" data-toggle="modal" data-target="#loginmodal">Sign Out</a></li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
               <h1>cs304</h1>
            </div>
            <div class="row">
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </body>
</html>

<?php
if(isset($_SESSION['CurrentUser'])){
	if ($_SESSION['PrivLevel'] < 9000) {
		echo "this is a dummy homepage, you have logged in";
	} else {
		echo "You are been redirected to Company page.";
		header("Refresh: 0; url=index.php");	
	}
} else {
	echo "you have not logged in, redirecting in 2 secs";
	
	header("Refresh: 1.5; url=index.php");
}
?>