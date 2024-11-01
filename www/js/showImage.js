// use strict mode, prevents to use undeclared variables
"use strict";

// AJAX request
let images_downloaded = [];

function downloadImage() {
    loadStorage();
    images_downloaded = JSON.stringify(images_downloaded);
    console.log($.get('index.php', "action=downloadImage&images_name="+images_downloaded, reponseDownload));
}// end downloadImage

function reponseDownload(response) {
    console.log(response)
    let file = response;
    document.location.replace("www/client/downloadClick.phtml?file="+file);
}// end responseDownload

function showDownload(image) {
    let name_image = $(this).data("name");
    console.log(name_image);
    images_downloaded.push(name_image);
    saveStorage();
    loadStorage();
}//end showDownload

function saveStorage(){
    localStorage.setItem("imagesDownloaded", JSON.stringify(images_downloaded));
}// end saveStorage

function loadStorage(){
    images_downloaded = localStorage.getItem("imagesDownloaded");
    if(images_downloaded == null) {
        images_downloaded =[];
    }
    else {
        images_downloaded = JSON.parse(images_downloaded);
    }
}//end loadStorage

/* ================= MAIN ========================== */

document.addEventListener("DOMContentLoaded",function(){
    
    // when click on download button //
    $("#download").on('click', downloadImage);
    
    $('input[type=checkbox]').on('click',showDownload);
});


