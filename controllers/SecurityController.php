<?php

// Classes defined as abstract cannot be instantiated, and any class that contains at least one abstract method must also be abstract. Methods defined as abstract simply declare the method's signature; they cannot define the implementation.

abstract class SecurityController {
    
    public function isClientLogged() {
        if (isset($_SESSION['client'])) 
           return $_SESSION['client']['client_id'] !== null;
    }
    
    public function clientLoggedId() {
        if(isset($_SESSION['client']['client_id'])) {
            return $_SESSION['client']['client_id'];
        }
    }
    
    public function isAdminLogged() 
    {
        return isset($_SESSION["adminSession"]);
    }
}
