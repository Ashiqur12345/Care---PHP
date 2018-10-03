function setNameAndAge(event){
    nameTxt = document.getElementById('usrName');

    if(nameTxt.value == null || nameTxt.value.length < 3){
        nameTxt.parentNode.setAttribute("class", "has-error");
        return;
    }
    else{
        patient.Name = nameTxt.value;
        nameTxt.parentNode.removeAttribute("class", "has-error");
    }

    ageTxt = document.getElementById('usrAge');

    if(ageTxt.value < 5){
        ageTxt.parentNode.setAttribute("class", "has-error");
        return;
    }
    else{
        patient.Age = ageTxt.value;
        ageTxt.parentNode.removeAttribute("class", "has-error");
    }
    nameTxt.parentNode.setAttribute("class", "has-success");
    nameTxt.disabled = true;
    ageTxt.parentNode.setAttribute("class", "has-success");
    ageTxt.disabled = true;

    patient.Sex = event.target.defaultValue;

    event.target.parentNode.childNodes.forEach(function(element, index ) {
        element.disabled = true;
        element.setAttribute("class", "btn btn-default");
    });
    event.target.setAttribute("class", "btn btn-success");    

    continueConversation();
}

function setIntro(event){
    event.target.disabled = true;
    event.target.parentNode.childNodes.forEach(function(element, index ) {
        if(event.target !== element){
            event.target.parentNode.removeChild(element);
        }
    });
    if(event.target.value.includes("fine")){
        createQuestion("It's very nice to hear that. If you feel unwell you can come back to me any time.");
    }
    else if(event.target.value.includes("not")){
        createQuestion("It's very sad to hear that. Let me ask you some questions.");
        continueConversation();
    }    
}

function continueConversation(){

    fetchNextSymptom();
       
    conversationCount++;
    if(conversationCount >= 3){
        document.getElementById('bottom-div').style.display = 'block';
    }
    scroll = true;    
}

setInterval(scrollToBottom,1);

function scrollToBottom(){

    if(scroll){
        if(document.getElementById('chat-window').scrollTop<(document.getElementById('chat-window').scrollHeight-document.getElementById('chat-window').offsetHeight)){-1
            document.getElementById('chat-window').scrollTop = document.getElementById('chat-window').scrollTop + 10;
        }
        else{
            scroll = false;
        }
    }   
}

function predictDisease() {
    
    if(patient.Symptoms.length < 2){
        modal('More symptoms required','','');
        showModal();
        return;
    }

    var symptoms = patient.Symptoms;
    // showPleaseWait();
    $.ajax({
        url: urlPrefix + '/api/estimate/prob/',
        dataType: "json",
        type: "GET",
        contentType: 'application/json; charset=utf-8', //define a contentType of your request
        data: { symptoms: JSON.stringify(symptoms) },
        success: function (data) {
            // hidePleaseWait();
            showReport(data);
        },
        error: function (xhr) {
            // hidePleaseWait();
        }
    });
}

function fetchNextSymptom(){
    // showPleaseWait();

    var state = { Symptoms: patient.Symptoms, NotSymptoms: patient.NotSymptoms};

    $.ajax({
        url: urlPrefix + '/api/symptom/next/',
        dataType: "json",
        type: "GET", 
        contentType: 'application/json; charset=utf-8', 
        data: { state: JSON.stringify(state) },
        success: function (data) {
            // hidePleaseWait();
            
            if(data != null){
                processBotSentence(data);
                processPatientSentence(data, true);
            }
            else{
                //No more symptoms
                predictDisease();
            }
        },
        error: function (xhr) {
            // hidePleaseWait();
            modal('Error !','Failed to fetch symptoms','');
            showModal();
        }
    });
}

function fetchChainSymptom(sym, buttonClickEvent){
    // showPleaseWait();

    $.ajax({
        url: urlPrefix + '/api/symptom/'+sym+'/chain',
        dataType: "json",
        type: "GET", 
        success: function (data) {
            // hidePleaseWait();
            if(data != null){
                processBotSentence(data);
                processPatientSentence(data, false);
            }
            else{
                patient.Symptoms.push(sym);
                continueConversation();
            }
            deactivateButtons(buttonClickEvent);
        },
        error: function (xhr) {
            // hidePleaseWait();
            modal('Error !','Failed to fetch symptom properties','');
            showModal();
        }
    });
}

function fetchDoctorInfo(disease, event){

    let btnText = event.target.innerText;
    event.target.innerText = "Please wait...";
    
    $.ajax({
        url: urlPrefix + '/api/doctor/'+disease+'/info',
        dataType: "json",
        type: "GET", 
        async: false,
        success: function (data) {
            if(data != null){
                event.target.innerText = "Contact any of the following doctors immediately"
                event.target.disabled = true;
                
                let msg = "<pre>";
                data.forEach(function(element, index )  {
                    msg += "Name:&Tab;&Tab;<b>"+element.Name+"</b><br>";
                    msg += "Expertise:&Tab;<b>"+element.Expertise+"</b><br>";
                    msg += "Contact:&Tab;<a href='tel:'"+element.Contact+"' ><b>"+element.Contact+"</b></a><br>";
                    msg += "Location:&Tab;<b>"+element.Location+"</b><br><br>";                   
                });
                msg += "</pre>";    
                event.target.parentNode.innerHTML += msg+'<br>';
                
            }
            else{
                event.target.parentNode.innerHTML += 'No doctor found<br>';
                event.target.innerText = btnText;
            }
            
        },
        error: function (xhr) {
            event.target.innerText = btnText;
        }
    });
}

function processBotSentence(data){
    //Do the processing stuff
    createQuestion(data.Query);
}

function processPatientSentence(data, binary){
    //Do the processing stuff
    //Binary means yes no question

    data.Binary = binary;
    createAnswer(answerButtons(data));
    scroll = true;
}

function answer(bool, data, event){

    if(bool){
        fetchChainSymptom(data, event);
    }
    else{
        patient.NotSymptoms.push(data);
        deactivateButtons(event);
        continueConversation();
    }

    console.log(patient);
}

function deactivateButtons(event){
    
    event.target.disabled = true;

    event.target.parentNode.childNodes.forEach(function(element, index ) {
        element.disabled = true;
        element.setAttribute('class', 'btn btn-md btn-default');
    });

    if(event.target.innerHTML === 'No'){
        event.target.setAttribute('class', 'btn btn-md btn-warning');
    }
    else{
        event.target.setAttribute('class', 'btn btn-md btn-success');
    }
}
