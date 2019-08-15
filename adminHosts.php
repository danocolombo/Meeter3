<?php 
session_start();
require_once('authenticate.php'); /* this is used for security purposes */
require 'meeter.php';
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
		
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script>
			function addHost(){
				var PID = $("#candidates").val();
				var dest = "adminHostsAction.php?Action=AddHost&PID=" + PID;
alert(dest);
// 				document.getElementById("addHostForm").action = dest;
// 				window.location.href=dest;
// 				document.getElementById("addHostForm").action = updateAction;
				document.getElementById("addHostForm").submit();
				return true;
			}
        </script>
		
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
				<a class="logo" title="Host Definitions" href="index.php"></a>
			</header>
			<div id="navBar"></div>
    		<script>
    			$( "#navBar" ).load( "navbar.php" );
    		</script>
			<article>
			
			<div>This administration setting is to identify who can be a host of a meeting.<br/>
			</div>
			<div id="confirmedHosts"></div>
			<script>
    			$(document).ready(function(){
        			var theUrl = 'http://rogueintel.org/mapi/public/index.php/api/client/getAdminCandidates/uat';
//     				var theUrl = 'http://recovery.help/meeter/api/json/hosts/getHosts.php?client=UAT';
        				var output = '';
            			$.ajax({
            				url: theUrl,
            				dataType: 'json',
            				type: 'get',
            				cache: false,
            				success: function(hosts) {
                				//now loop through all the individuals that are 
            					$(hosts.hosts).each(function(index, value){
									//output += '<tr><td style=\'padding: 5px\'>';
									output += value.FName + " " + value.LName;
									output += "&nbsp;&nbsp;";
									output += "<a href=\'adminHostsAction.php?Action=removeHost&ID=" + value.ID + "\'><font style='font-family:tahoma; font-size:10pt; font-color:red'>[ REMOVE ]</font></a><br/>";
									
        					});
        					output += '</table>';
        					$('#confirmedHosts').append(output);
    					}    					
        			});
    			});
			</script>	
			<div><br/>The following people can be added to host a meeting.</div>
			<form id="addHostForm" action="adminHostsAction.php" method="get">
			<input type="hidden" id="Action" name="Action" value="addHost">
			<div id="potentialHosts"></div>
			
			<select id="candidate" name="candidates"></select>
			<script>
    			$(document).ready(function(){
    				var theUrl = 'http://recovery.help/meeter/api/json/hosts/getHostCandidates.php?client=UAT';
        				var output = '';
            			$.ajax({
            				url: theUrl,
            				dataType: 'json',
            				type: 'get',
            				cache: false,
            				success: function(hosts) {
//                 				output += '<table border=1><tr><th>ID</th><th>Name</th></tr>';
            					$(hosts.hosts).each(function(index, value){
									output += '<option value=\"';
									output += value.ID;
									output += '\">';
									output += value.FName + " " + value.LName;
    								output += '</option>';
    
        					});
        					output += '</select>';
        					$('#candidate').append(output);
    					}    					
        			});
    			});
			</script>
			&nbsp;&nbsp;
			<button style="font-family:tahoma; font-size:10pt; color:white; background:green; padding: 2px 15px 2px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);" type="submit" >ADD</button>	
			</form>
			</article>
			<div id="mtrFooter"></div>
			<script>
			     $( "#mtrFooter" ).load( "footer.php" );
    		</script>
		</div>
    </body>
</html>