<?php
if(!isset($_SESSION)){
	session_start();
}
require_once('authenticate.php'); /* used for security purposes */
include 'auth/database.php';
//require_once 'HTML/Table.php';
/*
 * meetings.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 *****************************************************************/
/***
 * require_once("classPage.php");
 * $page = new Page();
 * print $page->getTop();
 * 
 */
/******************************************************************
 * new meeter header
***************************************************************** */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
        <link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
        <link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css">
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css">
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>
    <body>
		<div class="page">
			<header>
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
			<article>
<?php 
    /**********************************
     * finish generic header above
     **********************************/
	$client = $_SESSION["MTR-CLIENT"];
	if(isset($_GET['PAST'])){
	    echo "<div style=\"padding-top:25px; padding-bottom:0px;\"><center><h1>Past Meetings</h1></center><div>";
	    echo "<div style=\"float:right; padding-right:25px;\"><a href='meetings.php'>mtg plans</a></div>";
	    $url = "http://rogueintel.org/mapi/public/index.php/api/meetings/getHistory/" . $client;
	}else{
	    echo "<div style=\"padding-top:25px; padding-bottom:0px;\"><center><h1>Future Meetings</h1></center></div>";
	    echo "<div style=\"float:right; padding-right:25px;\"><a href='meetings.php?PAST=1'>mtg history</a></div>";
	    $url = "http://rogueintel.org/mapi/public/index.php/api/meetings/getFuture/" . $client;
	}
echo "URL: " . $url . "<br/>";
	$data  = file_get_contents($url); // put the contents of the file into a variable
	$meetings = json_decode($data); // decode the JSON feed

	// if we got some meetings back, display, if not provide notificaiton
	if (sizeof($meetings) < 1)
	{
	    echo "There are no meetings to display in this view\n";
	}else{
	    //display the table of meetings
    	    echo "<table border=1 align=\"center\">";
	    echo "<tr><td class=\"meetingTableHeader\">Date</td>";
	    echo "<td class=\"meetingTableHeader\">#</td>";
	    echo "<td class=\"meetingTableHeader\">Type</td>";
	    echo "<td class=\"meetingTableHeader\">Title</td>";
	    echo "<td class=\"meetingTableHeader\">Leader</td>";
	    echo "<td class=\"meetingTableHeader\">Worship</td></tr>";
	    foreach ($meetings as $meeting) {
	        echo "<tr><td class=\"meetingTable\"><a href=\"mtgForm.php?ID=" . $meeting->meetingID . "\">" . $meeting->meetingDate . "</a></td>";
	        echo "<td class=\"meetingTable\" align=\"center\">" . $meeting->meetingAttendance . "</td>";
	        echo "<td class=\"meetingTable\">" . $meeting->meetingType . "</td>";
	        echo "<td class=\"meetingTable\">" . $meeting->meetingTitle . "</td>";
	        echo "<td class=\"meetingTable\">" . $meeting->meetingFacilitator . "</td>";
	        echo "<td class=\"meetingTable\">" . $meeting->worship . "</td></tr>";
	    }
	    echo "</table>";
	    echo "<div style=\"padding-top:20px; padding-bottom:20px;\"><center>There were " . sizeof($meetings) . " meetings found.</center></div>";
	}

    /************************************************
     * end the page definition, now close window
     ***********************************************/
    ?>
	</article>
	<footer>
		&copy; 2013-2018 Rogue Intelligence
	</footer>
</div>
</body>
</html>
