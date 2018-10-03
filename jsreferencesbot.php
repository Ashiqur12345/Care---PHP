<?php
    include_once('Backend/_authcheck.php');
    include_once('./Backend/_dbconnect.php');
    if(!authCheck()){header("Location: signin.php?msg=Sign in first&msgtype=warning");die();}

    $name = getUserName();
    $userID = getUserID();
    $email = getUserEmail();
    $age = 0;
    $gender = "Other";

    $sql = 'SELECT * FROM `users` WHERE `User ID` = "'.getUserID().'"';

    $result = $conn->query($sql);

    $conn->close();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $gender = $row["Gender"];

        $sqlDate = $row["Birth Date"];
        $sqlDateExplosed = explode("-", $sqlDate);
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = $sqlDateExplosed[1]."/".$sqlDateExplosed[2]."/".$sqlDateExplosed[0];
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
        
    }

?>
    <!-- Bot js files -->
    <script src="Contents/Scripts/modal.js"></script>
    <script src="Contents/Scripts/print-div.js"></script>
    <script src="Contents/Scripts/wait.js"></script>
    <!-- <script src="Contents/Scripts/declarations.js"></script> -->
    <script src="Contents/Scripts/generate-elements.js"></script>
    <script src="Contents/Scripts/operations.js"></script>
    <!-- End bot js files -->


    <script>
        
        var patient = {
        Id: 0,
        Symptoms: [],
        NotSymptoms: [],
        Name: "",
        Sex: "",
        Age: 0,
        Disease: null
    };

    let diseaseProb = {
        Disease: {
            Name: "",
            Symptoms: []
        },
        Probability: 0
    };

    let conversationCount = 0;
    let scroll = false;

    // let urlPrefix = window.location.protocol + '//' + window.location.hostname;
    // if (window.location.port != 0 || window.location.port != null) urlPrefix += ':' + window.location.port;

    let urlPrefix = "http://www.ashman.somee.com";

    function init() {

        conversationCount = 0;
        scroll = false;

        patient.Id = "<?php echo $userID?>";
        patient.Name = "<?php echo $name?>";
        patient.Sex = "<?php echo $gender?>";
        patient.Age = <?php echo $age?>;
        patient.Symptoms = [];
        patient.NotSymptoms = [];
        patient.Disease = null;

        document.getElementById('chat-window').innerHTML = "";
        document.getElementById('bottom-div').style.display = 'none';
        intro();
    }
    
    </script>