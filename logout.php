<?php
if(!isset($_SESSION)){
	session_start();
}
include 'mtgRedirects.php';
include 'auth/database.php';
/*
 * logout.php
 */

require_once('auth/database.php');

$query = $connection->prepare("SELECT `session_id`, `user_id` FROM `sessions` WHERE `session_key` = ? AND `session_address` = ? AND `session_useragent` = ? AND `session_expires` > NOW();");
$query->bind_param("sss", $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
$query->execute();
$query->bind_result($session_id, $user_id);
$query->fetch();
$query->close();

date_default_timezone_set("America/New_York");
$when = date("Y-m-d h:i:sa");

/* need the following $link command to use the escape_string function */
//$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
//        OR die(mysql_error());
//$session_key = session_id(); 


//if(empty($session_key))
//{
//    echo "SID: is empty";
//}else{
//    //echo "SID: ".session_id();
//}
//echo "<br/>";
$sql = "UPDATE `sessions` SET `session_expires` = '" . $when . "' WHERE `session_key` = '" . $session_key . "'";

$tmp = "login.php";
executeSQL($sql, $tmp);
//testSQL($sql);
session_destroy();    

function executeSQL($sql,$destination){
    /* 
     * this function executes the sql passed in 
     */
   
    $con=mysqli_connect($_SESSION["MTR-H"],$_SESSION["MTR-U"],$_SESSION["MTR-P"],$_SESSION["MTR-N"]);
    // Check connection
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysqli_query($con,$sql);

    mysqli_close($con);
    
    destination(307, $destination);
    
}


function testSQL($sql){
    /* 
     * this function executes the sql passed in 
     */
   echo "SQL: " . $sql;
}
?>
