<?php 

class meeting
{
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // this is used to manage and manipulate the meeting information
    // --------------------------------------------------------------
    // these are the properities of a meeting.
    // --------------------------------------------------------------
    // at the end of this declaration we attempt to build the
    // object with the folling command.
    //
    //     $theMeeting = new meeting($mDate, $mType, $mTitle);
    //
    // which means that we need values in $mDate, $mType & $mTitle
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    public $mtgID;
    public $mtgDate;
    public $mtgType;
    public $mtgTitle;
    // trackable properties
    
    public $mtgHost;
    public $mtgAttendance;
    public $donations;
    public $worshipFac;
    public $audioVisualFac;
    public $setupFac;
    public $transportationFac;
    public $greeter1Fac;
    public $greeter2Fac;
    public $resourcesFac;
    public $menu;
    public $mealCnt;
    public $mealFac;
    public $reader1Fac;
    public $reader2Fac;
    public $announcementsFac;
    public $teachingFac;
    public $chips1Fac;
    public $chips2Fac;
    public $serenityFac;
    public $newcomers1Fac;
    public $newcomers2Fac;
    public $nurseryCnt;
    public $nurseryFac;
    public $childrenCnt;
    public $childrenFac;
    public $youthCnt;
    public $youthFac;
    public $cafeFac;
    public $tearDownFac;
    public $securityFac;
    public $notes;
    
    /**
     * @return mixed
     */
    public function getMtgID()
    {
        return $this->mtgID;
    }
    
    /**
     * @param mixed $mtgID
     */
    public function setMtgID($mtgID)
    {
        $this->mtgID = $mtgID;
    }
    
    /**
     * @return mixed
     */
    public function getMtgDate()
    {
        return $this->mtgDate;
    }
    
    /**
     * @param mixed $mtgDate
     */
    public function setMtgDate($mtgDate)
    {
        $this->mtgDate = $mtgDate;
    }
    
    /**
     * @return mixed
     */
    public function getMtgType()
    {
        return $this->mtgType;
    }
    
    /**
     * @param mixed $mtgType
     */
    public function setMtgType($mtgType)
    {
        $this->mtgType = $mtgType;
    }
    
    /**
     * @return mixed
     */
    public function getMtgTitle()
    {
        return $this->mtgTitle;
    }
    
    /**
     * @param mixed $mtgTitle
     */
    public function setMtgTitle($mtgTitle)
    {
        $this->mtgTitle = $mtgTitle;
    }
    
    /**
     * @return mixed
     */
    public function getMtgHost()
    {
        return $this->mtgHost;
    }
    
    /**
     * @param mixed $mtgHost
     */
    public function setMtgHost($mtgHost)
    {
        $this->mtgHost = $mtgHost;
    }
    
    /**
     * @return mixed
     */
    public function getMtgAttendance()
    {
        return $this->mtgAttendance;
    }
    
    /**
     * @param mixed $mtgCnt
     */
    public function setMtgAttendance($mtgAttendance)
    {
        $this->mtgAttendance = $mtgAttendance;
    }
    
    /**
     * @return mixed
     */
    public function getDonations()
    {
        return $this->donations;
    }
    
    /**
     * @param mixed $donations
     */
    public function setDonations($donations)
    {
        $this->donations = $donations;
    }
    
    /**
     * @return mixed
     */
    public function getWorshipFac()
    {
        return $this->worshipFac;
    }
    
    /**
     * @param mixed $worshipFac
     */
    public function setWorshipFac($worshipFac)
    {
        $this->worshipFac = $worshipFac;
    }
    
    /**
     * @return mixed
     */
    public function getAudioVisualFac()
    {
        return $this->audioVisualFac;
    }
    
    /**
     * @param mixed $audioVisualFac
     */
    public function setAudioVisualFac($audioVisualFac)
    {
        $this->audioVisualFac = $audioVisualFac;
    }
    
    /**
     * @return mixed
     */
    public function getSetupFac()
    {
        return $this->setupFac;
    }
    
    /**
     * @param mixed $setupFac
     */
    public function setSetupFac($setupFac)
    {
        $this->setupFac = $setupFac;
    }
    
    /**
     * @return mixed
     */
    public function getTransportationFac()
    {
        return $this->transportationFac;
    }
    
    /**
     * @param mixed $transportationFac
     */
    public function setTransportationFac($transportationFac)
    {
        $this->transportationFac = $transportationFac;
    }
    
    /**
     * @return mixed
     */
    public function getGreeter1Fac()
    {
        return $this->greeter1Fac;
    }
    
    /**
     * @param mixed $greeter1Fac
     */
    public function setGreeter1Fac($greeter1Fac)
    {
        $this->greeter1Fac = $greeter1Fac;
    }
    
    /**
     * @return mixed
     */
    public function getGreeter2Fac()
    {
        return $this->greeter2Fac;
    }
    
    /**
     * @param mixed $greeter2Fac
     */
    public function setGreeter2Fac($greeter2Fac)
    {
        $this->greeter2Fac = $greeter2Fac;
    }
    
    /**
     * @return mixed
     */
    public function getResourcesFac()
    {
        return $this->resourcesFac;
    }
    
    /**
     * @param mixed $resourcesFac
     */
    public function setResourcesFac($resourcesFac)
    {
        $this->resourcesFac = $resourcesFac;
    }
    
    /**
     * @return mixed
     */
    public function getMenu()
    {
        return $this->menu;
    }
    
    /**
     * @param mixed $menu
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }
    
    /**
     * @return mixed
     */
    public function getMealCnt()
    {
        return $this->mealCnt;
    }
    
    /**
     * @param mixed $mealCnt
     */
    public function setMealCnt($mealCnt)
    {
        $this->mealCnt = $mealCnt;
    }
    
    /**
     * @return mixed
     */
    public function getMealFac()
    {
        return $this->mealFac;
    }
    
    /**
     * @param mixed $mealFac
     */
    public function setMealFac($mealFac)
    {
        $this->mealFac = $mealFac;
    }
    
    /**
     * @return mixed
     */
    public function getReader1Fac()
    {
        return $this->reader1Fac;
    }
    
    /**
     * @param mixed $reader1Fac
     */
    public function setReader1Fac($reader1Fac)
    {
        $this->reader1Fac = $reader1Fac;
    }
    
    /**
     * @return mixed
     */
    public function getReader2Fac()
    {
        return $this->reader2Fac;
    }
    
    /**
     * @param mixed $reader2Fac
     */
    public function setReader2Fac($reader2Fac)
    {
        $this->reader2Fac = $reader2Fac;
    }
    
    /**
     * @return mixed
     */
    public function getAnnouncementsFac()
    {
        return $this->announcementsFac;
    }
    
    /**
     * @param mixed $announcementsFac
     */
    public function setAnnouncementsFac($announcementsFac)
    {
        $this->announcementsFac = $announcementsFac;
    }
    
    /**
     * @return mixed
     */
    public function getTeachingFac()
    {
        return $this->teachingFac;
    }
    
    /**
     * @param mixed $teachingFac
     */
    public function setTeachingFac($teachingFac)
    {
        $this->teachingFac = $teachingFac;
    }
    
    /**
     * @return mixed
     */
    public function getChips1Fac()
    {
        return $this->chips1Fac;
    }
    
    /**
     * @param mixed $chips1Fac
     */
    public function setChips1Fac($chips1Fac)
    {
        $this->chips1Fac = $chips1Fac;
    }
    
    /**
     * @return mixed
     */
    public function getChips2Fac()
    {
        return $this->chips2Fac;
    }
    
    /**
     * @param mixed $chips2Fac
     */
    public function setChips2Fac($chips2Fac)
    {
        $this->chips2Fac = $chips2Fac;
    }
    
    /**
     * @return mixed
     */
    public function getSerenityFac()
    {
        return $this->serenityFac;
    }
    
    /**
     * @param mixed $serenityFac
     */
    public function setSerenityFac($serenityFac)
    {
        $this->serenityFac = $serenityFac;
    }
    
    /**
     * @return mixed
     */
    public function getNewcomers1Fac()
    {
        return $this->newcomers1Fac;
    }
    
    /**
     * @param mixed $newcomers1Fac
     */
    public function setNewcomers1Fac($newcomers1Fac)
    {
        $this->newcomers1Fac = $newcomers1Fac;
    }
    
    /**
     * @return mixed
     */
    public function getNewcomers2Fac()
    {
        return $this->newcomers2Fac;
    }
    
    /**
     * @param mixed $newcomers2Fac
     */
    public function setNewcomers2Fac($newcomers2Fac)
    {
        $this->newcomers2Fac = $newcomers2Fac;
    }
    
    /**
     * @return mixed
     */
    public function getNurseryCnt()
    {
        return $this->nurseryCnt;
    }
    
    /**
     * @param mixed $nurseryCnt
     */
    public function setNurseryCnt($nurseryCnt)
    {
        $this->nurseryCnt = $nurseryCnt;
    }
    
    /**
     * @return mixed
     */
    public function getNurseryFac()
    {
        return $this->nurseryFac;
    }
    
    /**
     * @param mixed $nurseryFac
     */
    public function setNurseryFac($nurseryFac)
    {
        $this->nurseryFac = $nurseryFac;
    }
    
    /**
     * @return mixed
     */
    public function getChildrenCnt()
    {
        return $this->childrenCnt;
    }
    
    /**
     * @param mixed $childrenCnt
     */
    public function setChildrenCnt($childrenCnt)
    {
        $this->childrenCnt = $childrenCnt;
    }
    
    /**
     * @return mixed
     */
    public function getChildrenFac()
    {
        return $this->childrenFac;
    }
    
    /**
     * @param mixed $childrenFac
     */
    public function setChildrenFac($childrenFac)
    {
        $this->childrenFac = $childrenFac;
    }
    
    /**
     * @return mixed
     */
    public function getYouthCnt()
    {
        return $this->youthCnt;
    }
    
    /**
     * @param mixed $youthCnt
     */
    public function setYouthCnt($youthCnt)
    {
        $this->youthCnt = $youthCnt;
    }
    
    /**
     * @return mixed
     */
    public function getYouthFac()
    {
        return $this->youthFac;
    }
    
    /**
     * @param mixed $youthFac
     */
    public function setYouthFac($youthFac)
    {
        $this->youthFac = $youthFac;
    }
    
    /**
     * @return mixed
     */
    public function getCafeFac()
    {
        return $this->cafeFac;
    }
    
    /**
     * @param mixed $cafeFac
     */
    public function setCafeFac($cafeFac)
    {
        $this->cafeFac = $cafeFac;
    }
    
    /**
     * @return mixed
     */
    public function getTearDownFac()
    {
        return $this->tearDownFac;
    }
    
    /**
     * @param mixed $tearDownFac
     */
    public function setTearDownFac($tearDownFac)
    {
        $this->tearDownFac = $tearDownFac;
    }
    
    /**
     * @return mixed
     */
    public function getSecurityFac()
    {
        return $this->securityFac;
    }
    
    /**
     * @param mixed $securityFac
     */
    public function setSecurityFac($securityFac)
    {
        $this->securityFac = $securityFac;
    }
    
    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }
    
    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
    
    function __construct($mDate, $mType, $mTitle){
        $this->setMtgDate($mDate);
        $this->setMtgType($mType);
        $this->setMtgTitle($mTitle);
        
        $ghost = $_SESSION["MTR-GHOST-ID"];
        $this->setAnnouncementsFac($ghost);
        $this->setAudioVisualFac($ghost);
        $this->setCafeFac($ghost);
        $this->setChildrenCnt(0);
        $this->setChildrenFac($ghost);
        $this->setChips1Fac($ghost);
        $this->setChips2Fac($ghost);
        $this->setDonations(0);
        $this->setGreeter1Fac($ghost);
        $this->setGreeter2Fac($ghost);
        $this->setMealCnt(0);
        $this->setMealFac($ghost);
        $this->setMenu("");
        $this->setMtgAttendance(0);
        $this->setMtgHost($ghost);
        $this->setNewcomers1Fac($ghost);
        $this->setNewcomers2Fac($ghost);
        $this->setNotes("");
        $this->setNurseryCnt(0);
        $this->setNurseryFac($ghost);
        $this->setReader1Fac($ghost);
        $this->setReader2Fac($ghost);
        $this->setResourcesFac($ghost);
        $this->setSecurityFac($ghost);
        $this->setSetupFac($ghost);
        $this->setTeachingFac($ghost);
        $this->setTearDownFac($ghost);
        $this->setTransportationFac($ghost);
        $this->setWorshipFac($ghost);
        $this->setYouthCnt(0);
        $this->setYouthFac($ghost);
    }
    public function printMeeting()
    {
        echo "------------ PRINTING MEETING DEFINITION -------------------";
        echo "$mtgDate: " . $mtgDate . nl2br("\n");
        echo "$mtgType: " . $mtgType . nl2br("\n");
        echo "$mtgTitle: " . $mtgTitle . nl2br("\n");
        echo "$id: " . $id . nl2br("\n");
        echo "$host: " . $host . nl2br("\n");
        echo "$attendance: " . $attendance . nl2br("\n");
        echo "$donationAmount: " . $donationAmount . nl2br("\n");
        echo "$mealGuests: " . $mealGuests . nl2br("\n");
        echo "$notes: " . $notes . nl2br("\n");
        echo "$greeter1: " . $greeter1 . nl2br("\n");
        echo "$greeter2: " . $greeter2 . nl2br("\n");
        echo "$resources: " . $resources . nl2br("\n");
        echo "$transportation: " . $transportation . nl2br("\n");
        echo "$worship: " . $worship . nl2br("\n");
        echo "$chips1: " . $chips1 . nl2br("\n");
        echo "$chips2: " . $chips2 . nl2br("\n");
        echo "$meal: " . $meal . nl2br("\n");
        echo "$mealFac: " . $mealFac . nl2br("\n");
        echo "$reader1: " . $reader1 . nl2br("\n");
        echo "$reader2: " . $reader2 . nl2br("\n");
        echo "$announcements: " . $announcements . nl2br("\n");
        echo "$donations: " . $donations . nl2br("\n");
        echo "$nursery: " . $nursery . nl2br("\n");
        echo "$nurseryFac: " . $nurseryFac . nl2br("\n");
        echo "$children: " . $children . nl2br("\n");
        echo "$childrenFac: " . $childrenFac . nl2br("\n");
        echo "$youth: " . $youth . nl2br("\n");
        echo "$youthFac: " . $youthFac . nl2br("\n");
        echo "$serenity: " . $serenity . nl2br("\n");
        echo "$nurseryFac: " . $nurseryFac . nl2br("\n");
        echo "$cafe: " . $cafe . nl2br("\n");
        echo "$cafeFac: " . $cafeFac . nl2br("\n");
        echo "$setup: " . $setup . nl2br("\n");
        echo "$teardown: " . $teardown . nl2br("\n");
        echo "$av: " . $av . nl2br("\n");
        echo "$security: " . $security . nl2br("\n");
    }
    
    public function commitNew()
    {
        // this inserts Date/Type/Title into database and sets id
        try {
            $stmt = $connection->prepare("INSERT INTO `meetings` ( MtgDate, MtgType, MtgTitle) VALUES ( ?, ?, ?)");
            $stmt->bind_param("sss", $this->mtgDate, $this->mtgType, $this->mtgTitle);
            $stmt->execute();
            
            $this->id = $connection->insert_id;
            
            $stmt->close();
        } catch (PDOException $e) {
            echo "Error: [meeter.php_commitNew()] " . $e->getMessage();
        }
        
        $connection = null;
    }
    
    public function getMeeting($MID){
        //-----------------------------------------
        // this function will load the class with
        // the MID passed in.
        //-----------------------------------------
        if ( isset( $connection ) ) return;
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        
        if (mysqli_connect_errno()) {
            die(sprintf("[meeter.php] Connect failed: %s\n", mysqli_connect_error()));
        }
        $sql = "SELECT * FROM meetings WHERE ID = " . $MID;
        
        $mtg = array();
        
        $result = $mysqli->query($sql);
        
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
        {
            $mtg[] = array($row['ID'], $row['MtgDate'], $row['MtgType'],
                $row['MtgTitle'], $row['MtgPresenter'], $row['MtgAttendance'],
                $row['MtgWorship'], $row['MtgMeal'], $row['DinnerCnt'],
                $row['NurseryCnt'], $row['ChildrenCnt'], $row['YouthCnt'],
                $row['MtgNotes'], $row['Donations'],$row['Reader1'], $row['Reader2'],
                $row['NurseryContact'],$row['ChildrenContact'], $row['YouthContact'],
                $row['MealContact'],$row['CafeContact'], $row['TransportationContact'],
                $row['SetupContact'],$row['TearDownContact'], $row['Greeter1'],
                $row['Greeter2'],$row['Resources'], $row['Serenity'],$row['AudioVisual'],
                $row['Announcements'], $row['SecurityContact']
                
            );
        }
        $this->setId($mtg[0][0]);
        if(!isset($mtg[0][1])){
            $mtg[0][1] = "2018-06-18";
        }
        $this->setMtgDate($mtg[0][1]);
        if(!isset($mtg[0][2])){
            $mtg[0][2] = "Testimony";
        }
        $this->setMtgType($mtg[0][2]);
        if(!isset($mtg[0][3])){
            $mtg[0][3] = "Dano Colombo";
        }
        $this->setMtgTitle($mtg[0][3]);
        $this->setHost($mtg[0][4]);
        $this->setAttendance($mtg[0][5]);
        $this->setWorship($mtg[0][6]);
        $this->setMeal($mtg[0][7]);
        $this->setMealGuests($mtg[0][8]);
        $this->setNursery($mtg[0][9]);
        $this->setChildren($mtg[0][10]);
        $this->setYouth($mtg[0][11]);
        $this->setNotes($mtg[0][12]);
        $this->setDonationAmount($mtg[0][13]);
        $this->setReader1($mtg[0][14]);
        $this->setReader2($mtg[0][15]);
        $this->setNurseryFac($mtg[0][16]);
        $this->setChildrenFac($mtg[0][17]);
        $this->setYouthFac($mtg[0][18]);
        $this->setMealFac($mtg[0][19]);
        $this->setCafeFac($mtg[0][20]);
        $this->setTransportation($mtg[0][21]);
        $this->setSetup($mtg[0][22]);
        $this->setTeardown($mtg[0][23]);
        $this->setGreeter1($mtg[0][24]);
        $this->setGreeter2($mtg[0][25]);
        $this->setResources($mtg[0][26]);
        $this->setSerenity($mtg[0][27]);
        $this->setAv($mtg[0][28]);
        $this->setAnnouncements($mtg[0][29]);
        $this->setSecurity($mtg[0][30]);
    }
}


?>