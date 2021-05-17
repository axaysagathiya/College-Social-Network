
function extractID(ID) {
  var matches = ID.match(/(\d+)/);
    
  if (matches) {
    return matches[0];
  }
}




function addFriend(to_user) {
   
  var to_userID = extractID(to_user);

  if(to_userID){

    $.ajax({
        type:'POST',
        url:'/relation_lib/addFrndRequest.php',
        data:{'to_userID' : to_userID},
        dataType: 'JSON',
        complete: function (data) {
          // console.log( JSON.stringify(data) );

          if(data.responseJSON.msg==="success") {
            console.log("successfully Requested.");

            var newID = "canceladdFrnd"+to_userID;
            $("#" + to_user).attr("onclick","canceladdFriend(this.id)");
            $("#" + to_user).html("Requested");
            $("#" + to_user).attr("id", newID);

          } else {
            alert(data.responseJSON.msg);
          }
        }
    }); 
  }
}
  



function canceladdFriend(to_user) {
  var to_userID = extractID(to_user);

  if(to_userID){
    $.ajax({

        type:'POST',
        url:'/relation_lib/cancel_addFrndRequest.php',
        data:{'to_userID' : to_userID},
        dataType: 'JSON',
        complete: function (data) {
          // console.log( JSON.stringify(data) );

          if(data.responseJSON.msg==="success") {
            console.log("successfully Revoked.");

            var newID = "addFrnd"+to_userID;
            $("#" + to_user).attr("onclick","addFriend(this.id)");
            $("#" + to_user).html("<i class='bi bi-person-plus-fill'></i> add Friend");
            $("#" + to_user).attr("id", newID);

          } else {
          alert(data.responseJSON.msg);
          }
        }
    }); 
  }
}



function unFriend(to_user) {
  var to_userID = extractID(to_user);

  if(to_userID){
    $.ajax({

      type:'POST',
      url:'/relation_lib/unFrnd.php',
      data:{'to_userID' : to_userID},
      dataType: 'JSON',
      complete: function (data) {
        var newID = "addFrnd"+to_userID;
        // console.log( JSON.stringify(data.) );
        if(data.responseJSON.msg==="success") {
          console.log("successfully unfriend.");

          $("#" + to_user).attr("onclick","addFriend(this.id)");
          $("#" + to_user).html("<i class='bi bi-person-plus-fill'></i> add Friend");
          $("#" + to_user).attr("id", newID);
          
        } else {
          alert(data.responseJSON.msg);
        }
      }
    }); 
  }
}

function block_user(to_user) {
  var to_userID = extractID(to_user);

  if(to_userID){
    $.ajax({

      type:'POST',
      url:'/relation_lib/block_user.php',
      data:{'to_userID' : to_userID},
      dataType: 'JSON',
      complete: function (data) {
        var newID = "unblock"+to_userID;
        // console.log( JSON.stringify(data.) );
        if(data.responseJSON.msg==="success") {
          console.log("successfully blocked.");

          unfrnd_btn_id = "unFrnd"+to_userID;
          addfrnd_btn_id = "addFrnd"+to_userID;
          canceladdFrnd_btn_id = "canceladdFrnd"+to_userID;

          $("#" + unfrnd_btn_id).remove();
          $("#" + addfrnd_btn_id).remove();
          $("#" + canceladdFrnd_btn_id).remove();
          $("#msg_btn").remove();
          $("#" + to_user).attr("onclick","unblock_user(this.id)");
          $("#" + to_user).html("unblock");
          $("#" + to_user).attr("id", newID);
          
        } else {
          alert(data.responseJSON.msg);
        }
      }
    }); 
  }
}

function unblock_user(to_user) {
  var to_userID = extractID(to_user);

  if(to_userID){
    $.ajax({

      type:'POST',
      url:'/relation_lib/unblock_user.php',
      data:{'to_userID' : to_userID},
      dataType: 'JSON',
      complete: function (data) {
        var newID = "block"+to_userID;
        // console.log( JSON.stringify(data.) );
        if(data.responseJSON.msg==="success") {
          console.log("successfully unblocked.");

          add_frnd_btn_dynamic = '<a href="#" class="btn btn-sm btn-primary" name="addFrndBtn" id="addFrnd' + to_userID + '" onclick="addFriend(this.id);"> <i class="bi bi-person-plus-fill"></i> add Friend </a>';

          $("#" + to_user).attr("onclick","block_user(this.id)");
          $("#" + to_user).html("Block");
          $("#" + to_user).attr("id", newID);
          $("#imgid").after(add_frnd_btn_dynamic);
          // alert(add_frnd_btn_dynamic);
          
        } else {
          alert(data.responseJSON.msg);
        }
      }
    }); 
  }
}