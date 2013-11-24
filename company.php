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
            <div id="result">
                <h3>Result: </h3>
                <p class="well">
                    <?php

                    function printGameResult($result) { //prints results from a select statement
                        echo "<br>Got data from table tab1:<br>";
                        echo '<table class="table">';
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

					function printNameResult($result) { //prints results from a select statement
						echo "<br>Players who have bought all of our games:<br>";
						echo '<table class="table">';
						echo "<tr>
								<th>Player name</th>
							</tr>";

						while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
							echo "<tr>
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
									$id = $userData[0];	
                                    $result = executePlainSQL("	SELECT p.name
																FROM player p
																WHERE p.id IN (
																				SELECT b.id
																				FROM Buys_Game b
																				WHERE b.gid IN ( 
																							 SELECT g.gid
																							 FROM Games g 
																							 WHERE g.id = $id)
																				GROUP BY b.id
																				HAVING COUNT(*) = ( 
																									SELECT COUNT (*)
																									FROM Games g 
																									WHERE g.id = $id))");							
                                    printNameResult($result);
                                } else if (array_key_exists('selfDestruct', $_POST)) {
									$id = $userData[0];									
                                    $result = executePlainSQL("	DELETE
																FROM company
																WHERE id = $id");
									OCI_COMMIT($db_conn);
									session_unset();
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
                </p>
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
               <h2>MOST LOYAL CUSTOMERS</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="company.php" method="post">
						<input type="submit" class="btn btn-default" name="loyals">
					</form>
                </div>
            </div>	
			<div class="row">
               <h2>DECLARE BANKRUPCY</h2>
            </div>
            <div class="row">
                <div class="col-md-2">
					<form action="company.php" method="post">
						<input type="submit" class="btn btn-default" name="selfDestruct" value="Display">
					</form>
                </div>
            </div>			
        </div>
    </body>
</html>
