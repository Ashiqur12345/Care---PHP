function fetchFieldNames(event){

    let fieldname = event.target.value;
    
    let url = 'Backend/_getentrydata.php?fieldname='+fieldname;

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('GET',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            // console.log("fetch",this.responseText);
            document.getElementById('fieldnames').innerHTML = this.responseText;             
        }
    }
    xhttp.send();
}

function fetchDiseaseNames(event){
    
    let disease = event.target.value;
    
    let url = 'Backend/_getentrydata.php?diseasename='+disease;

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('GET',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            // console.log("fetch",this.responseText);
            document.getElementById('diseasenames').innerHTML = this.responseText;             
        }
    }
    xhttp.send();
}


function fetchTreatments(event){

    let treatment = event.target.value;

    let url = 'Backend/_getentrydata.php?treatment='+treatment;

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('GET',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            // console.log("fetch",this.responseText);
            document.getElementById('treatments').innerHTML = this.responseText;             
        }
    }
    xhttp.send();
}

function fetchDoctorLocations(event){

    let location = event.target.value;

    let url = 'Backend/_getentrydata.php?location='+location;

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('GET',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            // console.log("fetch",this.responseText);
            document.getElementById('locations').innerHTML = this.responseText;             
        }
    }
    xhttp.send();
}

function fetchDoctorNames(event){

    let doctornames = event.target.value;

    let url = 'Backend/_getentrydata.php?doctornames='+doctornames;

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('GET',url,true);
    
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            // console.log("fetch",this.responseText);
            document.getElementById('doctornames').innerHTML = this.responseText;             
        }
    }
    xhttp.send();
}