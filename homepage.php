<?php
require_once("config.php");
include 'globalfunc.php';
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
                            <h3>Logout</h3>
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
            <div id="result">
                <h3> Results: </h3>
                <p class="well">
                <?php

                function printGameResult($result) { //prints results from a select statement
                    echo "<br>GAME FILTERED:<br>";
                    echo '<table class="table">';
                    echo "<tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Genre</th>
                            <th>IGNScore</th>
                            <th></th>
                            <th></th>
                            </tr>";

                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[4] . "</td>
                        <td>" . $row[5] . "</td>
                        <td><form action='homepage.php' method='post'>
                        <input type='hidden' name='id' value='" . $row[2] . "'>
                        <input type='submit' class='btn btn-default' name='addWantItem' value='Want'></form></td>
                        <td><form action='homepage.php' method='post'>
                        <input type='hidden' name='id' value='" . $row[2] . "'>
                        <input type='submit' class='btn btn-default' name='buyGame' value='Buy'></form></td>
                        </tr>"; //or just use "echo $row[0]" 
                    }
                    echo "</table>";
                }

                function printRankResult($result) { //prints results from a select statement
                    echo "<br>GAME RANKINGS:<br>";
                    echo '<table class="table">';
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
                    echo '<table class="table">';
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
                    echo '<table class="table">';
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
                    echo '<table class="table">';
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
                    echo '<table class="table">';
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

				
                function printMWishResult($result) { //prints results from a select statement
                    echo "<br>I WANT THESE:<br>";
                    echo '<table class="table">';
                    echo "<tr>
                            <th>Game</th>
                            <th>Genre</th>
                            <th>IGN Score</th>
                            <th>Price</th>
							<th></th>
                          </tr>";

                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                        <td>" . $row[2] . "</td>
                        <td><form action='homepage.php' method='post'>
                        <input type='hidden' name='id' value='" . $row[0] . "'>
                        <input type='submit' class='btn btn-default' name='deleteWishItem' value='Delete'></form></td>
                        </tr>"; //or just use "echo $row[0]" 
                    }
                    echo "</table>";
                }
				
                function printSavesResult($result) { //prints results from a select statement
                    echo "<br>ALL SAVES ON SERVER:<br>";
                    echo '<table class="table">';
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
                    echo "</table>";
                }

                function printLibResult($result) {
                    echo "<br>My Game Library:<br>";
                    echo '<table class="table">';
                    echo "<tr>
                            <th>Title</th>
                            <th>ID</th>
                            <th>Genre</th>
                            <th>ignscore</th>
                            <th></th>
                        </tr>";

                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td><form action='homepage.php' method='post'>
                        <input type='hidden' name='id' value='" . $row[1] . "'>
                        <input type='submit' class='btn btn-default' name='delete' value='Delete'></form></td>
                        </tr>"; //or just use "echo $row[0]" 
                    }
                    echo "</table>";
                }

				function printBalResult($result) {
                    echo "<br>My Balance:<br>";
                    echo '<table class="table">';
                    echo "<tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Balance</th>
                            <th></th>
							<th></th>
                            <th></th>
                        </tr>";

                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td><form action='homepage.php' method='post'>
						<input type='text' placeholder='INT' name='amount'>
						<input type='submit' class='btn btn-default' name='addBal' value='Credit'>
                        <input type='submit' class='btn btn-default' name='subBal' value='Debit'></form></td>
                        </tr>"; //or just use "echo $row[0]" 
                    }
                    echo "</table>";
                }

                function printPlayerResult($result, $select) {
                    echo "<br>Player Profile:<br>";
                    echo '<table class="table">';
                    echo "<tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Balance</th>";
                    if ($select == "1"){
                        echo "  <th>ID</th>
                                <th>Join Date</th>
                                <th>Birthday</th>
                                <th>Game Points</th>";
                    }
                    echo "</tr>";

                    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                        echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>";
                        if ($select == "1"){
                        echo "  <td>" . $row[3] . "</td>
                                <td>" . $row[4] . "</td>
                                <td>" . $row[5] . "</td>
                                <td>" . $row[6] . "</td>";
                        }
                        echo "</tr>"; //or just use "echo $row[0]" 
                    }
                    echo "</table>";
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
                            } else if (array_key_exists('delete', $_POST)) {
                                $gid = $_POST['id'];
                                $result = executePlainSQL(" DELETE
                                                            FROM        buys_game
                                                            WHERE       gid = $gid ");  
                                oci_commit($db_conn);
                                $result = executePlainSQL(" SELECT g.name, g.gid, g.genre, g.ignscore
                                                            FROM        buys_game bg INNER JOIN game g ON g.gid = bg.gid
                                                            WHERE       bg.id = $userData[0]");                                                    
                                printLibResult($result);
                            } else if (array_key_exists('game_lib', $_POST)) {
                                $result = executePlainSQL(" SELECT g.name, g.gid, g.genre, g.ignscore
                                                            FROM        buys_game bg INNER JOIN game g ON g.gid = bg.gid
                                                            WHERE       bg.id = $userData[0]");                                                    
                                printLibResult($result);
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
                                $result = executePlainSQL("SELECT DISTINCT g.gid AS gid, g.name AS name, g.price, g.genre, g.ignscore			
	                                                       FROM			wants w, game g			
                                                           WHERE			w.id = $userData[0] AND g.gid = w.gid");													
                                printMWishResult($result);
                            } else if (array_key_exists('balance', $_POST)) {
                                $result = executePlainSQL("SELECT DISTINCT 	p.id, p.name, p.balance			
	                                                       FROM				player p			
                                                           WHERE			p.id = $userData[0]");													
                                printBalResult($result);
                            } else if (array_key_exists('addBal', $_POST)) {
							    $amount = $_POST['amount'];
								$result = executePlainSQL("	UPDATE player p
															SET balance = balance + $amount
															WHERE p.id = $userData[0]");
								oci_commit($db_conn); 
                                $result = executePlainSQL("SELECT DISTINCT 	p.id, p.name, p.balance			
	                                                       FROM				player p			
                                                           WHERE			p.id = $userData[0]");													
                                printBalResult($result);
                            } else if (array_key_exists('subBal', $_POST)) {
							    $amount = $_POST['amount'];
								$result = executePlainSQL("	UPDATE player p
															SET balance = balance - $amount
															WHERE p.id = $userData[0]");
								oci_commit($db_conn); 
                                $result = executePlainSQL("SELECT DISTINCT 	p.id, p.name, p.balance			
	                                                       FROM				player p			
                                                           WHERE			p.id = $userData[0]");													
                                printBalResult($result);
                            } else if (array_key_exists('addWantItem', $_POST)) {    
                                $gid = $_POST['id'];            
                                $result = executePlainSQL(" INSERT INTO wants VALUES ($userData[0], $gid)");      
                                oci_commit($db_conn);       
                                $result = executePlainSQL("SELECT DISTINCT g.gid AS gid, g.name AS name, g.price, g.genre, g.ignscore           
                                                           FROM         wants w, game g         
                                                           WHERE            w.id = $userData[0] AND g.gid = w.gid");
                                printMWishResult($result);          
                                
                            } else if (array_key_exists('deleteWishItem', $_POST)) {	
	                            $gid = $_POST['id'];			
	                            $result = executePlainSQL(" DELETE			
	                                                       FROM        Wants			
	                                                       WHERE       gid = $gid AND id = $userData[0]");  	
                                oci_commit($db_conn);		
	                            $result = executePlainSQL("SELECT DISTINCT g.gid AS gid, g.name AS name, g.price, g.genre, g.ignscore			
	                                                       FROM			wants w, game g			
                                                           WHERE			w.id = $userData[0] AND g.gid = w.gid");
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
                            } else if (array_key_exists('player', $_POST)) {
                                $query = "SELECT name, email, balance";
                                $select = $_POST['select'];
                                if ($select == "1"){
                                    $query .= ", id, joindate, bday, gamept ";
                                }
                                $query .= " FROM player p            
                                            WHERE       p.id = $userData[0]";
                                $result = executePlainSQL($query);                                                  
                                printPlayerResult($result, $select);
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
                                        oci_commit($db_conn);
                                        if ($result2 === false) {
                                            echo "Purchase failed, returning your money";
                                            executePlainSQL("	UPDATE player
                                                                SET balance = balance + $idRow[0]
                                                                WHERE id = $userData[0]"); 
                                            oci_commit($db_conn);
                                        } else {
                                            echo "Purchase successful.";

                                            // test code for checking the insertion
                                            $result = executePlainSQL(" SELECT g.name, g.gid, g.genre, g.ignscore
                                                            FROM        buys_game bg INNER JOIN game g ON g.gid = bg.gid
                                                            WHERE       bg.id = $userData[0]");                                                    
                                            printLibResult($result);


                                            /*test code for test code
                                            $result = executePlainSQL(" SELECT *
                                                            FROM        buys_game bg
                                                            WHERE       bg.id = $userData[0]");                                                    
                                                            echo "<br>Buys_Game:<br>";
                                                            echo '<table class="table">';
                                                            echo "<tr>
                                                                    <th>ID</th>
                                                                    <th>GID</th>
                                                                </tr>";

                                                            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                                                                echo "<tr>
                                                                <td>" . $row[0] . "</td>
                                                                <td>" . $row[1] . "</td>
                                                                </tr>"; //or just use "echo $row[0]" 
                                                            }
                                                            echo "</table>";*/
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
                </p>
            </div>
			<div class="row">
               <h3>FILTER</h3>
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
						<input type="submit" class="btn btn-default" name="filter" value="Search">
					</form>
                </div>
            </div>

            <div class="row">
            <h3>PLAYER PROFILE</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <form action="homepage.php" method="post">
                        <input type="radio" name="select" value="0">Simple<br>
                        <input type="radio" name="select" value="1">Complete<br>
                        <input type="submit" class="btn btn-default" name="player" value="Display">
                    </form>
                </div>
            </div>

			<div class="row">
               <h3>RANK GAMES</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="rank" value="Display">
					</form>
                </div>
            </div>

            <div class="row">
				<h3>MY GAME LIBRARY</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <form action="homepage.php" method="post">
                        <input type="submit" class="btn btn-default" name="game_lib" value="Display">
                    </form>
                </div>
            </div>

			<div class="row">
               <h3>VIEW ACHIEVEMENTS</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="achi" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>TRANSACTION RECORDS</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="transRec" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>MY FRIENDS</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="friends" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>MY FRIENDS' WISHLISTS</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="friendswants" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>MY BALANCE</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="balance" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>MY WISHLIST</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="wants" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>LOWEST AVG RATING OUT OF ALL GAMES</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="minPop" value="Display">
					</form>
                </div>
            </div>

			<div class="row">
               <h3>ALL SAVED GAMES</h3>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="homepage.php" method="post">
						<input type="submit" class="btn btn-default" name="saves" value="Display">
					</form>
                </div>
            </div>

        </div>
    </body>
</html>



