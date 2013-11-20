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
                    <li> <a href="homepage.php">Homepage</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
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
					<form action="homepage.php" method="post">
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
               <h2>BUY GAME</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						GAME ID: <input type="text" placeholder="STRING" name="id"><br>
						<input type="submit" class="btn btn-default" name="buyGame">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>RANK GAMES</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="rank">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>VIEW ACHIEVEMENTS</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="achi">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>TRANSACTION RECORDS</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="transRec">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>MY FRIENDS</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="friends">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>MY FRIENDS' WISHLISTS</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="friendswants">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>MY WISHLIST</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="wants">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>LOWEST RATING OF A GAME</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="mostPop">
					</form>
                </div>
            </div>
			<div class="row">
               <h2>ALL SAVED GAMES</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="saves">
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
		return false;
	} else {

	}
	return $statement;

}


function printGameResult($result) { //prints results from a select statement
	echo "<br>GAME FILTERED:<br>";
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

function printRankResult($result) { //prints results from a select statement
	echo "<br>GAME RANKINGS:<br>";
	echo "<table>";
	echo "<tr>
			<th>Name</th>
			<th>Rank</th>
		</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[0] . "</td>
		<td>" . $row[1] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printAchiResult($result) { //prints results from a select statement
	echo "<br>MY ACHIEVEMENTS:<br>";
	echo "<table>";
	echo "<tr>
			<th>Name</th>
			<th>Points</th>
			<th>Game</th>
			</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[1] . "</td>
		<td>" . $row[2] . "</td>
		<td>" . $row[3] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printRecResult($result) { //prints results from a select statement
	echo "<br>MY TRANSACTION RECORDS:<br>";
	echo "<table>";
	echo "<tr>
			<th>Transaction Type</th>
			<th>Item ID</th>
			<th>Item Name</th>
			<th>Transaction Amount</th>
			</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[0] . "</td>
		<td>" . $row[1] . "</td>
		<td>" . $row[2] . "</td>
		<td>" . $row[3] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printFriendResult($result) { //prints results from a select statement
	echo "<br>FRIENDS:<br>";
	echo "<table>";
	echo "<tr>
			<th>Name</th>
		</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[1] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printMWishResult($result) { //prints results from a select statement
	echo "<br>I WANT THESE:<br>";
	echo "<table>";
	echo "<tr>
			<th>Name</th>
		</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[1] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printOWishResult($result) { //prints results from a select statement
	echo "<br>MY FRIENDS WANTS THESE:<br>";
	echo "<table>";
	echo "<tr>
			<th>Name</th>
			<th>Game</th>
		</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[1] . "</td>
		<td>" . $row[3] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printSavesResult($result) { //prints results from a select statement
	echo "<br>ALL SAVES ON SERVER:<br>";
	echo "<table>";
	echo "<tr>
			<th>Save ID</th>
			<th>Save State</th>
			<th>Game</th>
		</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[2] . "</td>
		<td>" . $row[3] . "</td>
		<td>" . $row[4] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function printLoRatResult($result) { //prints results from a select statement
	echo "<br>LO Rating is:<br>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[0] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
}

if ($db_conn) {
	if(isset($_SESSION['CurrentUser'])){
		if ($_SESSION['PrivLevel'] < 9000) {
			
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
			} else if (array_key_exists('rank', $_POST)) {
				$result = executePlainSQL("	SELECT DISTINCT	g.name, ga.arank
											FROM		game g, game_avg ga
											WHERE		g.gid = ga.gid
											ORDER BY	ga.arank DESC");													
				printRankResult($result);
			} else if (array_key_exists('achi', $_POST)) {
				$result = executePlainSQL("	SELECT DISTINCT	e.aid, h.name, h.points, g.name
											FROM		Has_Achievement h, Earns e, Game g
											WHERE		e.id = $userData[0] AND e.aid = h.aid AND h.gid = g.gid");													
				printAchiResult($result);
			} else if (array_key_exists('transRec', $_POST)) {
				$result = executePlainSQL("	SELECT DISTINCT	'Game Card Received' AS Type, gc1.cid AS ID, 'Card', gc1.amount AS Price
											FROM		giftcard gc1
											WHERE		gc1.rid = $userData[0]
											UNION
											SELECT DISTINCT	'Game Card Bought', gc2.cid, 'Card', gc2.amount
											FROM		giftcard gc2
											WHERE		gc2.buyer_id = $userData[0]
											UNION
											SELECT DISTINCT	'Game Bought', g.gid, g.name, g.price
											FROM		game g, buys_game b
											WHERE		b.id = $userData[0] AND g.gid = b.gid");													
				printRecResult($result);
			} else if (array_key_exists('friends', $_POST)) {
				$result = executePlainSQL("	SELECT DISTINCT f.id2 AS PID, p.name
											FROM		friends f, player p
											WHERE		f.id1 = $userData[0] AND f.id2 <> $userData[0] and p.id = f.id2");													
				printFriendResult($result);
			} else if (array_key_exists('friendswants', $_POST)) {
				$result = executePlainSQL("	SELECT DISTINCT p.id AS playerid, p.name as playername, g.id as wantgameid, g.name as wantgamename
											FROM		friends f, player p, game g, wants w
											WHERE		f.id1 = $userData[0] AND f.id2 <> $userData[0] AND p.id = f.id2 AND w.id = p.id AND g.gid = w.gid");													
				printOWishResult($result);
			} else if (array_key_exists('wants', $_POST)) {
				$result = executePlainSQL("	SELECT DISTINCT g.gid AS gid, g.name AS name
											FROM		wants w, game g
											WHERE		w.id = $userData[0] AND g.gid = w.gid");													
				printMWishResult($result);
			} else if (array_key_exists('minPop', $_POST)) {
				$result = executePlainSQL("	SELECT 		MIN (ranking) AS minratedgame
											FROM 		(	SELECT 	AVG(prank) AS ranking
														FROM	ranks r
														GROUP BY gid)");													
				printHiRatResult($result);
			} else if (array_key_exists('saves', $_POST)) {
				$result = executePlainSQL("	SELECT		p.id, p.name as playername, s.sid as saveid, s.state, g.name as gamename, g.genre
											FROM 		player p
											INNER JOIN	save_store s ON s.id = p.id
											INNER JOIN	game g ON g.gid = s.gid");													
				printSavesResult($result);
			} else if (array_key_exists('buyGame', $_POST)) {
				$id = $_POST['id'];
				$idRes = executePlainSQL("SELECT * FROM game g WHERE g.gid = $id");
				$idRow = OCI_Fetch_Array($idRes, OCI_BOTH);;
				if (!($idRow[0] == NULL)) {
					$result1 = executePlainSQL("UPDATE player
												SET balance = balance - $idRow[0]
												WHERE id = $userData[0]");
					if (!($result1 === false)) {
						$result2 = executePlainSQL("INSERT INTO buys_game VALUES ($userData[0], $id)");
						if ($result2 === false) {
							echo "Purchase failed, returning your money";
							executePlainSQL("	UPDATE player
												SET balance = balance + $idRow[0]
												WHERE id = $userData[0]"); 
						} else {
							echo "Purchase successful.";
						}
					}	
				} else {
					echo "game not found";
					}
			}
		} else {
			echo "You are been redirected to Company page.";
			header("Refresh: 0; url=company.php");	
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