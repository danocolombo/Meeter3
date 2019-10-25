<?php
if(!isset($_SESSION)){
	session_start();
}
if(!isset($_SESSION["MTR-SESSION-ID"])){
	header('Location: login.php?Error=Incorrect');	
	exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
    <title>Meeter Web Application</title>

<!--  
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css"
	href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:50px) and (max-width:500px)"
	href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="css/screen_layout_medium.css" />
-->	
	
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

<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
<body>
	<div class="page">
		<header>
			<!--<div id="hero"></div>-->
			<a class="logo" title="home" href="index.php"><span></span></a>
		</header>
		<div id="navBar"></div>
		<script>
			<?php 
			if($_SESSION["MTR-ADMIN-FLAG"] == "1"){
			    echo "$( \"#navBar\" ).load( \"navbarA.php\" );";
			}else{
			    echo "$( \"#navBar\" ).load( \"navbar.php\" );";
			}
			?>
		</script>
		<!-- <article>  -->
		<div class="container-fluid">
			<img class="img-responsive" src="images/cr_splash_590x250.jpg" alt="Chania" width="590" height="250"><br />
			<div class="row">
			<div class="col-sm-6 col-md-6 col-lg-6" style="padding-left:25px; padding-right:25px;">
			This web application is designed explicitly for your Celebrate Recovery ministry. For further information regarding this site or its contents please contact <a href='mailto:danocolombo@gmail.com'>Dano</a>
			</div>
			</div>	
			<div class="row">
			<div class="col-sm-6 col-md-6 col-lg-6" style="padding-left:50px; padding-right:30px;">
			<div style="float:right">
				<?php echo $_SESSION["MTR-USER-LOGIN"] . ":" . $_SESSION["MTR-CLIENT"] . ":" . $_SESSION["MTR-ADMIN-FLAG"]; ?>
			</div>
			</div>
			</div>
			<!--  </article>  -->
		    <div id="mtrFooter">
			<script>$("#mtrFooter").load("footer.php");</script>
			</div>
		</div> 
		
	</div>
</body>
</html>
