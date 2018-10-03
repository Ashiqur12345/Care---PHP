       
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