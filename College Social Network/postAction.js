function copylink(postID) {
    /* Get the text field */
    var linkid = "link".concat(postID);
    var copyText = document.getElementById(linkid);
    // console.log(copyText.value);

    copyText.setAttribute("type", "text");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
  
    /* Copy the text inside the text field */
    document.execCommand("copy");
  
    copyText.setAttribute("type", "hidden");

    /* Alert the copied text */
    alert("LINK COPIED !");
}