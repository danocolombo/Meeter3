<?php
if(!isset($_SESSION)){
        session_start();
}
if(!isset($_SESSION["MTR-SESSION-ID"])){
        header('Location: login.php');
        exit();
}
/******************************************************************
 * new meeter2 
***************************************************************** */
$client = $_SESSION["MTR-CLIENT"];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
        <!--  
        <link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
        <link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css">
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css">
        -->
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->
        <!--
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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
    if (isset($_GET["PAST"])){
        echo "<center><h1>Past Meetings</h1>";
    }else{
        echo "<center><h1>Future Meetings</h1>";
    }
    
   require_once ('auth/database.php');
   $mh = $_SESSION["MTR-H"];
   $mu = $_SESSION["MTR-U"];
   $mp = $_SESSION["MTR-P"];
   $mn = $_SESSION["MTR-N"];
   $lsqli = new mysqli($mh,$mu,$mp,$mn); 
    if($lsqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    date_default_timezone_set("America/New_York");
    $tmpToday = date("Y-m-d");
    if (isset($_GET["PAST"])){
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
	    w.fName wNA, m.MtgAttendance aTT from " . $client . ".meetings m, " . $client . ".people p, "
	    . $client . ".people w where m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate <= '" 
	    . $tmpToday . "' ORDER BY m.MtgDate DESC";
   
    }else{
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from " . $client . ".meetings m, " . $client . ".people p, " . $client . ".people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate >= '" . $tmpToday . "' ORDER BY m.MtgDate ASC";
    }
    $meetings = array();
    $result = $lsqli->query($sql);
    
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $meetings[] = array($row['iD'], $row['dAT'], $row['tYP'], $row['tIT'], $row['pNA'], $row['wNA'], $row['aTT']);
        
    }
    
    for($cnt=0;$cnt<$result->num_rows;$cnt++){
        $mtg[$cnt][0] = "&nbsp;<a href='mtgForm.php?ID=" . $meetings[$cnt][0] . "'>&nbsp;" . $meetings[$cnt][1] . "</a>&nbsp;"; /* Date */
        $mtg[$cnt][1] = "&nbsp;" . $meetings[$cnt][6] . "&nbsp;"; /* Attendance */
        $mtg[$cnt][2] = "&nbsp;" . $meetings[$cnt][2] . "&nbsp;"; /* Type */
        $mtg[$cnt][3] = "&nbsp;" . $meetings[$cnt][3] . "&nbsp;"; /* Title */
        $mtg[$cnt][4] = "&nbsp;" . $meetings[$cnt][4] . "&nbsp;"; /* presenter */
        $mtg[$cnt][5] = "&nbsp;" . $meetings[$cnt][5] . "&nbsp;"; /* worship name */
        //$mtg[$cnt][5] = "&nbsp;" . $meetings[$cnt][7] . " " . $meetings[$cnt][8] . "&nbsp"; /* worship leader */
    }
    // create an array of table attributes
//     $attributes = array('border' => '1', 'id' => 'trainingdata', 'align' => 'center', 'text-align' => 'center');
    
    /* add a link to enter a new meeting record - IF USER IS ADMIN*/
    //============================================
    // put option buttons on right
    //============================================
    echo "<div class='container'><p class='text-right'>";
    if($_SESSION["MTR-ADMIN-FLAG"] == "1"){
        echo "<a href='mtgFormNew.php'><button type='button' class='btn btn-link btn-xs'>NEW MEETING</button></a><br/>";
    }

    /* add link to old or new meetings */
    if (isset($_GET["PAST"])){
        echo "<a href='meetings.php'><button type='button' class='btn btn-info btn-xs hidden-xs'>Meeting Plans</button></a>";
        echo "<a href='meetings.php'><button type='button' class='btn btn-link btn-xs hidden-md hidden-lg'>Meeting Plans</button></a>";
    }else{
        echo "<a href='meetings.php?PAST=1'><button type='button' class='btn btn-link btn-xs'>Meeting History</button></a>";
    }
    echo "</p></div>";
    
    //============================================
    //============================================
    /* add the link to old or new meetings on far right */
    
    if(isset($mtg)){
        //if we have any meetings, display them
        echo "<div>";
        echo "<table border='1' id='trainingdata' align='center'><tr><td>Date</td><td>#</td><td>Type</td><td>Title</td><td>Leader</td><td>Worship</td></tr>";
    
        //cycle through the array to produce the table data
    
        for($rownum = 0; $rownum < count($mtg); $rownum++){
            echo "<tr>";
            for($colnum = 0; $colnum < 6; $colnum++){
                echo "<td>" . $mtg[$rownum][$colnum] . "</td>";
    //             $table->setCellContents($rownum+1, $colnum, $mtg[$rownum][$colnum]);
            }
            echo "</tr>";
        }
    
    //     $table->altRowAttributes(1,null, array("class"=>"alt"));
        echo "</table>";
    }
    //output the data
    echo "<div>";
//     echo $table->toHTML();
    /**** print the records returned  */
    printf("There were %d meetings found", $result->num_rows);
    echo "</div>";
    
    /************************************************
     * end the page definition, now close window
     ***********************************************/
    ?>
	</article>
	<div id="mtrFooter">
		<script>$("#mtrFooter").load("footer.php");</script>
	</div>
</div>
</body>
</html>
