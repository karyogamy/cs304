<?php
session_save_path('./savepath/');
session_start();

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_y5q8", "a10733129", "ug");
?>