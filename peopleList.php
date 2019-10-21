<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION["MTR-SESSION-ID"])){
    header('Location: login.php');
    exit();
}
// include 'meeter.php';
// include 'peopleAOS.php';
// include 'mtrAOS.php';
// include 'people.inc.php';

//global $person;
//$person = new MeeterPeep();     //meeter.php
//header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//require_once('authenticate.php'); /* for security purposes */
//include 'meeterRedirects.php';
//include 'database.php';
/*
 * Meeter - people.php
 * ======================================================
 */

/********************************************
 * require_once("classPage.php");
 * $page = new Page();
 * print $page->getTop();
 *******************************************/
// if(isset($_GET["ACTION"])){
//     $Action = $_GET["Action"];
// }
// $Destination = $_GET["Destination"];
// $Origin = $_GET["Origin"];
// $ID = $_GET["ID"];
// $PID = $_GET["PID"];
/*************************************************
 * if new or edit a person we need the following
 * loaded for use. It is up here because we need
 * to load special javascript in the header
 *************************************************/
// if ($Action == "New" || $Action == "Edit" || $Action == "NewPeep"){
    //loads the user information;
//     global $person;
//     $person->getPerson($PID);
    
//     //loads the system configuration
//     global $sAOS;
//     $sAOS = new mConfig();
//     $sAOS->loadConfigFromDB();
    
//     global $peepAOS;
//     $peepAOS= new pConfig();
//     $peepAOS->loadDisplayAOS($PID);
// }

/******************************************************************
 * new meeter header
 ***************************************************************** */

//   _____ _______       _____ _______   ____   ____  _______     __
//  / ____|__   __|/\   |  __ \__   __| |  _ \ / __ \|  __ \ \   / /
// | (___    | |  /  \  | |__) | | |    | |_) | |  | | |  | \ \_/ /
//  \___ \   | | / /\ \ |  _  /  | |    |  _ <| |  | | |  | |\   /
//  ____) |  | |/ ____ \| | \ \  | |    | |_) | |__| | |__| | | |
// |_____/   |_/_/    \_\_|  \_\ |_|    |____/ \____/|_____/  |_|


?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
<title>Meeter Web Application</title>
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css"
	href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:50px) and (max-width:500px)"
	href="css/screen_layout_small.css">
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="css/screen_layout_medium.css">
<!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>
<body>
	<div class="page">
		<header>
			<div id="hero"></div>
			<a class="logo" title="home" href="index.php"><span></span></a>
		</header>
		<div id="navBar">
			<script>
                        <?php
                        if ($_SESSION["MTR-ADMIN-FLAG"] == "1") {
                            echo "$( \"#navBar\" ).load( \"navbarA.php\" );";
                        } else {
                            echo "$( \"#navBar\" ).load( \"navbar.php\" );";
                        }
                        ?>

                     </script>
		</div>
		<article>
<?php 

/*####################################################
 * START MAIN PROCESSING
 * ###################################################
 */
$Action = "";
if(isset($_GET["Action"])){
   $Action = $_GET["Action"];
}
// if(isset($_GET["PID"])){
//     $PID = $_GET["PID"];
// }

switch ("$Action"){     
    case "ShowAll":
        /*==================================================
         * show all active and non-active people in system
         * =================================================
         */
        showAllPeople();
        break;
    
    default:
        showPeopleList();
        break;
}

/************************************************
 * end the page definition, now close window
 ***********************************************/
?>
	</article>
		<footer> &copy; 2013-2020 Rogue Intelligence </footer>
	</div>
	<script src="js/meeter.js"></script>
</body>
</html>

<?php 
/*************************************************
 * END OF HTML OUTPUT
**************************************************/
/*************************************************
 * functions for processing below
*************************************************/
function showPeopleList() {
   //------------------------------
    // dislay list of active personnel for client$client = $_SESSION["MTR-CLIENT"];
    
    $listUrl = "http://rogueintel.org/mapi/public/index.php/api/people/getActivePersonnelList/" . $_SESSION["MTR-CLIENT"];
    $data = file_get_contents($listUrl);
    $listArray = json_decode($data, true);
    if (sizeof($listArray) < 1) {
        echo "No personnel found, contact your administrator";
        exit();
    }
    echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
    echo "<div style='padding-left: 70px;'><h2>People List</h2></div>";
    echo "<div style='padding-left:20px;'>";
    echo "<table>";
    foreach($listArray as $person){
        echo "<tr><td>";
        echo "<a href='people.php?Action=Edit&PID=" . $person["ID"] . "'><img src='images/btnEdit.gif'></img></a></td>";
        echo "<td>&nbsp;" . $person["FName"] . " " . $person["LName"] . "</td></tr>";
    }
    echo "</table>";
    echo "</div>";
    
//     while(list($ID, $FName, $LName) = $result->fetch_row()){
//         echo "<tr><td>";
//         echo "<a href='people.php?Action=Edit&PID=" . $ID . "'><img src='images/btnEdit.gif'></img></a></td>";
//         echo "<td>&nbsp;" . $FName . " " . $LName . "</td></tr>";
//     }
//     echo "</table>";
    
//     $meeting = $meetingArray[0];
    
    
    
    
    
    
    
//     include 'auth/database.php';
//    echo "<center><h1>CR Personnel</h1>";

//    if($connection->errno > 0){
//        printf("Mysql error number generated: %d", $connection->errno);
//        exit();
//    }
//    $query = "SELECT * FROM people WHERE Active = '1' order by FName";
//    $result = $connection->query($query, MYSQLI_STORE_RESULT);
//    //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewPeep'>NEW ENTRY</a></div>";
//    echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
//    echo "<table>";
//    while(list($ID, $FName, $LName) = $result->fetch_row()){
//            echo "<tr><td>";
//            echo "<a href='people.php?Action=Edit&PID=" . $ID . "'><img src='images/btnEdit.gif'></img></a></td>";
//            echo "<td>&nbsp;" . $FName . " " . $LName . "</td></tr>";
//    }
//    echo "</table>";
   
}
function showAllPeople() {
   include 'auth/database.php';
   echo "<center><h1>CR Personnel</h1>";

   if($connection->errno > 0){
       printf("Mysql error number generated: %d", $connection->errno);
       exit();
   }
   $query = "SELECT ID, FName, LName, Active FROM people order by FName";
   $result = $connection->query($query, MYSQLI_STORE_RESULT);
   echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=NewPeep'>NEW ENTRY</a></div>";
   //echo "<div style='text-align:right; padding-right: 20px;'><a href='people.php?Action=ShowAll'><img src='images/btnShowAll.gif'/></a></div>";
   echo "<table>";
   while(list($ID, $FName, $LName, $Active) = $result->fetch_row()){
           echo "<tr><td valign='bottom'>";
           echo "<a href='people.php?Action=Edit&PID=" . $ID . "'><img src='images/btnEdit.gif'></img></a></td>";
           echo "<td valign='bottom'>" . $FName . " " . $LName . " ";
           if ($Active == '0'){
               echo "<a href=peepAction.php?Action=Activate&ID=" . $ID . "'><img src='images/btnInActive.gif' height='20' valign='bottom'/></a>";
           }
                   
                   
                   "</td></tr>";
   }
   echo "</table>";
   
}

?>
