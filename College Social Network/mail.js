function resend() {
   
    var mail = $('#mailHidden').val();
    alert(mail)

    // if(to_userID){
  
    //   $.ajax({
    //       type:'POST',
    //       url:'/relation_lib/addFrndRequest.php',
    //       data:{'to_userID' : to_userID},
    //       dataType: 'JSON',
    //       complete: function (data) {
    //         // console.log( JSON.stringify(data) );
  
    //         if(data.responseJSON.msg==="success") {
    //           console.log("successfully Requested.");
  
    //           var newID = "canceladdFrnd"+to_userID;
    //           $("#" + to_user).attr("onclick","canceladdFriend(this.id)");
    //           $("#" + to_user).html("Requested");
    //           $("#" + to_user).attr("id", newID);
  
    //         } else {
    //           alert(data.responseJSON.msg);
    //         }
    //       }
    //   }); 
    // }
  });