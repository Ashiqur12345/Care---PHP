function showNotification(){
    let msg = findGetParameter('msg');
    let msgtype = findGetParameter('msgtype');
    

    if(msg != null){
         $.notify({
            title: "",
            message: msg
        },{
            type: msgtype != null ? msgtype : 'info'
        });
    }                         
}


function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
        tmp = item.split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}