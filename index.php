<?php
session_start();
// connection to DB
require "config/DataBase.php";

// Controllers are classes that can be reached through the URL and take care of handling the request.
// A controller calls models and other classes to fetch the information. Finally, it will pass everything to a view for output.
// There are 4 main controllers and 1 Security Controller (abstract) in this project.

require "controllers/SecurityController.php";
require "controllers/ImageController.php";
require "controllers/ClientController.php";
require "controllers/AdminController.php";
require "controllers/AuthorController.php";

$ImageController = new ImageController();
$ClientController = new ClientController();
$AdminController = new AdminController();
$AuthorController = new AuthorController();

// browser awaits some action via mouse or keyboard
if (array_key_exists("action", $_GET)) {
    // switches between every single possible case in index.php and therefore it calls the controller
    switch ($_GET["action"]) {

        // ADMIN (via URL)
         case "createAdmin" :
            $AdminController -> createAdmin();
            break;
        case "loginAdmin"  :
            $AdminController -> loginAdmin();
            break;

        case "clientInfo" :
            $ClientController -> clientInfo();
            break;
        case "editClient" :
            $ClientController -> editClient();
            break;
        case "deleteClient" :
            $ClientController -> deleteClient();
            break;

        // CLIENT & ADMIN
        case "logout":
            $ClientController -> logout();
            break;

        // ONLY CLIENT
        case "createClient" :
            $ClientController -> createClient();
            break;
        case "loginClient" :
            $ClientController -> loginClient();
            break;


        //AUTHOR
        case "createAuthor" :
            $AuthorController -> createAuthor();
            break;
        case "editAuthor" :
            $AuthorController -> editAuthor();
            break;
        case "authorInfo" :
            $AuthorController -> authorInfo();
            break;
        case "deleteAuthor" :
            $AuthorController -> deleteAuthor();
            break;
        case "dropAuthor" :
            $AuthorController -> dropAuthor();
            break;
        // IMAGE
        case "addImage" :
            // authors as parameters when clicking in dropDownMenu to choose authors images
            $image_author = $AuthorController -> dropAuthor();
            $ImageController -> addImage($image_author);
            break;
            
        case "editImage" :
            $image_author = $AuthorController -> dropAuthor();
            $ImageController -> editImage($image_author);
            break;
        case "imageInfo" :
            $ImageController -> imageInfo();
            break;
        case "downloadImage" :
            $ImageController -> downloadImage();
             break;
        case "deleteImage" :
            $ImageController -> deleteImage();
            break;
    } //end switch
}// end if array key exists
//if no action
else {
    $ImageController -> homeImages();

}//end else

