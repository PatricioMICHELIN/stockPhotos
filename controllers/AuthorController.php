<?php
//Author Controller requires ONE model.
// Classes must we written in PascalCase notation
// Methods has to be wrtiiten in camelCase notation

require "models/Author.php";

class AuthorController extends SecurityController {

    //Class properties with underscored variable to differentiate from common variables
    private $_author;

    public function __construct() {
        $this -> _author = new Author();
    }//end __construct

    public function createAuthor() {
        // only a client connected can create an author.
        if ($this -> isClientLogged() ) {
            $template = "author/createAuthor";

            if (isset($_POST["author_email"]) && (!empty($_POST["author_email"]))) {
                $_author = $this-> _author->getAuthorByEmail($_POST["author_email"]);

                // Every input is checked if it is exists and if not empty
                if (!$_author) {
                    if (isset($_POST["author_name"]) &&
                        isset($_POST["author_surname"]) &&
                        isset($_POST["author_email"]) &&
                        isset($_POST["author_phone"]) &&
                        isset($_POST["author_web"]) &&
                        isset($_POST["author_ig"]) &&

                        !empty($_POST["author_name"]) &&
                        !empty($_POST["author_surname"]) &&
                        !empty($_POST["author_email"]) &&
                        !empty($_POST["author_phone"]) &&
                        !empty($_POST["author_web"]) &&
                        !empty($_POST["author_ig"])) {

                        // only letters, not special characters to prevent code injection. Password is also hashed for security reasons

                        $author_name    = htmlspecialchars($_POST["author_name"]);
                        $author_surname = htmlspecialchars($_POST["author_surname"]);
                        $author_email   = htmlspecialchars($_POST["author_email"]);
                        $author_phone   = htmlspecialchars($_POST["author_phone"]);
                        $author_web     = htmlspecialchars($_POST["author_web"]);
                        $author_ig      = htmlspecialchars($_POST["author_ig"]);
                        $client_id      = $_SESSION['client']['client_id'];

                        // add author in DB, every author variable must be sent to addauthor.
                        // 6 variables inserted via a form, hence, 6 variables as parameter in insertAuthor
                        // $this -> Client or Admin Logged is a boolean parameter to know who is connected at the moment. Importance to get to client_id value for a late edition of that author.

                        $addAuthor = $this ->_author -> insertAuthor ($client_id, $author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig);

                        if ($addAuthor) {
                            $message  = "Author create correctly";
                            $template = "author/createAuthor";
                        } else {
                            $message = "error";
                        }
                    }
                } //end isset and !empty
                else {
                    $message = "Author already exists";
                }
            }//end !$-author
        }

        $isClientLogged = $this -> isClientLogged();
       
        $title = "createAuthor";
        require "www/layout.phtml";
    }// end createAuthor

    public function editAuthor() {
        if ($this -> isClientLogged() || $this -> isAdminLogged()) {

            if (array_key_exists("author_id", $_GET)) {
                $author_id = $_GET["author_id"];
                $author = $this -> _author -> authorInfo($author_id);
            }

            if (!empty($_POST) && isset($_POST)) {

                $author_id = $_POST['author_id'];
                $author_name = $_POST['author_name'];
                $author_surname = $_POST['author_surname'];
                $author_email = $_POST['author_email'];
                $author_phone = $_POST['author_phone'];
                $author_web = $_POST['author_web'];
                $author_ig = $_POST['author_ig'];

                $editAuthor = $this -> _author -> editAuthor($author_id, $author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig);

                if ($editAuthor) {
                    $message ="you've edited the author correctly";
                    header ("location:index.php?action=authorInfo&message=".$message);
                }
                else {
                    $message = "ERROR";
                }
            }//end elseif

            $isClientLogged = $this -> isClientLogged();
            $isAdminLogged = $this -> isAdminLogged();

            $title = "authorInfo";
            $template ="author/editAuthor";
            require "www/layout.phtml";
        }
    }//end editAuthor

    public function authorInfo() {
            if ($this -> isClientLogged() || $this -> isAdminLogged() ) {

                if(array_key_exists("image_author", $_GET)) {
                    $image_author = $_GET["image_author"];
                    $author = $this -> _author -> authorInfoByName($image_author);
                }
                // Get all authors from DB
                $authors = $this -> _author -> getAllAuthors();
                $loggedClientId = null;

                // I need to set the client_id to that logged Client
                if ( $this -> isClientLogged() ) {
                    $loggedClientId = $_SESSION['client']['client_id'];
                }
                // empty AuthorList array before the foreach loop
                $authorsToShow = [];
                foreach ($authors as $author) {
                    $author['isFromLoggedClient'] = $loggedClientId === $author['client_id'];
                    // and now, yes, fill the array with FORAECH loop
                    $authorsToShow[]  = $author;
                }

                $isClientLogged = $this -> isClientLogged();
                $isAdminLogged = $this -> isAdminLogged();

                $title = "authorInfo";
                $template ="author/authorInfo";
                require "www/layout.phtml";
            }
    }//end showAuthor

    public function deleteAuthor() {

        if ( ($this -> isClientLogged() || $this -> isAdminLogged() ) && 
        array_key_exists("author_id", $_GET) && 
        array_key_exists("client_id", $_GET)) {

            // if ( ($_GET["client_id"] === $this -> clientLoggedId()) || $this -> isAdminLogged() ) {
                $delete_author = $this -> _author -> deleteAuthor($_GET["author_id"]);
        }
            else {
                $message = "ERROR";
            }
        // }

        $message = "Author delete correctly";
        header("location:index.php?action=authorInfo&message=".$message);

    }//end public deleteImage

    //I sent parameter of when cliclink in action add or edit image. I sent the parameter to client_id from index.php. 
    // That's important to show only authors form that client in dropdown menu. 
    public function dropAuthor() {
        if ($this -> isClientLogged() ) {
                if ($_SESSION['client']['client_id'] !== null) {
                    $client_id_to_search_authors_by = $_SESSION['client']['client_id'];
                } elseif (array_key_exists("client_id", $_GET)) {
                    $client_id_to_search_authors_by = $_GET["client_id"];
                } 
                
            $image_author = $this -> _author -> dropdownAuthors($client_id_to_search_authors_by);
            return $image_author; 
        } 
        
        elseif ($this -> isAdminLogged() ) {
            
            $image_author = $this -> _author -> dropdownAuthorsForAdmin();
            return $image_author;
        }
    }// end dropAuthor
}//end AuthorController
