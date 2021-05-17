
$(document).on('click','#writeNews', function(){
    // let chosen = document.getElementById('writeNews').value;
    // alert(chosen);

    let output =    '<textarea class="form-control" id="myeditor" name="myeditor"></textarea>' +
                    '<script type="text/javascript"> CKEDITOR.replace("myeditor"); </script>';

    $('#news-area').html(output);

});

$(document).on('click','#uploadNewsPdf', function(){
    // let chosen = document.getElementById('uploadNewsPdf').value;
    // alert(chosen);

    let output =    '<div class="form-group m-1">' +
                    '<label for="upload"> <b>attach files : </b></label> &emsp;' +
                    '<input name="upload" type="file" id="upload" multiple="multiple" class="btn btn-light" />' +
                    '<small>maximum file size : 1 GB</small>' +
                    '</div>';
                
    $('#news-area').html(output);

});

function extractID(ID) {
    var matches = ID.match(/(\d+)/);
      
    if (matches) {
      return matches[0];
    }
  }
  


$('body').on('click', '#save', function(e) {
    e.preventDefault();

    var headline = $("#heading").val();
    console.log("headline : " + headline);

    var getSelectedValue = document.querySelector( 'input[name="news-input-type"]:checked').value;   
    if(getSelectedValue) {   
          console.log("Selected radio button values is: " + getSelectedValue);  
    }

    visible_to = $("#who").val();
    console.log(visible_to);

    if(headline){
        if (getSelectedValue === "writeNews") {
            html_to_pdf(headline, getSelectedValue, visible_to);

        } else if(getSelectedValue === "uploadNewsPdf") {

            var fd = new FormData();
            var files = $('#upload')[0].files;
            
           // Check file selected or not
            if(files.length > 0 ){
                console.log(files[0].name);
               fd.append('upload',files[0]);
               fd.append('headline',headline);
               fd.append('visible_to',visible_to);
            }
            // console.log(fd.get('headline') );
        
            if(fd.get('upload')) {
                $.ajax({
                    type:'POST',
                    url:'/upload_news_pdf.php',
                    data : fd,
                    processData: false,
                    contentType: false,
        
                    complete: function (data) {
                        // console.log(data.responseText);
                        $("#responseMsg").html( data.responseText );
                        $("#heading").val('');
                        $('#upload').val('');
                    }
                });
            } else {
                $("#responseMsg").html("<div class='alert alert-danger'>PDF is <strong>not uploaded</strong>, upload it.</div>");
            }
        }
    } else {
        $("#responseMsg").html("<div class='alert alert-danger'>News headline can't be Empty.</div>");
    }

 });


function html_to_pdf(headline, news_input_type, visible_to) {

    if(headline){
        if (news_input_type === "writeNews") {

            var news_data = CKEDITOR.instances['myeditor'].getData();
            // console.log(news_data);

            if(news_data) {
                $.ajax({
                    type:'POST',
                    url:'/html_to_pdf.php',
                    data:{
                        'visible_to' : visible_to,
                        'headline' : headline,
                        'news_data': news_data
                    },
                    dataType: 'JSON',
                    complete: function (data) {
                      console.log( JSON.stringify(data) );

                      if(data.responseJSON.msg != "success") {
                        $("#responseMsg").html(data.responseJSON.msg);
                        delete_file(data.responseJSON.newfile_name);

                      } else {
                        $("#responseMsg").html( "<div class='alert alert-success '> news has been submitted successfully. <br />" +
                                                "once it's approved, it will be published on our news section. </div>");
                        $("#heading").val('');
                        CKEDITOR.instances['myeditor'].setData('');

                      }
                    }
                });

            } else {
                $("#responseMsg").html("<div class='alert alert-danger'>News can't be Empty.</div>");
            }

        } else {
            $("#responseMsg").html("<div class='alert alert-danger'>News headline can't be Empty.</div>");
        }
    }
}

function delete_file(file_name) {
    $.ajax({
        type:'POST',
        url:'/delete_file.php',
        data:{
            "file_name" : file_name
        },
        dataType: 'JSON',
        complete: function (data) {
            console.log("file deleted successfully");
        }
    });
}