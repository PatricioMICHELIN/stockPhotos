// use strict mode, prevents to use undeclared variables
"use strict";

function dropAuthor(){
    
    let choice = $("#image_author option:selected").val();
    console.log(choice);
    $.getJSON('index.php',"action=dropAuthor&image_author="+choice);
            
            // $.getJSON('index.php',"action=callAjax&id_meal="+choice, dropMenu);
            
            //automatic parse via JSON
        }//end dropMenu

document.addEventListener("DOMContentLoaded",function(){
    //dropMenu();
    // console.log("are you there?");
    $("#image_author").on('change', dropAuthor);
});
       