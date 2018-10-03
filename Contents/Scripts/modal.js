
    function modal(title, msg, summary){

        let str = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'
                + '<div class="modal-dialog" role="document">'
                + '<div class="modal-content">';

            if(title != null && title != ""){
              str +=  '<div class="modal-header">'
                    + '<h4 class="modal-title" id="myModalLabel">'
                    + title
                    + '</h4>'
                    + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    + '</div>';
            }


            if(msg != null && msg != ""){
              str +=  '<div class="modal-body">'
                        +msg
                      +'</div>';
            }


            if(summary != null && summary != ""){
              str +=  '<div class="modal-footer">'
                    + summary
                    + '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                    + '</div>';
            }
          
            str +=  '</div></div></div>';

      document.getElementById("modalcontainer").innerHTML = str;
    }

    function showModal(){
      $('#myModal').modal('show');
    }

    function hideModal(){
      $('#myModal').modal('hide');
    }

    function toggleModal(){
       $('#myModal').modal('toggle');
    }


    /*<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="modal('w','x','y');">
      Launch demo modal
    </button>*/