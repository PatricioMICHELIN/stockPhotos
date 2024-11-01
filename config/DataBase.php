<?php

// Connection to DB via this class
class DataBase {
    const SERVER = "db.3wa.io";
    const DB = "patriciomichelin_stock";
    const USER = "patriciomichelin";
    const PASSWORD = "14e8a82019d674f521691905e55c2603";
    
    private $_connection;

    public function __construct() {
        try {
            $this -> _connection = new PDO("mysql:host=".self::SERVER.";dbname=".self::DB,self::USER,self::PASSWORD);
            //as we are in France, I will place an special accent exemption as UTF-8
            $this -> _connection -> exec("SET CHARACTER SET utf8");
        }//end try
        
        catch (exception $message) {
            die ("connection error ".$message -> getMessage());
        }//end catch
    } // end __construct
    
    public function getConnection() {
        return $this -> _connection;
    }// end getConnection
}
// end DataBase
