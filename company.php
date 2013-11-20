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
        <div class="modal fade" id="logoutmodal" tabindex="-1" role="dialog" aria-labelledby="logoutLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="logoutLabel">
                            <h2>Logout</h2>
                        </div>  
                        <div class="modal-body">
                            <form role="form" method="POST" action="index.php">
                                <div class="form-group">
                                    <h3> Do you want to logout?</h3>
                                </div>
                                <button type="submit" class="btn btn-default" name="logout">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">cs304</a>
            </div>
            <div class="collapse navbar-collapse" id="#bs-navbar">
                <ul class="nav navbar-nav">
                    <li> <a href="company.php">Homepage</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Companies <b class="caret"></b></a>
                        <ul class="dropdown-menu">
							<li><a href="#">Link</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                            if (isset($_SESSION['CurrentUser'])) {                              
                                echo '<a href="#" data-toggle="modal" data-target="#logoutmodal">Sign Out</a></li>';
                            } else {
								header("Refresh: 1.5; url=index.php");
                            }

                        ?>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
               <h1>cs304</h1>
            </div>
			<div class="row">
               <h2>FILTER</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="company.php" method="post">
						Name: <input type="text" placeholder="STRING" name="name"><br>
						Category: <input type="text" placeholder="STRING" name="cat"><br>
						Ratings:
						<table>
						  <tr>
							<td><input type="text" placeholder="FROM (INCLUSIVE)" name="ratFromIncl"></td>
							<td><input type="text" placeholder="TO (INCLUSIVE)" name="ratToIncl"></td>
						  </tr>
						</table>
						Price:
						<table>
						  <tr>
							<td><input type="text" placeholder="FROM (INCLUSIVE)" name="priFromIncl"></td>
							<td><input type="text" placeholder="TO (INCLUSIVE)" name="priToIncl"></td>
						  </tr>
						</table>
						<input type="submit" class="btn btn-default" name="filter">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>ALL PLAYERS WHO OWN OUR GAMES</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="company.php" method="post">
						<input type="submit" class="btn btn-default" name="owners">
					</form>
                </div>
            </div>
        </div>
    </body>
</html>

<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_y5q8", "a10733129", "ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}


function printGameResult($result) { //prints results from a select statement
	echo "<br>Got data from table tab1:<br>";
	echo "<table>";
	echo "<tr>
			<th>Name</th>
			<th>Price</th>
			<th>Genre</th>
			<th>IGNScore</th>
			</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[2] . "</td>
		<td>" . $row[1] . "</td>
		<td>" . $row[5] . "</td>
		<td>" . $row[6] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printOwnerResult($result) { //prints results from a select statement
	echo "<br>Users:<br>";
	echo "<table>";
	echo "<tr>
			<th>ID</th>
			<th>Name</th>
		</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[0] . "</td>
		<td>" . $row[1] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

if ($db_conn) {
	if(isset($_SESSION['CurrentUser'])){
		if ($_SESSION['PrivLevel'] > 9000) {
			$userData = $_SESSION['UserData'];
			if (array_key_exists('filter', $_POST)) {
				$name = $_POST['name'];
				$cat  = $_POST['cat'];
				$ratF = $_POST['ratFromIncl'];
				$ratT = $_POST['ratToIncl'];
				$priF = $_POST['priFromIncl'];
				$priT = $_POST['priToIncl'];		
				
				$whereQ = "";
				if ($name == NULL)
					$name = '%';
				else
					$name = '%' . $name . '%';
					
				if ($cat == NULL)
					$cat = '%';
				else
					$cat = '%' . $cat . '%';	

				if ($ratF == NULL)
					$ratF = 0;
					
				if ($ratT == NULL)
					$ratT = 99999999999;				
				
				if ($priF == NULL)
					$priF = 0;
					
				if ($priT == NULL)
					$priT = 99999999999;	

				$result = executePlainSQL("select * from game where name LIKE '$name' 
											and genre LIKE '$cat' and ignscore >= $ratF 
											and ignscore <= $ratT and price >= $priF 
											and price <= $priT");													
				printGameResult($result);
			} else if (array_key_exists('owner', $_POST)) {
				$result = executePlainSQL("	select b.id, p.name
											from Buys_Game b, Game g, Player p
											where p.id = b.id and g.gid = b.gid and g.id = $userData[0]");													
				printOwnerResult($result);
			}
		} else {
			echo "How did you get here, you petty user. Go back to your homepage.";
			header("Refresh: 0; url=index.php");	
		}
	} else {
			echo "you have not logged in, redirecting in 2 secs";
	}
} else {
			echo "cannot connect";
			$e = OCI_Error(); // For OCILogon errors pass no handle
			echo htmlentities($e['message']);
}
?>