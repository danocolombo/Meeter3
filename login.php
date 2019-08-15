<?php
session_start();
require (".auth/mtr-connect.php");
/*
 * =========================================================
 * login.php
 * This file is leveraged from the following example:
 *
 */
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (! empty($_POST["username"]) && ! empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        require_once ('auth/database.php');
	$mh = $_SESSION["MTR-H"];
	$mu = $_SESSION["MTR-U"];
	$mp = $_SESSION["MTR-P"];
	$mn = $_SESSION["MTR-N"];
	$lsqli = new mysqli($mh,$mu,$mp,$mn);
	if (mysqli_connect_errno()) {
	    die(sprintf("[login.php] Connect failed: %s\n", mysqli_connect_error()));
	}

	$sql = "SELECT * FROM users where user_login = '" . $username . "' AND user_password = '" . $password . "'";
	$peep = array();

	$result = $lsqli->query($sql);
	if($result->num_rows < 1){
	    $lsqli->close();
            header('Location: login.php?Error=Incorrect');
	}else{
		while ($row = $result->fetch_array(MYSQLI_ASSOC))
		{
	            $peep[] = array($row['user_id'], $row['user_login'], $row['user_password'],
                        $row['user_firstname'], $row['user_surname'], $row['user_email'],
                        $row['user_registered'], $row['password_reset'], $row['recovery_token'],
                        $row['Admin'], $row['default_client']
                    );
		}
		$lsqli->close();
		//save the values as needed
		$_SESSION["MTR-USER-ID"] = $peep[0][0];
		$_SESSION["MTR-USER-LOGIN"] = $peep[0][1];
		$_SESSION["MTR-USER-FNAME"] = $peep[0][3];
		if($peep[0][9] == "1"){
			$_SESSION["MTR-ADMIN-FLAG"] = true;
		}else{
			$_SESSION["MTR-ADMIN-FLAG"] = false;
		}
		$_SESSION["MTR-CLIENT"] = $peep[0][10];
		//----------------------------------------
		// now set the database to client name
		//----------------------------------------
		$_SESSION["MTR-N"] = $_SESSION["MTR-CLIENT"];
       	 	$session_key = session_id();
	        $_SESSION["MTR-SESSION-ID"] = $session_key;
	
		$lsqli = new mysqli($mh,$mu,$mp,$mn);
		if (mysqli_connect_errno()) {
		    die(sprintf("[login.php] Connect failed: %s\n", mysqli_connect_error()));
		}
        
       		 $query = $lsqli->prepare("INSERT INTO `sessions` ( `user_id`, `session_key`, `session_address`, `session_useragent`, `session_expires`) VALUES ( ?, ?, ?, ?, DATE_ADD(NOW(),INTERVAL 1 HOUR) );");
	        $query->bind_param("isss", $_SESSION["MTR-USER-ID"], $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
       		 $query->execute();
	        $query->close();
	        header('Location: index.php');
	}
   }else{
        header('Location: login.php?Error=Missing');
    }
}else{
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Meeter Web Application</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="meeter.css" />
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script>
	function checkClearance(){
		var uError = decodeURIComponent(getUrlVars()["Error"]);
		if (uError === "Incorrect"){
			alert("Your login attempt was invalid. Either try again or click \"Help\" for assistance");
			return true;
		}else if(uError === "Missing"){
			alert("You need to enter a login and password to access the application.");
			return true;
		}else if(uError == "Invalid"){
			alert("You need to provide proper login definition (acronym\\username)");
			return true;
		}
		return true;
	}
    function getUrlVars() {
    	var vars = {};
    	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    	vars[key] = value;
    	});
    	return vars;
    }
    function getHelp(){
    	var dest = "auth/authHelp.php";
		window.location.href=dest;
		return true;
    }


</script>
</head>
<body onload="checkClearance()">
	<div id="page">
		<!-- [content] -->
		<section id="content">
			<form id="login" method="post">
				<div class="loginBox">
					<fieldset style="width: 200px;">
						<legend>&nbsp;Meeter Web Application&nbsp;</legend>
						<div class="loginText">
							<p>
								<label for="username">Username:</label><input id="username"
									name="username" type="text" required>
							</p>
							<!-- <p>
								<label for="entity">Entity:</label><input id="entity"
									name="entity" type="text" >
							</p>
							-->
							<p>
								<label for="password">Password:</label><input id="password"
									name="password" type="password" required>
							</p>
							<p>
								<input class="greenButton" name="loginBtn" type="submit"
									value="Login">
							</p>
						</div>
						<div style="float: right"><button type='button' id='helpButton' onclick='getHelp()' style='background:red;color:white;'>&nbsp;Help !&nbsp;</button></div>
					</fieldset>
				</div>
			</form>
		</section>
		<!-- [/content] -->
	</div>
</body>
</html>
<?php } ?>

