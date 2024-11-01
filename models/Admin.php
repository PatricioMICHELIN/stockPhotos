<?php

class Admin {
    private $_database;
    private $_connection;
    
    // constructor 
    public function __construct() {
        $this -> _database = new DataBase();
        $this -> _connection = $this -> _database -> getConnection();
    } //end __construct
    
    // Admin with id_admin created automatically in DB via INSERT command
    public function createAdmin($admin_pseudo, $admin_email, $admin_password) { 
        $sql_admin = ("INSERT INTO admin (admin_pseudo, admin_email, admin_password) 
                        VALUES (?, ?, ?)");
        
        $query_admin = $this -> _connection -> prepare($sql_admin);
        $admin = $query_admin -> execute ([$admin_pseudo, $admin_email, $admin_password]);
        // execute and return 3 values 
        return $admin;
    } // end createAdmin
       
    public function getAdminByEmail($admin_email) {
        $sql_admin = ("SELECT admin_pseudo, admin_email, admin_password
                       FROM admin
                       WHERE admin_email = ?");
        
        $query_admin = $this -> _connection -> prepare($sql_admin);
        $email = $query_admin -> execute ([$admin_email]);
        $admin = $query_admin -> fetch();
        return $admin;  
    }// end getAdminByEmail
}//end Class Admin

?>
