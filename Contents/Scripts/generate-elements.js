function intro(){
    //Bot says
    createQuestion("Hello "+patient.Name+"! I am Smileybot. I can help you detecting your disease. How are you?");

    //Intro fields
    let str = "";
    str += '<div>';
    str += '<input type="submit" class="btn btn-link" onclick="setIntro(event);" value="I am fine. Thanks.">' ;
    str += '<input type="submit" class="btn btn-link" onclick="setIntro(event);" value="I am not feeling well.">';
    str += '</div>';
    createAnswer(str);
    scrollToBottom();
}

function createQuestion(msg){
    let str = '<div class="question"><div class="panel-info"><img width="30px" src="Contents/Images/icon-bot.png"><br><div class="panel-heading">'
        +msg+'</div><div class="panel-body"></div></div></div>';
        
    document.getElementById('chat-window').appendChild(markUpToDomObject(str));
    //document.getElementById('chat-window').innerHTML = str + document.getElementById('chat-window').innerHTML;
}

function createAnswer(msg){
    let str = '<div class="reply"><div class="panel-default"><img width="30px" src="Contents/Images/icon-human.png"><br><div class="panel-heading">'
        +msg+'</div><div class="panel-body"></div></div></div>';
        
    document.getElementById('chat-window').appendChild(markUpToDomObject(str));
    //document.getElementById('chat-window').innerHTML = str + document.getElementById('chat-window').innerHTML;
}

function markUpToDomObject(str){
    let div = document.createElement('div');
    div.innerHTML = str;
    return div.firstChild;
}

function answerButtons(data){

    if(data.Binary){
        sympName = "'" + data.Name + "'";
        return '<button onclick="answer(true,'+ sympName +',event);" class="btn btn-md btn-success">Yes</button>'
                +'<button onclick="answer(false,'+ sympName +',event);" class="btn btn-md btn-danger">No</button>';

    }
    else{
        let buttons = '';
        data.Chain.forEach( function(element, index ) {
            let name = "'" + element + " " + data.Name + "'";
            buttons +=  '<button onclick="answer(true,'+ name +', event);" class="btn btn-md btn-default fresh">'
                    +   element
                    +   '</button>'+'<br>';
        });
        return buttons;
    }
}

function showDiseaseInModal(data){

    let disease = data[0];

    let str = '<pre>';

    str += 'Name:&Tab;<b>'+patient.Name+"</b><br>";
    str += "Age:&Tab;<b>"+patient.Age+"</b><br>";
    str += "Sex:&Tab;<b>"+patient.Sex+"</b><br>";

    str += "Patient Symptom(s):<br>";
    patient.Symptoms.forEach(function(element, index ) {   
        str += "&Tab;<b>"+element+"</b><br>";
    });

    // str += "Patient Non-Symptom(s): <br>";
    // patient.NotSymptoms.forEach(function(element, index ) {   
    //     str += "&Tab;<b>"+element+"</b><br>";
    // });

    // if(patient.NotSymptoms.length <= 0){
    //     str += "&Tab;None<br>";
    // }
    // if(patient.NotSymptoms.length <= 0){
    //     str += "&Tab;None<br>";
    // }

    str += "Disease Symptom(s): <br>";
    disease.Disease.Symptoms.forEach(function(element, index ) {   
        if(patient.Symptoms.indexOf(element) > -1){
            str += "&Tab;<span class='matched'><b>"+element+"</b></span><br>";
        }
    });
    
    disease.Disease.Symptoms.forEach(function(element, index ) {   
        if(patient.Symptoms.indexOf(element) < 0){
            str += "&Tab;<span class='mismatched'><b>"+element+"</b></span><br>";
        }
    });

    

    if(patient.Symptoms.length > 0){
        str += "Predicted Disease:&Tab;<b>"+ disease.Disease.Name+"</b><br>";
    }
    else{
        str += "Predicted Disease:&Tab;<b>NaN</b><br>";
    }

    

    str += "Disease Probability:&Tab;<b>"+disease.Probability*100+" % </b><br>";

    str += '</pre>';

    str += '<div>';
    str += '<button class="btn btn-md btn-link" onclick="fetchDoctorInfo(\''+disease.Disease.Field+'\', event)">Find doctor</button>';
    str += '</div>';

    let targetDivId = "'modalcontainer'";
    let printReportButton = '<button class="btn btn-md btn-primary" onclick="PrintElem('+targetDivId+')"><i class="fas fa-print fa-fw"></i> Print</button>';
    modal('Report',str,printReportButton);
    showModal();
}

function showReport(data){

    document.getElementById('report-window-btns').style.display = 'inline';
    let disease = data[0];
    patient.Disease = disease;

    let str = '<pre>';
    str += '<h4>Report</h4>';

    if(patient.Symptoms.length > 0){
        str += "<h3><span style='color: red;'>"+ disease.Disease.Name+"</span> detected </h3>";
    }

    str += 'Patient Name:&Tab;<b>'+patient.Name+"</b><br>";
    str += "Age:&Tab;&Tab;<b>"+patient.Age+"</b><br>";
    str += "Sex:&Tab;&Tab;<b>"+patient.Sex+"</b><br>";

    str += "Patient Symptom(s):<br>";
    patient.Symptoms.forEach(function(element, index ) {   
        str += "&Tab;&Tab;<b>"+element+"</b><br>";
    });

    str += "Disease Symptom(s): <br>";
    disease.Disease.Symptoms.forEach(function(element, index ) {   
        if(patient.Symptoms.indexOf(element) > -1){
            str += "&Tab;&Tab;<span class='matched'><b>"+element+"</b></span><br>";
        }
    });
    
    disease.Disease.Symptoms.forEach(function(element, index ) {   
        if(patient.Symptoms.indexOf(element) < 0){
            str += "&Tab;&Tab;<span class='mismatched'><b>"+element+"</b></span><br>";
        }
    });

    if(patient.Symptoms.length > 0){
        str += "Predicted Disease:&Tab;<b>"+ disease.Disease.Name+"</b><br>";
    }
    else{
        str += "Predicted Disease:&Tab;<b>NaN</b><br>";
    }

    str += "Disease Probability:&Tab;<b>"+disease.Probability*100+" % </b><br>";
    str += '</pre>';
    str += "<pre></pre>";
    document.getElementById('report-window').innerHTML = str;
    
    $('html, body').animate({
        scrollTop: $("#report-window").offset().top
    }, 2000);
}