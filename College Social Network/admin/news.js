function extractID(ID) {
    var matches = ID.match(/(\d+)/);
      
    if (matches) {
      return matches[0];
    }
  }


function publishNews(news_id) {

    var newsID = extractID(news_id);
    var newsRowID = "newsRow"+newsID;
    // alert(news_id + "  :  " + newsID);

    if(newsID) {
        $.ajax({
            type:'POST',
            url:'publish_news.php',
            data:{'newsID' : newsID},
            dataType: 'JSON',
            complete: function (data) {
              console.log( JSON.stringify(data) );
    
              if(data.responseJSON.isdone === "yes") {
                // alert(newsRowID);
                $("#responseDiv").html( '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                          'News haas been <strong>Published</strong> successfully.' +
                                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                          '</button>' +
                                        '</div>' 
                                      );                
                $("#" + newsRowID).remove();

              } else {
                $("#responseDiv").html( '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                          'Unable to <strong>Publish</strong>.' +
                                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                          '</button>' +
                                        '</div>' 
                                      );
              }
            }
        });
    }
}




function rejectNews(news_id) {

  var newsID = extractID(news_id);
  var newsRowID = "newsRow"+newsID;
  // alert(news_id + "  :  " + newsID);

  if(newsID) {
      $.ajax({
          type:'POST',
          url:'reject_news.php',
          data:{'newsID' : newsID},
          dataType: 'JSON',
          complete: function (data) {
            // console.log( JSON.stringify(data) );
  
            if(data.responseJSON.isdone === "yes") {
              // alert(newsRowID);
              $("#responseDiv").html( '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                        'News haas been <strong>rejected</strong> successfully.' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                          '<span aria-hidden="true">&times;</span>' +
                                        '</button>' +
                                      '</div>' 
                                    );              
              $("#" + newsRowID).remove();

            } else {
              $("#responseDiv").html( '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                        'Unable to <strong>rejected</strong>.' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                          '<span aria-hidden="true">&times;</span>' +
                                        '</button>' +
                                      '</div>' 
                                    );           
            }
          }
      });
  }
}


function editHeadline(news_id) {
  var newsID = extractID(news_id);
  var curr_headline_id = "headline"+newsID;
  var edit_headline_id = "editHeadline"+newsID;
  var new_headline = $("#" + edit_headline_id).val();
  // alert(newsID + "  :  " + headline);

  if(newsID) {
      $.ajax({
          type:'POST',
          url:'edit_news_headline.php',
          data:{
            'newsID' : newsID,
            'headline' : new_headline
          },
          dataType: 'JSON',
          complete: function (data) {
            // console.log( JSON.stringify(data) );
  
            if(data.responseJSON.isdone === "yes") {
              // alert(newsRowID);
              $("#responseDiv").html( '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                        'News Headline haas been <strong>EDITED</strong> successfully.' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                          '<span aria-hidden="true">&times;</span>' +
                                        '</button>' +
                                      '</div>' 
                                    );
              $('#' + curr_headline_id).html(new_headline);
              
            } else {
              $("#responseDiv").html( '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                        'Unable to <strong>EDIT</strong>.' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                          '<span aria-hidden="true">&times;</span>' +
                                        '</button>' +
                                      '</div>' 
                                    );
            }
          }
      });
  }
}