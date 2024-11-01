<?php
//Admin Controller requires ONE model. 
// Classes must we written in PascalCase notation
// Methods has to be wrtiiten in camelCase notation

require "models/Admin.php";

class AdminController extends SecurityController {
    
    //Class properties with underscored variable to differentiate from common variables  
    private $_admin;
    private $_client;
    
    //Class Methods
    public function __construct() {
        
        $this -> _admin = new Admin;
        $this -> _client = new Client;
    }//end constructor
    
    public function createAdmin() {
                
        $template = "www/admin/createAdmin";
        
        // Every input is checked if it is exists and if not empty
        if (isset($_POST["admin_pseudo"]) &&
            !empty($_POST["admin_pseudo"]) &&
            isset($_POST["admin_email"]) &&
            !empty($_POST["admin_email"]) &&   
            isset($_POST["admin_password"]) &&
            !empty($_POST["admin_password"])) {
                
                // only letters, not special characters to prevent code injection. Password is also hashed for security reasons
                $admin_pseudo   = htmlspecialchars($_POST["admin_pseudo"]);
                $admin_email    = htmlspecialchars($_POST["admin_email"]);
                $admin_password = password_hash(htmlspecialchars($_POST["admin_password"]),PASSWORD_DEFAULT);            
                
                //verify if admin already exists with the same function that getClientByEmail
                $getAdmin = $this -> _admin -> getAdminByEmail($admin_email);
                
                // add Admin in DB, every admin variable must be sent to createAdmin: 3 variables inserted via a form
                if(!$getAdmin) {
                    $addAdmin = $this -> _admin -> createAdmin($admin_pseudo, $admin_email, $admin_password);    
                    
                    if ($addAdmin) {
                         $message = "Admin created succesfully!";
                         $template = "www/admin/admin";
                    } // end $addAdmin 
                    else {
                        $message = "Error";
                    }
                }//end if !getAdmin    
                else {
                    $message = "You've already have an admin account";
                }    
        } // end if isset and !empty
        
        $title = "createAdmin";
        $template = "www/admin/createAdmin";
        require "www/layout.phtml";
    }// end createAdmin   
    
    public function loginAdmin() {
        if  (isset($_POST["admin_pseudo"]) &&
            !empty($_POST["admin_pseudo"]) &&   
            isset($_POST["admin_email"]) &&
            !empty($_POST["admin_email"]) &&   
            isset($_POST["admin_password"]) &&
            !empty($_POST["admin_password"])) {
                
                $_admin = $this -> _admin -> getAdminByEmail($_POST["admin_email"]);
                if($_admin) {
                    if (password_verify($_POST["admin_password"], $_admin["admin_password"])) {
                        $_SESSION["adminSession"] = $_admin["admin_pseudo"];
                        header ("location: index.php");
                    }
                    else {
                        $message = "Wrong password";
                    }
                }//end if $admin    
                else {
                        $message = "Wrong email address";
                } 
        } //end if loginAdmin
        
        $isAdminLogged = $this -> isAdminLogged();
        
        $title = "loginAdmin";
        $template = "www/admin/admin";
        require "www/layout.phtml";
    }//end loginAdmin
        
    public function logout()  {
        if (isset($_SESSION["adminSession"]))
        {
            $_SESSION["addAdmin"]=[];
            session_unset(); //to ensure you are using same session
            session_destroy(); //destroy the session
            header("location:models/Admin.php"); //to redirect back to "admin.php" after logging out
        }
    } //end logout Admin
}//end Class AdminController

