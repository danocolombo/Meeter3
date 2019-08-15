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
				if($_SESSION["adminFlag"] == "1"){
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
    
    
    if($mysqli->errno > 0){
        printf("Mysql error number generated: %d", $mysqli->errno);
        exit();
    }
    date_default_timezone_set("America/New_York");
    $tmpToday = date("Y-m-d");
    if (isset($_GET["PAST"])){
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate <= '" . $tmpToday . "' ORDER BY m.MtgDate DESC";
    }else{
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate >= '" . $tmpToday . "' ORDER BY m.MtgDate ASC";
    }
    /**
    if ($past){
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate <= '2018-06-21' ORDER BY m.MtgDate DESC";
    }else{
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate >= '2018-06-21' ORDER BY m.MtgDate ASC";
    }
     * **/
    $meetings = array();
    $result = $mysqli->query($sql);
    
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
    if($_SESSION["MTR-ADMIN-FLAG"] == "1"){
        echo "<div style='text-align:right; padding-right: 20px;'><a href='mtgForm.php'>NEW ENTRY</a><br/>";
    }else{
        echo "<div style='text-align:right; padding-right: 20px;'><br/>";
    }
    /* add link to old or new meetings */
    if (isset($_GET["PAST"])){
        echo "<a href='meetings.php'>mtg plans</a>";
    }else{
        echo "<a href='meetings.php?PAST=1'>mtg history</a>";
    }
    echo "</div>";
//     //create the table object
//     $table = new HTML_Table($attributes);
    
//     //set the headers
//     $table->setHeaderContents(0,0, "Date");
//     $table->setHeaderContents(0,1, "#");
//     $table->setHeaderContents(0,2, "Type");
//     $table->setHeaderContents(0,3, "Title");
//     $table->setHeaderContents(0,4, "Leader");
//     $table->setHeaderContents(0,5, "Worship");
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
	<footer>
		&copy; 2013-2018 Rogue Intelligence
	</footer>
</div>
</body>
</html>
