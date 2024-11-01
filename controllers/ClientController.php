<?php
//Client Controller requires ONE model.
// Classes must we written in PascalCase notation
// Methods has to be wrtiiten in camelCase notation

require "models/Client.php";

class ClientController extends SecurityController  {

    // Class properties with underscored variable to differentiate from common variables

    private $_client;

    //Class Methods
    public function __construct() {
        $this -> _client = new Client();
    }// end __construct

    public function createClient() {

        $template = "client/createClient";
        // Every input is checked if it is exists and if not empty
        if (isset($_POST["client_email"]) && (!empty($_POST["client_email"]))) {
            $_client = $this -> _client -> getClientByEmail($_POST["client_email"]);

                if(!$_client) {
                    if (isset($_POST["client_name"]) &&
                        isset($_POST["client_surname"]) &&
                        isset($_POST["client_phone"]) &&
                        isset($_POST["client_email"]) &&
                        isset($_POST["client_password"]) &&

                        !empty($_POST["client_name"]) &&
                        !empty($_POST["client_surname"]) &&
                        !empty($_POST["client_phone"]) &&
                        !empty($_POST["client_email"]) &&
                        !empty($_POST["client_password"])) {

                        // only letters, not special characters to prevent code injection. Password is also hashed for security reasons
                            $client_name     = htmlspecialchars($_POST["client_name"]);
                            $client_surname  = htmlspecialchars($_POST["client_surname"]);
                            $client_phone    = htmlspecialchars($_POST["client_phone"]);
                            $client_email    = htmlspecialchars($_POST["client_email"]);
                            $client_password = password_hash(htmlspecialchars($_POST["client_password"]),PASSWORD_DEFAULT);

                            // add client in DB, every client variable must be sent to addclient. 5 variables inserted via form, hence, 5 variables as parameter in insertClient
                         
                                $addClient = $this -> _client -> insertClient($client_name, $client_surname, $client_email,$client_phone, $client_password);

                            if($addClient) {
                                $message = "client added correctly!";
                                $template = "client/loginClient";
                            }
                            else {
                                $message = "error";
                            }
                    } //end isset and !empty
                }//end is not $client
                else {
                    $message = "Client already exists";
                }
        }// end if isset and not empty

        $title = "addClient page";
        require "www/layout.phtml";

    }//end createClient

     // this function uses getClientByEmail as model in client.php.
    public function loginClient() {

        if (isset($_POST["client_email"]) && !empty($_POST["client_email"]) && isset($_POST["client_password"]) && !empty($_POST["client_password"])) {

            $_client = $this -> _client -> getClientByEmail($_POST["client_email"]);
            if ($_client) {
            // passwordClient verification. Password was hashtagged in getClientbyEmail
                if (password_verify($_POST["client_password"], $_client["client_password"])) {
                    // transform 2 variables in 1 array for better callback in layout.phtml
                    $_SESSION["client"]["client_name"] = $_client["client_name"];
                    $_SESSION["client"]["client_id"] = $_client["client_id"];
                    header ("location: index.php");
                }//end if password verification
                else {
                    $message = "Wrong Password darling";
                }
            }// end if client
            else {
                $message = "Wrong email";
            }
        }//end isset $POST

    $title = "loginClient";
    $template = "www/client/loginClient";
    require "www/layout.phtml";
    }//end loginClient


    public function clientInfo() {
    // only Admin logged. A client cannot edit itself... 
    
    if ( $this -> isAdminLogged() ) {
       
        // if (array_key_exists("client_id", $_GET)) {
        //     $client_id = $_GET["client_id"];
        //     $clients = $this -> _client -> getAllClients();

        // }
        // Get all clients from DB
        $clients = $this -> _client -> getAllClients();
        $isAdminLogged = $this -> isAdminLogged();

        $title = "clientInfo";
        $template ="client/clientInfo";
        require "www/layout.phtml";

        }
    }//end clientInfo
    
     // only Admin logged. A client cannot edit itself... 
    public function editClient() {
        if ($this -> isAdminLogged()) {

            if (array_key_exists("client_email", $_GET)) {
                    $client_email = $_GET["client_email"];
                    $client = $this -> _client -> getClientByEmail($client_email);
                    //  $client = $this -> _client -> ClientInfo($client_email); ?????
                }

                if (!empty($_POST) && isset($_POST)) {

                    $client_id = $_POST['client_id'];
                    $client_name = $_POST['client_name'];
                    $client_surname = $_POST['client_surname'];
                    $client_email = $_POST['client_email'];
                    $client_password = $_POST['client_password'];
                    $client_phone = $_POST['client_phone'];

                    $editClient = $this -> _client -> editClient($client_id, $client_name, $client_surname, $client_email, $client_password, $client_phone);

                    if($editClient) {
                        $message ="you've edited the client correctly";
                        header ("location:index.php?action=clientInfo&message=".$message);
                    }
                    else {
                        $message = "ERROR";
                    }
                }

                $isAdminLogged = $this -> isAdminLogged();

                $title = "editClient";
                $template ="client/editClient";
                require "www/layout.phtml";

        }// end If admin logged
    }//end editClient

    public function deleteClient()  {
        
        if ( $this -> isAdminLogged() && array_key_exists("client_email", $_GET)) {
            $delete_client = $this -> _client -> deleteClient($_GET["client_email"]);
        } else {
            $message = "ERROR";
        }
        
        $message = "Client delete correctly";
        header("location:index.php?action=clientInfo&message=" . $message);
    }//end public deleteClient

    public function isSessionStarted() {
        if (isset($_SESSION["client"])) {
            return true;
        }
        else {
            return false;
        }
    } //end is session started

    public function logout() {

        if ($this -> isClientLogged() || $this -> isAdminLogged() ) {

            if (isset($_SESSION["client"])) {
                    $_SESSION["client"]=[];
                    //to ensure you are using same session
                    session_unset();
                    //destroy the session
                    session_destroy();
                    //to redirect back to index.php after logging out
                    header("location:index.php");
            }//end if

            elseif (isset($_SESSION["adminSession"])) {
                    $_SESSION["adminSession"]=[];
                    session_unset();
                    session_destroy();
                    header("location:index.php");
            }//end elseif
         } // end security
   } //end if logout

}//end ClientController

?>
