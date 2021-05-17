// ajax script for getting colleges of perticular university.
$(document).on('change','#uni', function(){
    var uniID = $(this).val();
    // console.log(uniID);
    if(uniID){
        $.ajax({
            type:'POST',
            url:'dropdown_uni_to_college.php',
            data:{'uni_id':uniID},
            success:function(result){
                $('#college').html(result);
               
            }
        }); 
    }else{
        $('#college').html('<option value=""> College Name</option>');
    }
});





$(document).on('click','#add_uni_btn', function(){
    
//ajax script for add new university which is not in the list.    
    var new_uni = $('#add_uni').val();
    if(new_uni){
        $.ajax({
            type:'POST',
            url:'add_new_university.php',
            dataType: 'JSON',
            data:{'new_uni':new_uni},
            complete:function(data){
                // alert(JSON.stringify( data ));   <-- if use success instead of complete.
                if(data.responseJSON.isadd === "success") {
                    $('#msg1').addClass("successmsg");
                    $('#msg1').html("University added successfully.")
                }
                if(data.responseJSON.isadd === "error") {
                    $('#msg1').addClass("errormsg");
                    $('#msg1').html("University already present in the list");
                }
            }
        }); 
    } else {
        $('#msg1').addClass("errormsg");
        $('#msg1').html("invalid university ");
    }

    document.getElementById('add_uni').value = ''

// change university drop down list dynamically.    
    $.ajax({
        type:'GET',
        url:'dropdown_uni.php',
        success:function(result){
            $('#uni').html(result);
           
        }
    });     
});






$(document).on('click','#add_clg_btn', function(){

//ajax script for add new college which is not in the list.    
    var new_clg = $('#add_clg').val();
    var uniID = $('#uni').val()
    if(new_clg && uniID){
        $.ajax({
            type:'POST',
            url:'add_new_college.php',
            data:{'new_clg':new_clg, 'uniID' : uniID},
            dataType: 'JSON',
            complete: function (data) {
                // alert(JSON.stringify( data.responseJSON.isadd ));
                if(data.responseJSON.isadd === "success") {
                    $('#msg2').addClass("successmsg");
                    $('#msg2').html("College added successfully.")
                }
                if(data.responseJSON.isadd === "error") {
                    $('#msg2').addClass("errormsg");
                    $('#msg2').html("College already present in the list");
                }
            }
        }); 
    } else if(!uniID) {
        $('#msg2').addClass("errormsg");
        $('#msg2').html("university is not selected");
    } else {
        $('#msg2').addClass("errormsg");
        $('#msg2').html("college name is invalid");
    }

// change college drop down list dynamically.    
    $.ajax({
        type:'GET',
        url:'dropdown_uni_to_college.php',
        success:function(result){
            $('#college').html(result);
        
        }
    });        
    
});





$(document).on('click','#add_branch_btn', function(){
    
    //ajax script for add new branch which is not in the list.    
        var new_branch = $('#add_branch').val();
        if(new_branch){
            
           $response = $.ajax({
                type:'POST',
                url:'add_new_branch.php',
                data:{new_branch:new_branch},
                dataType: 'JSON',
                complete : function (data) {
                    // alert(JSON.stringify( data ));      <-- if use success instead of complete.
                    if(data.responseJSON.isadd === "success") {
                        $('#msg3').addClass("successmsg");
                        $('#msg3').html("Branch added successfully.");
                    }
                    if(data.responseJSON.isadd === "error") {
                        $('#msg3').addClass("errormsg");
                        $('#msg3').html("Branch already present in the list");
                        // console.log("error");
                    }
                }
            })

        } else {
            $('#msg3').addClass("errormsg");
            $('#msg3').html("invalid branch ");
        }
    
        document.getElementById('add_branch').value = ''
    
    // change branch drop down list dynamically.    
        $.ajax({
            type:'GET',
            url:'dropdown_branch.php',
            success:function(result){
                $('#branch').html(result);
               
            }
        });     
    });
    
