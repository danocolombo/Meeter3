<?php
if(!isset($_SESSION)){
	session_start();
}
global $connection;
/*-----------------
 * database.php
 * ========================================
 * This is authentication method learned from
 * http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-–-part-3/
 * 
 */
if ( isset( $connection ) )
	return;
mysqli_report(MYSQLI_REPORT_STRICT);

$mysqli = new mysqli($_SESSION["MTR-H"],$_SESSION["MTR-U"],$_SESSION["MTR-P"],$_SESSION["MTR-N"]);
$connection = new mysqli($_SESSION["MTR-H"],$_SESSION["MTR-U"],$_SESSION["MTR-P"],$_SESSION["MTR-N"]);

if (mysqli_connect_errno()) {		
	die(sprintf("[database.php] Connect failed: %s\n", mysqli_connect_error()));
}
?>
