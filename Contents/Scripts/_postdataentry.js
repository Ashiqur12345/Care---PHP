function insertNewFieldSubmit(){

    let key = document.forms['insertfieldform'][0].value;

    let data = new FormData();

    data.append('option', 'field');
    data.append('fieldname', key);
    
    let url = 'Backend/_postentrydata.php';

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('POST',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            console.log("In insertNewFieldSubmit()",this.responseText);
            let obj = JSON.parse(this.responseText);

            $.notify({
                message: obj.msg
            },{
                type: obj.msgtype
            });
        }
    }
    xhttp.send(data);

    return false;
}

function insertNewDiseaseSubmit(){

    let field = document.forms['insertdiseaseform'][0].value;
    let disease = document.forms['insertdiseaseform'][1].value;

    let data = new FormData();

    data.append('option', 'disease');
    data.append('fieldname', field);
    data.append('diseasename', disease);

    let url = 'Backend/_postentrydata.php';

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('POST',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            console.log("In insertNewDiseaseSubmit()",this.responseText);

            let obj = JSON.parse(this.responseText);

            $.notify({
                message: obj.msg
            },{
                type: obj.msgtype
            });
        }
    }
    xhttp.send(data);

    return false;
}

function insertNewTreatmentSubmit(){

    let disease = document.forms['inserttreatmentform'][0].value;
    let treatment = document.forms['inserttreatmentform'][1].value;

    let data = new FormData();

    data.append('option', 'treatment'); 
    data.append('diseasename', disease);
    data.append('treatmentname', treatment);

    let url = 'Backend/_postentrydata.php';

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('POST',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            console.log("In insertNewTreatmentSubmit()",this.responseText);

            let obj = JSON.parse(this.responseText);

            $.notify({
                message: obj.msg
            },{
                type: obj.msgtype
            });
        }
    }
    xhttp.send(data);

    return false;
}


function insertNewDoctorSubmit(){

    let doctorname = document.forms['insertdoctorform'][0].value;
    let fieldname = document.forms['insertdoctorform'][1].value;
    let contact = document.forms['insertdoctorform'][2].value;
    let location = document.forms['insertdoctorform'][3].value;

    let data = new FormData();

    data.append('option', 'doctor'); 
    data.append('doctorname', doctorname);
    data.append('fieldname', fieldname);
    data.append('contact', contact);
    data.append('location', location);

    let url = 'Backend/_postentrydata.php';

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('POST',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            console.log("In insertNewDoctorSubmit()",this.responseText);

            let obj = JSON.parse(this.responseText);

            $.notify({
                message: obj.msg
            },{
                type: obj.msgtype
            });
        }
    }
    xhttp.send(data);

    return false;
}