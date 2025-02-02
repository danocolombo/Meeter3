<?php
if (! isset($_SESSION)) {
    session_start();
}
if (! isset($_SESSION["MTR-SESSION-ID"])) {
    header('Location: login.php');
    exit();
}
include './vendor/autoload.php';
require 'vendor/autoload.php';
include 'meeting.php';
date_default_timezone_set('UTC');
// use Aws\DynamoDb\Exception\DynamoDbException;

include 'mtgRedirects.php';
// require 'meeter.php';
// require 'includes/database.inc.php';
//require 'includes/meeting.inc.php';
// include 'auth/database.php';
/*
 * mtgAction.php
 */
$Action = $_GET['Action'];
$MID = $_GET['ID'];
switch ($Action){
    case "New":
        addMeetingToDB();
        exit;
    case "Update":
        
        updateMeetingInDB($MID);
        exit;
    case "DeleteGroup":
        deleteGroup();
        exit;
    case "PreLoadGroups":
        $MID = $_GET['MID'];
        PreLoadGroups($MID);
        exit;
    default:
        echo "not sure what to do with " . $Action;
        
}

function addMeetingToDB(){
    /*
     * this routine addes the form information to the database
     */
    /* need the following $link command to use the escape_string function */
    
    //since the add sql statement might be quite large dependind on the application
    // configuration, we will do it in parts.
    //-----------------------------------------------------------------------------------------------------
    // start with required fields, we know we check for mtgDate, mtgType and mtgTitle
    //-----------------------------------------------------------------------------------------------------
    
    //     $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    //     OR die(mysql_error());
    
    //we are going to check our values:
    $daMtg = new meeting($_POST['mtgDate'], $_POST['rdoMtgType'], $_POST['mtgTitle']);
    
    if(isset($_POST['mtgCoordinator'])){$daMtg->setMtgHost($_POST['mtgCoordinator']);}
    if(isset($_POST['mtgAttendance'])){$daMtg->setMtgAttendance($_POST['mtgAttendance']);}
    if(isset($_POST['mtgDonations'])){$daMtg->setDonations($_POST['mtgDonations']);}
    if(isset($_POST['mtgWorship'])){$daMtg->setWorshipFac($_POST['mtgWorship']);}
    if(isset($_POST['mtgAV'])){$daMtg->setAudioVisualFac($_POST['mtgAV']);}
    if(isset($_POST['mtgSetup'])){$daMtg->setSetupFac($_POST['mtgSetup']);}
    if(isset($_POST['mtgTransportation'])){$daMtg->setTransportationFac($_POST['mtgTransportation']);}
    if(isset($_POST['mtgGreeter1'])){$daMtg->setGreeter1Fac($_POST['mtgGreeter1']);}
    if(isset($_POST['mtgGreeter2'])){$daMtg->setGreeter2Fac($_POST['mtgGreeter2']);}
    if(isset($_POST['mtgResources'])){$daMtg->setResourcesFac($_POST['mtgResources']);}
    
    if(isset($_POST['mtgMenu'])){$daMtg->setMenu($_POST['mtgMenu']);}
    if(isset($_POST['mtgMealCnt'])){$daMtg->setMealCnt($_POST['mtgMealCnt']);}
    if(isset($_POST['mtgMealFac'])){$daMtg->setMealFac($_POST['mtgMealFac']);}
    
    if(isset($_POST['mtgReader1'])){$daMtg->setReader1Fac($_POST['mtgReader1']);}
    if(isset($_POST['mtgReader2'])){$daMtg->setReader2Fac($_POST['mtgReader2']);}
    if(isset($_POST['mtgAnnouncements'])){$daMtg->setAnnouncementsFac($_POST['mtgAnnouncements']);}
    if(isset($_POST['mtgTeaching'])){$daMtg->setTeachingFac($_POST['mtgTeaching']);}
    if(isset($_POST['mtgChips1'])){$daMtg->setChips1Fac($_POST['mtgChips1']);}
    if(isset($_POST['mtgChips2'])){$daMtg->setChips2Fac($_POST['mtgChips2']);}
    if(isset($_POST['mtgNewcomers1'])){$daMtg->setNewcomers1Fac($_POST['mtgNewcomers1']);}
    if(isset($_POST['mtgNewcomers2'])){$daMtg->setNewcomers2Fac($_POST['mtgNewcomers2']);}
    if(isset($_POST['mtgSerenity'])){$daMtg->setSerenityFac($_POST['mtgSerenity']);}
    
    if(isset($_POST['mtgNursery'])){$daMtg->setNurseryCnt($_POST['mtgNursery']);}
    if(isset($_POST['mtgNurseryFac'])){$daMtg->setNurseryFac($_POST['mtgNurseryFac']);}
    if(isset($_POST['mtgChildren'])){$daMtg->setChildrenCnt($_POST['mtgChildren']);}
    if(isset($_POST['mtgChildrenFac'])){$daMtg->setChildrenFac($_POST['mtgChildrenFac']);}
    if(isset($_POST['mtgYouth'])){$daMtg->setYouthCnt($_POST['mtgYouth']);}
    if(isset($_POST['mtgYouthFac'])){$daMtg->setYouthFac($_POST['mtgYouthFac']);}  
    if(isset($_POST['mtgCafe'])){$daMtg->setCafeFac($_POST['mtgCafe']);}
    if(isset($_POST['mtgTearDown'])){$daMtg->setTearDownFac($_POST['mtgTearDown']);}
    if(isset($_POST['mtgSecurity'])){$daMtg->setSecurityFac($_POST['mtgSecurity']);}

    if(isset($_POST['mtgNotes'])){$daMtg->setNotes($_POST['mtgNotes']); }
    //meeting object should be loaded with values
//     print_r($daMtg);
//     exit();
    
    //=============================================
    // check to see if meeting, type and title exist
    // http://rogueintel.org/mapi/public/index.php/api/client/getIdForDTT/ccc?mtgDate=2019-08-01&mtgType=Lesson&mtgTitle=Victory
    
    
    // ????????????????????????????????????????????????????
    // need to check if a similar meeting is already loaded
    // ????????????????????????????????????????????????????
    // the values to check for are:
    // mtgDate
    // mtgType
    // mtgTitle
    
    $connection = mysqli_connect($_SESSION["MTR-H"], $_SESSION["MTR-U"], $_SESSION["MTR-P"], $_SESSION["MTR-N"]);
    
//     $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $dbID = 0;
    $stmt = $connection->prepare("Select ID, MtgDate, MtgType, MtgTitle FROM " . $_SESSION["MTR-CLIENT"] . ".meetings WHERE MtgDate = ? AND MtgType = ? AND MtgTitle = ?");
    $dt = date("Y-m-d", strtotime($daMtg->mtgDate));
    $tp = $daMtg->mtgType;
    $tt = mysqli_real_escape_string($connection, $daMtg->mtgTitle);
    $stmt->bind_param("sss", $dt, $tp, $tt);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0){
        //echo "already entered";
        $stmt->bind_result($ID, $MtgDate, $MtgType, $MtgTitle);
        while($stmt->fetch()){
            $daMtg->mtgID = $ID;
        }
        $stmt->free_result();
        $stmt->close();
        $connection->close();
        destination(307, "error.php?ErrorCode=3001&ErrorMsg=\"That%20meeting%20already%20exists\"&ID=$daMtg->mtgID");
    }
    //--------------------------------------------------------------
    // no record found, proceed to add the entry
    //--------------------------------------------------------------
    $stmt->close();
    
//     echo "<br>Here is what we are going to save....<br>";
//     print_r($daMtg);
//     exit();
    
    // API to insert meeting
    $url = 'http://rogueintel.org/mapi/public/index.php/api/meeting/create/' . $_SESSION["MTR-CLIENT"];
    //$url =  'https://282lcxarb7.execute-api.us-east-1.amazonaws.com/QA/meeting/create/' . $_SESSION["MTR-CLIENT"];
    
    $ch = curl_init($url);
    //encode daMtr class
    $jsonDataEncoded = json_encode($daMtg);
    //Tell cURL that we want to send a POST reqeust
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
    //execute
    $result = curl_exec($ch);
    
    
//     //     $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//     $stmt = $connection->prepare("INSERT INTO `meetings` ( `MtgDate`, `MtgType`, `MtgTitle`) VALUES ( ?, ?, ?)");
//     $stmt->bind_param("sss", date("Y-m-d", strtotime($daMtg->mtgDate)), $daMtg->mtgType, $daMtg->mtgTitle );
//     $stmt->execute();
//     $stmt->close();
//     //--------------------------------------------------------------
//     // get the ID just created with the insert
//     //--------------------------------------------------------------
//     //     $stmt = $connection->prepare("Select ID FROM meetings WHERE MtgDate = ? AND MtgType = ? AND MtgTitle = ?");
//     //     $stmt->bind_param("sss", $mtgDate, $mtgType, $mtgTitle);
//     //     $stmt->execute();
//     //     $stmt->bind_result($ID);
//     $sql = "SELECT ID FROM meetings WHERE MtgDate = '";
//     $sql .= date("Y-m-d", strtotime($daMtg->mtgDate)) . "' AND MtgType = '";
//     $sql .= $daMtg->mtgType . "' AND  MtgTitle = '";
//     $sql .= mysql_real_escape_string($daMtg->mtgTitle) . "'";
//     $result = $connection->query($sql, MYSQLI_STORE_RESULT);
//     list($returnedID) = $result->fetch_row();
//     $daMtg->mtgID = $returnedID;
//     $result->close();
//     //----------------------------------------------------------
//     //now add (update) in sections
//     //----------------------------------------------------------
    
//     //     $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//     $sql = "UPDATE meetings SET MtgFac = ?, MtgAttendance = ?, Donations = ?, MtgWorship = ?, AudioVisualFac = ?, ";
//     $sql .= "SetupFac = ?, TransportationFac = ?, Greeter1Fac = ?, Greeter2Fac = ?, ResourcesFac = ? WHERE ID = ?";
//     $stmt = $connection->prepare($sql);
//     $stmt->bind_param("iidiiiiiiii",
//         $daMtg->mtgFac,
//         $daMtg->mtgAttendance,
//         $daMtg->mtgDonations,
//         $daMtg->mtgWorshipFac,
//         $daMtg->mtgAudioVisualFac,
//         $daMtg->mtgSetupFac,
//         $daMtg->mtgTransportationFac,
//         $daMtg->mtgGreeter1Fac,
//         $daMtg->mtgGreeter2Fac,
//         $daMtg->mtgResourcesFac,
//         $daMtg->mtgID);
//     $stmt->execute();
//     $stmt->close();
    
//     $sql = "UPDATE meetings SET MealCnt = ?, MealFac = ?, Reader1Fac = ?, Reader2Fac = ?, AnnouncementsFac = ?, ";
//     $sql .= "TeachingFac = ?, Chips1Fac = ?, Chips2Fac = ?, SerenityFac = ? WHERE ID = ?";
//     $stmt = $connection->prepare($sql);
//     $stmt->bind_param("iiiiiiiiii",
//         $daMtg->mtgMealCnt,
//         $daMtg->mtgMealFac,
//         $daMtg->mtgReader1Fac,
//         $daMtg->mtgReader2Fac,
//         $daMtg->mtgAnnouncementsFac,
//         $daMtg->mtgTeachingFac,
//         $daMtg->mtgChips1Fac,
//         $daMtg->mtgChips2Fac,
//         $daMtg->mtgSerenityFac,
//         $daMtg->mtgID);
//     $stmt->execute();
//     $stmt->close();
    
//     $sql = "UPDATE meetings SET Newcomers1Fac = ?, Newcomers2Fac = ?, NurseryCnt = ?, NurseryFac = ?, ";
//     $sql .= "ChildrenCnt = ?, ChildrenFac = ?, YouthCnt = ?, YouthFac = ? WHERE ID = ?";
//     $stmt = $connection->prepare($sql);
//     $stmt->bind_param("iiiiiiiii",
//         $daMtg->mtgNewcomers1Fac,
//         $daMtg->mtgNewcomers2Fac,
//         $daMtg->mtgNurseryCnt,
//         $daMtg->mtgNurseryFac,
//         $daMtg->mtgChildrenCnt,
//         $daMtg->mtgChildrenFac,
//         $daMtg->mtgYouthCnt,
//         $daMtg->mtgYouthFac,
//         $daMtg->mtgID);
//     $stmt->execute();
//     $stmt->close();
    
//     $sql = "UPDATE meetings SET CafeFac = ?, TearDownFac = ?, SecurityFac = ?, Menu = ?, ";
//     $sql .= "MtgNotes = ? WHERE ID = ?";
//     $stmt = $connection->prepare($sql);
//     $stmt->bind_param("iiissi",
//         $daMtg->mtgCafeFac,
//         $daMtg->mtgTearDownFac,
//         $daMtg->mtgSecurityFac,
//         $daMtg->mtgMenu,
//         $daMtg->mtgNotes,
//         $daMtg->mtgID);
//     $stmt->execute();
//     $stmt->close();
//     $connection->close();
    
    destination(307, "meetings.php");
    
}
function updateMeetingInDB($MID){
    /*
     * this routine updates an existing record in the database
     */
    
    //load all the form data into a class object
    $mDate = $_POST["mtgDate"];
    $mType = $_POST["rdoMtgType"];
    $mTitle = $_POST["mtgTitle"];
    // create object
    $tm = new meeting($mDate, $mType, $mTitle);
    //set all the default values to the ghost value before setting passed in value;
    $tm->setGhost($_SESSION["MTR-GHOST-ID"]);
    $tm->setMtgHost($_POST["mtgCoordinator"]);
    $tm->setDonations($_POST["mtgDonations"]);
    $tm->setWorshipFac($_POST["mtgWorship"]);
    $tm->setAudioVisualFac($_POST["mtgAV"]);
    $tm->setSetupFac($_POST["mtgSetup"]);
    $tm->setTransportationFac($_POST["mtgTransportation"]);
    $tm->setGreeter1Fac($_POST["mtgGreeter1"]);
    $tm->setGreeter2Fac($_POST["mtgGreeter2"]);
    $tm->setResourcesFac($_POST["mtgResources"]);
    $tm->setMenu($_POST["mtgMenu"]);
    $tm->setMealCnt($_POST["mtgMealCnt"]);
    $tm->setMealFac($_POST["mtgMealFac"]);
    $tm->setReader1Fac($_POST["mtgReader1"]);
    $tm->setReader2Fac($_POST["mtgReader2"]);
    $tm->setAnnouncementsFac($_POST["mtgAnnouncements"]);
    $tm->setTeachingFac($_POST["mtgTeaching"]);
    $tm->setChips1Fac($_POST["mtgChips1"]);
    $tm->setChips2Fac($_POST["mtgChips2"]);
    $tm->setNewcomers1Fac($_POST["mtgNewcomers1"]);
    $tm->setNewcomers2Fac($_POST["mtgNewcomers2"]);
    $tm->setSerenityFac($_POST["mtgSerenity"]);
    $tm->setNurseryCnt($_POST["mtgNursery"]);
    $tm->setNurseryFac($_POST["mtgNurseryFac"]);
    $tm->setChildrenCnt($_POST["mtgChildren"]);
    $tm->setChildrenFac($_POST["mtgChildrenFac"]);
    $tm->setYouthCnt($_POST["mtgYouth"]);
    $tm->setYouthFac($_POST["mtgYouthFac"]);
    $tm->setCafeFac($_POST["mtgCafe"]);
    $tm->setTearDownFac($_POST["mtgTearDown"]);
    $tm->setSecurityFac($_POST["mtgSecurity"]);
    $tm->setNotes($_POST["mtgNotes"]);
    // ===================================
    //  SEND UPDATE POST TO MAPI
    //===================================
    
    // API to insert meeting
//     $url = 'http://rogueintel.org/mapi/public/index.php/api/meeting/create/' . $_SESSION["MTR-CLIENT"];
    //$url =  'https://282lcxarb7.execute-api.us-east-1.amazonaws.com/QA/meeting/create/' . $_SESSION["MTR-CLIENT"];
    $url = "http://rogueintel.org/mapi/public/index.php/api/meeting/update/" . $_SESSION["MTR-CLIENT"] . "?MID=" . $MID;
    
    $ch = curl_init($url);
    //encode daMtr class
    $jsonDataEncoded = json_encode($tm);
    //Tell cURL that we want to send a POST reqeust
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    // Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
    //execute
    $result = curl_exec($ch);
    
    $dest = "meetings.php";
    //testSQL($sql);
    destination(307, $dest);
}
function updateMeetingInDB1(){
    /*
     * this routine updates an existing record in the database
     */
    /* need the following $link command to use the escape_string function */
    include 'database.php';
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
    OR die(mysql_error());
    
    
    $ID = $_GET['ID'];
    $mDate = $_POST['mtgDate'];
    $mType = $_POST['mtgType'];
    $mTitle = $_POST['mtgTitle'];
    $mPresenter = $_POST['mtgPresenter'];
    $mWorship = $_POST['mtgWorship'];
    $mAttendance = $_POST['mtgAttendance'];
    $mDonations = $_POST['mtgDonations'];
    $mMeal = htmlspecialchars($_POST['mtgMeal']);
    $mDinnerCnt = $_POST['mtgDinnerCnt'];
    $mNurseryCnt = $_POST['mtgNurseryCnt'];
    $mChildrenCnt = $_POST['mtgChildrenCnt'];
    $mYouthCnt = $_POST['mtgYouthCnt'];
    $mNotes = $_POST['mtgNotes'];
    
    $sql = "UPDATE meetings SET MtgDate = '";
    $sql = $sql . date("Y-m-d", strtotime($mDate)) . "', MtgType = '";
    $sql = $sql . $mType . "', MtgTitle = '";
    $sql = $sql . mysql_real_escape_string($mTitle) . "', MtgPresenter = '";
    $sql = $sql . mysql_real_escape_string($mPresenter) . "', MtgAttendance = '";
    $sql = $sql . $mAttendance . "', ";
    $sql = $sql . "MtgWorship = '";
    $sql = $sql . $mWorship . "', ";
    $sql = $sql . "Donations = ";
    $sql = $sql . $mDonations . ", ";
    $sql = $sql . "MtgMeal = '";
    $sql = $sql . $mMeal . "', ";
    //     $sql = $sql . mysql_real_escape_string($mMeal) . "', ";
    $sql = $sql . "DinnerCnt = '" . $mDinnerCnt . "', ";
    $sql = $sql . "NurseryCnt = '" . $mNurseryCnt . "', ";
    $sql = $sql . "ChildrenCnt = '" . $mChildrenCnt . "', ";
    $sql = $sql . "YouthCnt = '" . $mYouthCnt . "', ";
    $sql = $sql . "MtgNotes = '" . mysql_real_escape_string($mNotes) . "'";
    $sql = $sql . " WHERE ID = '" . $ID . "'";
    
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    mysqli_query($con,$sql);
    
    mysqli_close($con);
    $dest = "meetings.php";
    //testSQL($sql);
    destination(307, $dest);
}

function deleteGroup(){
    /*==========================================================
     this routine deletes the group from the ID passed in
     ==========================================================*/
    $id = $_GET['GID'];
    
    // need to ensure that we have a GID
    if ($id > 0){
        $sql = "DELETE FROM groups WHERE ID = " . $id;
        
        $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        // Check connection
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
        mysqli_query($con,$sql);
        
        mysqli_close($con);
        $dest = "mtgForm.php?ID=" . $_GET['MID'];
        //testSQL($sql);
        destination(307, $dest);
        
        
    }
    
}
function PreLoadGroups($MID){
    /*======================================================================
     * this function copies the groups from the previous meeting to the
     * meeting ID passed in.
     ======================================================================*/
    $dbcon=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if (mysqli_connect_errno()){
        die("Database connection failed: " .
            mysqli_connect_error() .
            " (" . mysqli_connect_error() . ")");
    }
    /*#############################################
     * GET THE LAST MEETING ID TO GET GROUPS FROM
     *############################################*/
    $query = "SELECT ";
    $query .= "groups.MtgID ";
    $query .= "FROM groups ";
    $query .= "INNER JOIN ";
    $query .= "meetings ON groups.MtgID = meetings.ID ";
    $query .= "ORDER BY meetings.MtgDate DESC";
    // echo "<br />" . $query . "<br /><hr /";
    $result = mysqli_query($dbcon, $query);
    if (!result){
        die("Database query failed.");
    }
    $grpIDs = mysqli_fetch_assoc($result);
    $lastMtgID = $grpIDs["MtgID"];
    mysqli_free_result($result);
    // echo "<br />lastMtgID=" . $lastMtgID . "<br/>";
    /*****************************************************
     * Now get the groups from that last meeting in array
     * ===================================================
     * we need:
     *      FacID
     *      CoFacID
     *      Gender
     *      Location
     *      Title
     * ===================================================
     *****************************************************/
    $query = "SELECT ";
    $query .= "groups.FacID, groups.CoFacID, groups.Gender, ";
    $query .= "groups.Location, groups.Title ";
    $query .= "FROM groups ";
    $query .= "WHERE groups.MtgID = " . $lastMtgID . " ";
    $query .= "ORDER BY groups.Gender, groups.Title";
    $result = mysqli_query($dbcon, $query);
    $group = array();
    $FacID = array();
    $CoFacID = array();
    $Gender = array();
    $Location = array();
    $Title = array();
    
    if (!result){
        die("Database query failed.");
    }
    $grpCnt = 0;
    while($groups = mysqli_fetch_assoc($result)){
        /*========================================/
         * now load array with groups retrieved
         *****************************************/
        $FacID[$grpCnt] = $groups["FacID"];
        $CoFacID[$grpCnt] = $groups["CoFacID"];
        $Gender[$grpCnt] = $groups["Gender"];
        $Location[$grpCnt] = $groups["Location"];
        $Title[$grpCnt] = $groups["Title"];
        ++$grpCnt;
    }
    mysqli_free_result($result);
    $i = 0;
    while ($i < $grpCnt){
        /*****************************
         * print group
         *****************************/
        //echo $Gender[$i] . " " . $Title[$i] . " in " . $Location[$i] . "<br/>";
        ++$i;
    }
    /***********************************
     * insert data for new week
     ***********************************/
    $i = 0;
    while ($i < $grpCnt){
        $query = "INSERT INTO groups (FacID, CoFacID, Gender, Title, Location, MtgID)
            Values({$FacID[$i]}, {$CoFacID[$i]}, {$Gender[$i]}, '{$Title[$i]}',
                '{$Location[$i]}', {$MID})";
        
        //echo "query:" . $query . "<br/><hr />";
        $result = mysqli_query($dbcon, $query);
        if (!$result){
            die("Database query INSERT failed");
        }
        ++$i;
    }
    
    mysqli_close($dbcon);
    $dest = "mtgForm.php?ID=" . $MID;
    destination(307, $dest);
}

function executeSQL($sql){
    /*
     * this function executes the sql passed in
     */
    include 'database.php';
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    mysqli_query($con,$sql);
    
    
    mysqli_close($con);
    
    destination(307, "meetings.php");
    
}

function testSQL($sql){
    /*
     * this function executes the sql passed in
     */
    echo "SQL: " . $sql;
}
?>
