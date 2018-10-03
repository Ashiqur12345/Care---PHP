
function setDiseaseAsCured(recordID, targetUserID){

    let data = new FormData();

    data.append('recordID', recordID);
    data.append('userid', targetUserID);
    data.append('setCured', 1);
    data.append('option', 'update');

    let url = 'Backend/_updaterecord.php';

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('POST',url,true);

    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            console.log("In setDiseaseAsCured()",this.responseText);

            let obj = JSON.parse(this.responseText);
            if(obj.success)location.reload();
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
function deleteRecord(recordID, targetUserID){

    let deleteBtn = '<input type="button" class="btn btn-danger" value="Delete" onclick="confirmDelete('+recordID+','+targetUserID+')">';
    modal("Are you sure?", "",deleteBtn);
    showModal();
    return false;

}

function confirmDelete(recordID, targetUserID){
        let data = new FormData();

    data.append('recordID', recordID);
    data.append('userid', targetUserID);
    data.append('option', 'delete');

    let url = 'Backend/_updaterecord.php';

    let xhttp=new XMLHttpRequest();
            
    xhttp.open('POST',url,true);

    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

            console.log("In deleteRecord()",this.responseText);

            let obj = JSON.parse(this.responseText);
            if(obj.success)location.reload();
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



function viewPrimaryTreatment(diseasename){
    let xhttp=new XMLHttpRequest();
                        
    xhttp.open('GET','Backend/_getprimarytreatment.php?diseasename='+diseasename,true);
    xhttp.send();
    xhttp.onreadystatechange=function(){
        //hidePleaseWait();
        if(this.readyState==4 && this.status==200){
            console.log(this.responseText);
            let obj = JSON.parse(this.responseText);
            if(obj.success){
                
                let str = "<h5>Primary Treatment(s): </h5><ul class='list-group'>";
                obj.treatments.forEach(function(element, index) {
                    str += "<li class='list-group-item'>"+element+"</li>";
                });
                modal(diseasename, str,"");
                showModal();
            }
            else{
                $.notify({
                    message: "<b>Sorry</b>, no treatment was found"
                },{
                    type: "danger",
                });
            }            
        }
    }
}