<?php 
if(!isset($_SESSION)){
	session_start();
}
if(!isset($_SESSION["MTR-SESSION-ID"])){
	header('Location: login.php');
	exit();
}

//require_once('authenticate.php'); /* this is used for security purposes */
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
	<title>Meeter Web Application</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
      	
    <script
    	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript"
    	src="js/farinspace/jquery.imgpreload.min.js"></script>
    <script type="text/javascript" src="js/design.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
            
		
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
				<a class="logo" title="home" href="index.php"><span></span></a>
			</header>
			<div id="navBar"></div>
    		<script>
    			$( "#navBar" ).load( "navbarA.php" );
    		</script>
			<article>
			<div class="container">
				<div class="col-sm-2 col-md-2 col-lg-2" style="padding-left:25px; padding-right:25px;">
              		<button type="button" class="btn btn-default" style="background-color:blue; color:white; padding:0 10 0 10; onclick="window.location.href='adminHosts.php'"">Hosts</button>
          		</div>
          		<div class="col-sm-4 col-md-4 col-lg-4" style="padding-left:25px; padding-right:25px;">
              		<button type="button" class="btn btn-default" style="background-color:blue; color:white; padding:0 10 0 10;" onclick="window.location.href='adminMeeter.php'">Configuration</button> 
          		</div> 
            </div>
			
			<!--  
			
			<div class="col-sm-6 col-md-6 col-lg-6" style="padding-left:25px; padding-right:25px;">
			<button style="font-family:tahoma; font-size:12pt; color:white; background:green; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);" type="button" onclick="window.location.href='adminHosts.php'">Hosts</button>
		    </div>
		    <div class="col-sm-6 col-md-6 col-lg-6" style="padding-left:25px; padding-right:25px;">
		    <button style="font-family:tahoma; font-size:12pt; color:white; background:red; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #cc0000, #ff3300);" type="button" onclick="window.location.href='adminMeeter.php'">Configuration</button>
			
			</div>
			-->
			<br/><br/>
			</article>
			<div id="mtrFooter">
			<script>$("#mtrFooter").load("footer.php");</script>
			</div>
		</div>
    </body>
</html>
