<?php
session_save_path('./savepath/');
session_start();

if(isset($_SESSION['CurrentUser'])){
	echo "this is a dummy homepage, you have logged in";
} else {
	echo "you have not logged in, redirecting in 2 secs";
	
	header("Refresh: 1.5; url=index.php");
}
?>