<?php
if (! isset($_SESSION)) {
    session_start();
}
if (! isset($_SESSION["MTR-SESSION-ID"])) {
    header('Location: login.php');
    exit();
}
// WE THINK WE CAN OMIT THE NEXT LINE BECAUSE WE GET MEETING FROM MAPI
// require 'meeter.php';

require 'mtrAOS.php';
$aosConfig = new mConfig();
// require 'meeter.php';  //this is used for the config of meeter app for client

// require 'includes/database.inc.php';
//still need the meeting.inc.php file to parse out the "hosts"...
require 'meeting.inc.php';
// require 'peopleAOS.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// include 'database.php';
// ---------------------------------------------------
// mtgFormNew
// this is used to dispay a form for a new meeting
// ---------------------------------------------------
$client = $_SESSION["MTR-CLIENT"];

/*
 * --------------------------------------------------------
 * load the system configuration and possible assignees
 * ---------------------------------------------------------
 */
// $peepConfig = new pConfig();
// $peepConfig->loadCommitTableWithAllPeople();
// ----------------------------------------------------------
// the following command loads at temp table with peopel to use
// ------------------------------------------------------------
loadCommitTableWithAllPeople();
//

// ===================================================================
// set up database connection to be used the remainder of the way
// ===================================================================
require_once ('auth/database.php');
//
// $_gid = getGhostID();
$cn = mysqli_connect($_SESSION["MTR-H"], $_SESSION["MTR-U"], $_SESSION["MTR-P"], $_SESSION["MTR-N"]);

// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
// getGhostID
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
$result = mysqli_query($cn, "Call ccc.getGhostID") or die("Stored proc[getGhostID]: fail:" . mysqli_error());
if (! isset($result)) {
    echo "NO GHOST ID, contact your support team";
    exit();
}
while ($row = mysqli_fetch_array($result)) {
    $_gid = $row[0];
}
// need to tidy up before calling next proc
$result->close();
$cn->next_result();
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
// getGhostLabel
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
$result = mysqli_query($cn, "Call ccc.getGhostLabel") or die("Stored proc[getGhostLabel]: fail:" . mysqli_error());
if (! isset($result)) {
    echo "NO GHOST LABEL, contact your support team";
    exit();
}
while ($row = mysqli_fetch_array($result)) {
    $_glabel = $row[0];
}
$_SESSION["MTR-GHOST_ID"] = $_gid;
// need to tidy up before calling next proc
$result->close();
$cn->next_result();
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
// getNonPersonWorshipID
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
$result = mysqli_query($cn, "Call ccc.getNonPersonWorshipID") or die("Stored proc[getNonPersonWorhipID]: fail:" . mysqli_error());
if (! isset($result)) {
    echo "NO NON-PERSON WORSHIP ID, contact your support team";
    exit();
}
while ($row = mysqli_fetch_array($result)) {
    $_npwid = $row[0];
}
// need to tidy up before calling next proc
$result->close();
$cn->next_result();
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
// getNonPersonWorshipLabel
// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
$result = mysqli_query($cn, "Call ccc.getNonPersonWorshipLabel") or die("Stored proc[getNonPersonWorshipLabel]: fail:" . mysqli_error());
if (! isset($result)) {
    echo "NO GHOST LABEL, contact your support team";
    exit();
}
while ($row = mysqli_fetch_array($result)) {
    $_npwlabel = $row[0];
}
// need to tidy up before calling next proc
$result->close();
$cn->close();

// get data
// -----------------------------------------------------
if (isset($_GET["ID"])) {
    $MID = $_GET["ID"];
} else {
    $MID = 0;
}
// load the system configuration settings into object to use.
$aosConfig->loadConfigFromDB();

// =======================================
// load the areas of service into temp table for use in dropdowns
//=======================================
$cn = mysqli_connect($_SESSION["MTR-H"], $_SESSION["MTR-U"], $_SESSION["MTR-P"], $_SESSION["MTR-N"]);
$proc = "Call " . $_SESSION["MTR-CLIENT"] . ".Load_Commit_Table";
$result = mysqli_query($cn, $proc) or die("Stored proc[Load_Commit_Table]: fail:" . mysqli_error());
$result = null;
$cn->close();


// #############################################
// END OF PRE-CONDITIONING
// #############################################

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
<!--  <meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT" /> -->
<!--  <meta http-equiv="pragma" content="no-cache" /> -->
<title>Meeter Web Application</title>
<link rel="stylesheet" type="text/css"
	href="css/vader/jquery-ui-1.8.16.custom.css" />
<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css"
	href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:50px) and (max-width:500px)"
	href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="css/screen_layout_medium.css" />
<!-- <link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="w3.css" /> -->
<!--  <link rel="stylesheet" type="text/css" href="meeter.css" />-->
<!-- 
<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script src="js/jquery/jquery-ui.js" type="text/javascript"></script>
 -->
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="./js/meeter.js"></script>

<!-- Javascript -->
<script>
//            
	function validateMtgForm(){
		// start with validating the date value
		$( "#mtgDate" ).datepicker();
		var tmpString = "";
		var m_Date = $( "#mtgDate" ).datepicker('getDate');
		
		var m_NewDate = $("#mtgDate").datepicker({ dateFormat: 'yyyy,mm,dd'}).val();
		
		if(isValidDate(m_NewDate) == false){
			alert("please select an accurate date");
			$("#mtgDate").datepicker("setDate", new Date());
			$("#mtgDate").datepicker( "show" );
			return false;
		}
		var m_type = $('input[name=rdoMtgType]:checked').attr('id');
		if(m_type == "undefined"){
			alert("Please select the type of meeting you are entering");
			return false;
		}
		switch(m_type){
		case "rdoLesson":
			m_type = "Lesson";
			break;
		case "rdoTestimony":
			m_type = "Testimony";
			break;
		case "rdoSpecial":
			m_type = "Special";
			break;
		default:
			alert("You have to select a Meeting Type.");
			return false;
			break;
		}
		
		if($("#mtgTitle").val().length<3){
			alert("You need to provide a title longer than 2 characters");
			$("#mtgTitle").focus();
			return false;
		}
		// need to ensure that the donations text box is a monetary amount
		var m_donations = $("#mtgDonations").val();
		if ($("#mtgDonations").val().length<1){
			$("#mtgDonations").val("0");
		}else{
			fDonations = +$("#mtgDonations").val();
			if(isNaN(fDonations)){
				tmpString = "You need to enter a numeric value for Donations";
				$("#mtgDonations").val("");
			}
		}
		//get the Meeting ID if set
		//var mtgID = <?php echo json_encode($MID);?>;
		//alert(mtgID);
		//		if(mtgID == null){
		document.getElementById("mtgForm").action = "mtgAction.php?Action=New";
		document.getElementById("mtgForm").submit();
					
// 				}else{
// 					var updateAction = "mtgAction.php?Action=Update&ID=" + mtgID;
// 					document.getElementById("mtgForm").action = updateAction;
// 				}
// 		document.getElementById("mtgForm").submit();

	}
	function cancelMtgForm(){
		var dest = "meetings.php";
		window.location.href=dest;
	}

	function isValidDate(dateString){
		// First check for the pattern
	    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
	        return false;

	    // Parse the date parts to integers
	    var parts = dateString.split("/");
	    var day = parseInt(parts[1], 10);
	    var month = parseInt(parts[0], 10);
	    var year = parseInt(parts[2], 10);

	    // Check the ranges of month and year
	    if(year < 1000 || year > 3000 || month == 0 || month > 12)
	        return false;

	    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

	    // Adjust for leap years
	    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
	        monthLength[1] = 29;

	    // Check the range of the day
	    return day > 0 && day <= monthLength[month - 1];
	}
			
	function importedValidation(){
		// if user is trying to delete system user "Removed User", then echo message that
		// action is not possible. 
		//--------------------------------------------------------------------------------
		var mDate = $("mtgDate").value;
		alert(mDate);
		var FName = document.forms["peepForm"]["peepFName"].value;
		var LName = document.forms["peepForm"]["peepLName"].value;
		if(FName == "Removed" && LName == "User"){
			// user is trying to delete system entry. Post warning and abort
			alert("The entry you are trying to delete is used by the system, and can\'t be removed");
			return false;
		}
		//check if the current user is set to active
		var aFlag = document.getElementById("peepActive").checked;
		if(aFlag == true){
			alert("It is recommended you make the person \'inactive\' rather than deleting.");
			var x = confirm("Press OK if you want to really delete. All references in the system will be lost");
			if (x == true){
				var recordID = getUrlVars()["PID"];
				var newURL = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
// 				window.location.href=newURL;
				$("#mtgForm").submit();
				return true;	
			}else{
				return false;
			}
		}
		var x2 = confirm("Click \'OK\' if you are sure you want to delete this user.");
		if (x2 == true){
			var recordID = getUrlVars()["PID"];
			//alert(recordID);
			//alert("DELETE");
			var dest = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
// 				window.location.href=dest;
// 				$("#mtgForm").submit();
		}else{
			alert("Delete User aborted.");
			return false;
		}
	}
	function getUrlVars() {
	    var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	        vars[key] = value;
	    });
	    return vars;
	}
        </script>
<script src="js/farinspace/jquery.imgpreload.min.js"></script>
<script>
        	$(function() {
                $( "#mtgDate" ).datepicker();
                var daDate = new Date();
                var dsplyDate = stringToDate(daDate,"mm-dd-yyyy", "-");
				$("#mtgDate").datepicker("setDate", dsplyDate);
                
             });
		</script>
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
            <form id="mtgForm" action="mtgAction.php?Action=New" method="post">
            <h2 id="formTitle">New Meeting Entry</h2>
				<table id="formTable">
				<tr>
					<td colspan="2">
						<table>
							<tr>
								<td>Meeting Date:&nbsp;<input type="text" id="mtgDate"
									name="mtgDate"></td>
							</tr>
							<tr>
								<td>
									<fieldset>
										<legend>Meeting Type</legend>
										<label for="rdoLesson">Lesson</label>
                                        <input type="radio" name="rdoMtgType" id="rdoLesson" value="Lesson" >
                                        <label for="rdoTestimony">Testimony</label>
                                        <input type="radio" name="rdoMtgType" id="rdoTestimony" value="Testimony" >
                                        <label for="rdoSpecial">Special</label>
                                        <input type="radio" name="rdoMtgType" id="rdoSpecial" value="Special" >
                                    </fieldset>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
            					<?php
                // BEGINNING TABLE 1
                echo "<table>";
                echo "<tr>";
                echo "<td><div class=\"mtgLabels\" style=\"float:right\">Title:&nbsp;</div></td>";
                echo "<td><input id=\"mtgTitle\" name=\"mtgTitle\" size=\"40\" style=\"font-size:14pt;\" type=\"text\" value='New Meeting'/></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><div class=\"mtgLabels\" style=\"float:right\">Host:</div></td>";
                echo "<td><select id=\"mtgCoordinator\" name=\"mtgCoordinator\">";
                $option = getHostsForMeeting();
                foreach ($option as $id => $name) {
                    echo "<option value=\"$id\">$name</option>";
                }
                // add the ghost to the bottom
                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                echo "</select>";
                echo "<a href=\"#\" title=\"Individuals defined as Hosts in Admin features.\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><div class=\"mtgLabels\" style=\"float:right\">Attendance:</div></td>";
                echo "<td><select id=\"mtgAttendance\" name=\"mtgAttendance\">";
                for ($a = 0; $a < 201; $a ++) {
                      echo "<option value=\"" . $a . "\">" . $a . "</option>";
                }
                echo "</select>";
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><div class=\"mtgLabels\" style=\"float:right\">Donations:</div></td>";
                echo "<td><input id=\"mtgDonations\" name=\"mtgDonations\" size=\"6\" type=\"text\" value='0'/></td>";
                echo "</tr>";
                if ($aosConfig->getConfig("worship") == "true") {
                    // ================================
                    // WORSHIP IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("worship") . ":</div></td>";
                    echo "<td><select id=\"mtgWorship\" name=\"mtgWorship\">";
                    
                    //call function in meeting.in.php to get the people for service.
                    $option = getPeepsForService("worship");
                    
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost AND non-person to the bottom
                    echo "<option value=\"$_npwid\" SELECTED>$_npwlabel</option>";
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
//                     echo "<a href=\"#\" title=\"People on Worship team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a></td></tr>";
//                     echo "<tr><td colspan=2>";
//                     print_r($option);
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("av") == "true") {
                    // ================================
                    // AV IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("av") . ":</div></td>";
                    echo "<td><select id=\"mtgAV\" name=\"mtgAV\">";
                    $option = getPeepsForService("av");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\"  title=\"People on A/V team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("setup") == "true") {
                    // ================================
                    // setup IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("setup") . ":</div></td>";
                    echo "<td><select id=\"mtgSetup\" name=\"mtgSetup\">";
                    $option = getPeepsForService("setup");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on setup team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("transportation") == "true") {
                    // ================================
                    // transportation IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("transportation") . ":</div></td>";
                    echo "<td><select id=\"mtgTransportation\" name=\"mtgTransportation\">";
                    $option = getPeepsForService("transportation");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on transportation team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("greeter") == "true") {
                    // ================================
                    // GREETER IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("greeter") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgGreeter1\" name=\"mtgGreeter1\">";
                    $option = getPeepsForService("greeter");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<select id=\"mtgGreeter2\" name=\"mtgGreeter2\">";
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Greeting team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("resources") == "true") {
                    // ================================
                    // resources IS TRUE = DISPLAY OPTION
                    // ================================
                    // echo "<tr><td width=\"150px\" align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("resources") . ":</div></td>";
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("resources") . ":</div></td>";
                    echo "<td><select id=\"mtgResources\" name=\"mtgResources\">";
                    $option = getPeepsForService("resources");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on resource team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                } // this ends the if statement for RESOURCES

                // echo "</td></tr>";
                echo "</table>";
                // END OF TABLE 1

                // BEGINNING of TABLE 2 (DINNER)
                if ($aosConfig->getConfig("meal") == "true") {
                    // the configuration is to manage/track the meal
                    // echo "<table><tr><td width=\"100px;\">&nbsp;</td><td>";
                    echo "<table><tr><td>";
                    echo "<fieldset><legend>Meal</legend>";
                    echo "<table>";
                    if ($aosConfig->getConfig("menu") == "true") {
                        echo "<tr><td colspan=4><div class=\"mtgLabels\" style=\"float:left\">Menu:&nbsp;";
                        echo "<input id=\"mtgMenu\" name=\"mtgMenu\" size=\"32\" maxlength=\"30\" style=\"font-size:14pt;\" type=\"text\"/></div></td></tr>";
                    }
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Served:&nbsp;</div></td>";
                    echo "<td><select id=\"mtgMealCnt\" name=\"mtgMealCnt\">";
                    for ($a = 0; $a < 201; $a ++) {
                        echo "<option value=\"" . $a . "\">" . $a . "</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    if ($aosConfig->getConfig("mealFac") == "true") {
                        echo "<td>" . $aosConfig->getDisplayString("mealFac") . "&nbsp;<select id=\"mtgMealFac\" name=\"mtgMealFac\">";
                        $option = getPeepsForService("mealFac");
                        foreach ($option as $id => $name) {
                            echo "<option value=\"$id\">$name</option>";
                        }
                        // add the ghost to the bottom
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        echo "</select>";
                    } else {
                        echo "<td>";
                    }
                    echo "</td></tr></table>";
                    echo "</fieldset>";
                    echo "</td></tr></table>";
                } // END OF TABLE 2 (DINNER)

                // BEGINNING TABLE 3
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                if ($aosConfig->getConfig("reader") == "true") {
                    // ================================
                    // READERS IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("reader") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgReader1\" name=\"mtgReader1\">";
                    $option = getPeepsForService("reader");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<select id=\"mtgReader2\" name=\"mtgReader2\">";
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Reader team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("announcements") == "true") {
                    // ================================
                    // ANNOUNCEMENTS IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("announcements") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgAnnouncements\" name=\"mtgAnnouncements\">";
                    $option = getPeepsForService("announcements");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Announcement team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("teaching") == "true") {
                    // ================================
                    // TEACHING IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("teaching") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgTeaching\" name=\"mtgTeaching\">";
                    $option = getPeepsForService("teaching");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Teaching team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("chips") == "true") {
                    // ================================
                    // CHIPS IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("chips") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgChips1\" name=\"mtgChips1\">";
                    $option = getPeepsForService("chips");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<select id=\"mtgChips2\" name=\"mtgChips2\">";
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Chips team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("newcomers") == "true") {
                    // ================================
                    // NEWCOMERS (101) IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("newcomers") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgNewcomers1\" name=\"mtgNewcomers1\">";
                    $option = getPeepsForService("newcomers");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<select id=\"mtgNewcomers2\" name=\"mtgNewcomers2\">";
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Newcomers (101) team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("serenity") == "true") {
                    // ================================
                    // SERENITY IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("serenity") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgSerenity\" name=\"mtgSerenity\">";
                    $option = getPeepsForService("serenity");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Serenity Prayer team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }

                echo "</table>";

                // BEGINNING of TABLE 4 (GENERATIONS)
                if ($aosConfig->getConfig("youth") == "true" || $aosConfig->getConfig("children") == "true" || $aosConfig->getConfig("nursery") == "true") {
                    // if any of the generations is enabled, display the table

                    echo "<table><tr><td>";
                    echo "<fieldset><legend>Generations</legend>";
                    echo "<table>";
                    if ($aosConfig->getConfig("nursery") == "true") {
                        echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Nursery:&nbsp;</div></td>";
                        echo "<td><select id=\"mtgNursery\" name=\"mtgNursery\">";
                        for ($a = 0; $a < 201; $a ++) {
                            echo "<option value=\"" . $a . "\">" . $a . "</option>";
                        }
                        echo "</select>";
                        echo "</td>";
                        if ($aosConfig->getConfig("nurseryFac") == "true") {
                            echo "<td>" . $aosConfig->getDisplayString("nurseryFac") . "</td><td><select id=\"mtgNurseryFac\" name=\"mtgNurseryFac\">";
                            $option = getPeepsForService("nursery");
                            foreach ($option as $id => $name) {
                                echo "<option value=\"$id\">$name</option>";
                            }
                            // add the ghost to the bottom
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    if ($aosConfig->getConfig("children") == "true") {
                        echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Children:&nbsp;</div></td>";
                        echo "<td><select id=\"mtgChildren\" name=\"mtgChildren\">";
                        for ($a = 0; $a < 201; $a ++) {
                            echo "<option value=\"" . $a . "\">" . $a . "</option>";
                        }
                        echo "</select>";
                        echo "</td>";
                        if ($aosConfig->getConfig("childrenFac") == "true") {
                            echo "<td>" . $aosConfig->getDisplayString("childrenFac") . "</td><td><select id=\"mtgChildrenFac\" name=\"mtgChildrenFac\">";
                            $option = getPeepsForService("children");
                            foreach ($option as $id => $name) {
                                echo "<option value=\"$id\">$name</option>";
                            }
                            // add the ghost to the bottom
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    if ($aosConfig->getConfig("youth") == "true") {
                        echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Youth:&nbsp;</div></td>";
                        echo "<td><select id=\"mtgYouth\" name=\"mtgYouth\">";
                        for ($a = 0; $a < 201; $a ++) {
                            echo "<option value=\"" . $a . "\">" . $a . "</option>";
                        }
                        echo "</select>";
                        echo "</td>";
                        if ($aosConfig->getConfig("youthFac") == "true") {
                            echo "<td>" . $aosConfig->getDisplayString("youthFac") . "</td><td><select id=\"mtgYouthFac\" name=\"mtgYouthFac\">";
                            $option = getPeepsForService("youth");
                            foreach ($option as $id => $name) {
                                echo "<option value=\"$id\">$name</option>";
                            }
                            // add the ghost to the bottom
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</fieldset>";
                    echo "</td><tr></table>";
                } // END OF TABLE 4 (GENERATIONS)
                  // BEGINNING TABLE 5
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                if ($aosConfig->getConfig("cafe") == "true") {
                    // ================================
                    // CAFE IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("cafe") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgCafe\" name=\"mtgCafe\">";
                    $option = getPeepsForService("cafe");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Cafe team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($aosConfig->getConfig("teardown") == "true") {
                    // ================================
                    // TEARDOWN IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("teardown") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgTearDown\" name=\"mtgTearDown\">";
                    $option = getPeepsForService("teardown");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Tear-Down team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }

                if ($aosConfig->getConfig("security") == "true") {
                    // ================================
                    // SECURITY IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("security") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgSecurity\" name=\"mtgSecurity\">";
                    $option = getPeepsForService("security");
                    foreach ($option as $id => $name) {
                        echo "<option value=\"$id\">$name</option>";
                    }
                    // add the ghost to the bottom
                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Security team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                echo "</table>";
                ?>
							</td>
				</tr>
				<tr>
					<td colspan="2">
						<fieldset>
							<legend>Notes and Comments</legend>
                              	<?php
                                echo "<textarea id=\"mtgNotes\" name=\"mtgNotes\"  rows=\"5\" cols=\"80\"></textarea>";
                                ?>
                        	</fieldset>
					</td>
				</tr>
				<tr>
					<td colspan="2"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
    if ($_SESSION["MTR-ADMIN-FLAG"] == "1") {
        if ($MID > 0) {
            // display update button, otherwise insert
            echo "<button style=\"font-family:tahoma; font-size:12pt; color:white; background:green; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);\" type=\"button\" onclick=\"validateMtgForm()\">UPDATE</button>";
        } else {
            echo "<button style=\"font-family:tahoma; font-size:12pt; color:white; background:green; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);\" type=\"button\" onclick=\"validateMtgForm()\">INSERT</button>";
        }
    }
    ?>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button
							style="font-family: tahoma; font-size: 12pt; color: white; background: green; padding: 5px 15px 5px 15px; border-radius: 10px; background-image: linear-gradient(to bottom right, #cc0000, #ff3300);"
							type="button" onclick="cancelMtgForm()">CANCEL</button> <br />
					<br /></td>
				</tr>

			</table>
			
			</form>

		</article>
		<div id="footerArea"></div>
		<script>
			$( "#footerArea" ).load( "footer.php" );
		</script>
	</div>

</body>
</html>
