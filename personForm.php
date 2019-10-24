<?php 
if (! isset($_SESSION)) {
    session_start();
}
if (! isset($_SESSION["MTR-SESSION-ID"])) {
    header('Location: login.php');
    exit();
}
require 'meeter.php';  //this is used for the config of meeter app for client
require 'mtrAOS.php';

// need to get the configuration settings from the database
$mtrConfig->getLatestConfig();   //meeeter.php
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
		<link rel="stylesheet" type="text/css" href="css/jqbase/jquery-ui.theme.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css" />
		
		<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
		<script src="js/jqbase/jquery-ui.js" type="text/javascript"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<script>
          	$( function() {
            	$( "#accordion" ).accordion();
          	} );
      	</script>
		<script type="text/javascript">
			function validateForm(){
				<?php
        			//  every config value that has a label definition must have a value if the associated checkbox is true.
        			// these are the pairs to validate
        			//	cbSetup => tbSetup 
				 
				    // this php section gets the display values and verifies if there is a display label for each checked configuration
				    // 
				    // check each Display value on each stored configuration. If the value is != NOSHOW, then make sure that the 
				    // associated Display value is not blank
				    //====================================================================
    				$aosConfig->loadConfigFromDB();
    				// loop through each AOS value. if it is displayed for people, and check box is CHECKED, then we nned DisplayValue.
				    foreach($aosConfig->AOS as $key => $value){
				        //echo "alert(\"$key\");";
        				echo "if(document.forms[\"adminMtrForm\"][\"cb_$key\"].checked == true){";
        				    if ($aosConfig->canVolunteer($key)){
            				    echo "var val = document.forms[\"adminMtrForm\"][\"tb_$key\"].value;";
            				    echo "if (val.length < 2){";
            				        echo "var msg = \"You need a longer title for the \'$key\' display label.\";";
            				        echo "alert(msg);";
            				        echo "document.getElementById(\"tb_$key\").focus();";
            				        echo "return false;";
            				    echo "}";
            				    echo "if(val == \"NOSHOW\"){";
//             				        echo "alert(\"it is NOSHOW\");";
            				        echo "var msg = \"Your display value for '$key' is unacceptable. Term NOSHOW is a reserved.\";";
            				        echo "alert(msg);";
            				        echo "return false;";
        				        echo "}";
    				        }
    				    //echo "alert(\"it is enabled.\");";
    				    echo "}else{";
    				        //echo "alert(\"it is not enabled\");";
        			     echo "}";
//         			     echo "alert(\"Loop:$key\");";
				    }
// 				    echo "alert(\"done\");";
                ?>
				$( "#dialog-confirm" ).dialog({
					  closeText: "x",
				      resizable: false,
				      height: "auto",
				      width: 400,
				      modal: true,
				      buttons: {
				        "Submit": function() {
				        	document.getElementById("adminMtrForm").submit();
				        },
				        "Cancel": function() {
					          $( this ).dialog( "close" );
				        },
				        "Exit without Saving": function() {
				          $( this ).dialog( "close" );
				          cancelForm();
				        }
				      }
			    });

			}
			function cancelForm(){
				var dest = "adminMain.php";
				window.location.href=dest;
			}
      	</script>
      	
      	
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
				<a class="logo" title="home" href="index.php"><span></span></a>
			</header>
			<div id="navBar"></div>
    		<script>
    			$( "#navBar" ).load( "navbar.php" );
    		</script>
			<article>
				<?php 
				$Action = "New";
				if(isset($_GET["ACTION"])){
				    $Action = $_GET["Action"];
				}
				if ($Action === "Edit"){
				    echo "<form id=\"personForm\" action=\"peepAction.php?Action=UpdatePeep\" method=\"post\">";
				}elseif ($Action === "New"){
				    echo "<form id=\"personForm\" action=\"peepAction.php?Action=AddPeep\" method=\"post\">";
				}
				
				?>
				<H2>Meeter People Definition</H2>
				<div>There are multiple sections for you to manage your personnel</div>
				<div id="accordion">
                  <h3>Contact Information</h3>
                  <div>
                    <p>
                    In this section you can provide basic contact information.
                    </p>
                    <p>
                    <?php 
                        //===========================
                        // get fresh data to begin
                        //===========================
                        $aosConfig->loadConfigFromDB();
                        echo "<div>First Name: <input type=\"text\" name=\"firstName\"></div>";
                        echo "<div>Last Name: <input type=\"text\" name=\"lastName\"><br/></div>";
                        
                        echo "<div>Street: <input type=\"text\" name=\"street\"></div>";
                        echo "<div>City: <input type=\"text\" name=\"city\"></div>";
                        echo "<div>State: <input type=\"text\" name=\"state\"></div>";
                        echo "<div>Zipcode: <input type=\"text\" name=\"postalCode\"><br/></div>";
                        
                        echo "<div>Phone 1 <input type=\"text\" name=\"phone1\"><br/></div>";
                        echo "<div>Phone 2: <input type=\"text\" name=\"phone2\"><br/></div>";
                        echo "<div>Email 1: <input type=\"text\" name=\"email1\"><br/></div>";
                        echo "<div>Email 2: <input type=\"text\" name=\"email2\"><br/></div>";

            		?>
                    </p>
                  </div>
                  <h3>Child Care &amp; Youth</h3>
                  <div>
                    <p>
                    This section relates to the plans for nursery, kids and youth
                    </p>
                    <p>
                    <?php 
                    echo "<div>Spriitual Gifts: <input type=\"text\" name=\"spiritualGifts\"></div>";
                    echo "<div>Recovery Area: <input type=\"text\" name=\"recoveryArea\"></div>";
                    echo "<div>Recovery Date: <input type=\"text\" name=\"recoveryDate\"></div>";
                    echo "<div>CR Since: <input type=\"text\" name=\"CRSince\"><br/></div>";
                    echo "<div>Covenant Date: <input type=\"text\" name=\"covenantDate\"><br/></div>";
                    echo "<div>Areas Served: <textarea id='areasServed' name='areasServed' cols='40' rows='4'></textarea></div>";
                    echo "<div>Joy Areas: <textarea id='joyAreas' name='joyAreas' cols='40' rows='4'></textarea></div>";
                    echo "<div>Reasons to Serve: <textarea id='reasonsToHeal' name='reasonsToServe' cols='40' rows='4'></textarea></div>";
                    ?>
                    </p>
                  </div>
                  <h3>Areas of Service</h3>
                  <div>
                        <p>
                        These are the current areas of service defined for your meeting.
                        </p>
                        <p>
                        <?php 
                        echo "<table>";
                        // loop there on the configs active.
                        
                            echo "</table>";
                        ?>
                        </p>
                  </div>
                  <h3>Training/Leaders Attendance</h3>
                  <div>
                    <p>
                    These are the recorded training sessions and meetings that the resource has attended.
                    </p>
                    <p>
                        <?php 
                        echo "<table>";
                        // LOOP THROUGH PEOPLE ATTENDANCE
                        echo "</table>";
                        ?>
                    </p>
                    
                  </div>

                </div>
              	<p>
                	<input type="button" id="btnCancel" value="Cancel Button"/>&nbsp;&nbsp;
                	<input type="button" id="btnSubmit" value="Commit In"/>
				</p>
                <script type="text/javascript">
                    // POST FORM SCRIPT
                    
                    $( "#btnCancel" ). button({
                        label: "Cancel"
                    });
                    $( "#btnCancel").click(function(){
        				cancelForm();
        			});
                    
                    $( "#btnSubmit" ).button({
        				label: "Save Settings",
                    });
        			$( "#btnSubmit").click(function(){
        				validateForm();
        			});
        			
              </script>
				</form>
			</article>
			<footer>
				&copy; 2013-2018 Rogue Intelligence
			</footer>
		</div>
        <!-- The following div is the dialog that pops prior to submitting form. -->
        <div id="dialog-confirm" title="Configuration Confirmation">
          <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Your changes can impact what is managed for each meetting; what areas people can serve in and what teams are coordintated.<br/>Previous saved values will not be lost.</p>
        </div>
</body>
</html>