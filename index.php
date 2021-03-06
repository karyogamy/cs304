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
        <div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="loginLabel">
                            <h2>Login</h2>
                        </div>  
                        <div class="modal-body">
                            <form role="form" method="POST" action="index.php">
                                <div class="form-group">
                                    <label for="InputUsername">Username</label>
                                    <input type="username" class="form-control" id="InputUsername" placeholder="Enter Username" name="username">
                                </div>      
                                <div class="form-group">
                                    <label for="InputPassword">Password</label>
                                    <input type="password" class="form-control" id="InputPassword" placeholder="Enter Password" name="password" >
                                </div>
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <button type="submit" class="btn btn-primary" name="logout">Logout</button>
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
                <a class="navbar-brand" href="#">cs304</a>
            </div>
            <div class="collapse navbar-collapse" id="#bs-navbar">
                <ul class="nav navbar-nav">
                    <li> <a href="homepage.php">Homepage</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                            if (isset($_SESSION['CurrentUser'])) {
                               
                                echo '<a href="#" data-toggle="modal" data-target="#logoutmodal">Sign Out</a></li>';
 
                            } else {
                                echo '<a href="#" data-toggle="modal" data-target="#loginmodal">Sign In</a></li>';
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
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </body>
</html>

<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table tab1:<br>";
	echo "<table>";
	echo "<tr>
			<th>ID</th>
			<th>Name</th>
			<th>PW</th>
			<th>BD</th>
			<th>Email</th>
			</tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row[0] . "</td>
		<td>" . $row[1] . "</td>
		<td>" . $row[2] . "</td>
		<td>" . $row[3] . "</td>
		<td>" . $row[4] . "</td>
		</tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {
    if (array_key_exists('login', $_POST)) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = executePlainSQL("select * from player where name='$username' and password='$password'");
        $rowPlayer = OCI_Fetch_Array($result, OCI_BOTH);
		$result = executePlainSQL("select * from company where name='$username' and password='$password'");
        $rowCompany = OCI_Fetch_Array($result, OCI_BOTH);
		
		if ($rowPlayer != NULL){
			$_SESSION['CurrentUser'] = $username;
			$_SESSION['UserData'] = $rowPlayer;
			$_SESSION['PrivLevel'] = 0;
			
            echo '<script type="text/javascript">window.location.reload()</script>';
			
		} else if ($rowCompany != NULL){
			$_SESSION['CurrentUser'] = $username;
			$_SESSION['UserData'] = $rowCompany;
			$_SESSION['PrivLevel'] = 9001;
			
            echo '<script type="text/javascript">window.location.reload()</script>';
		} else {
			echo "<div class='alert alert-warning'>Login Failed.</div>";		
		}
    } else if (array_key_exists('logout', $_POST)) {
        session_destroy();
        echo '<script type="text/javascript">window.location.reload()</script>';
    } else {
		// Select data...
		if (isset($_SESSION['CurrentUser'])) {
			echo "<h3>Welcome back " . $_SESSION['CurrentUser'] . ". Privilege level: " . $_SESSION['PrivLevel']. "</h3>";
			echo " <div class='alert alert-warning'>Redirecting to homepage.</div>";
			header("Refresh: 1; url=homepage.php");
		} else {
			echo "<div class='alert alert-warning'>You have not logged in. Something's wrong if you have logged in and still see this page.</div>";
		}
		

    }
//	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
?>
