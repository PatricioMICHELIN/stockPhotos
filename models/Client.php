<?php

class Client {

    private $_database;
    private $_connection;

    // constructor
    public function __construct() {
        $this -> _database = new DataBase();
        $this -> _connection = $this -> _database -> getConnection();
    } //end __construct

    // 5 parameters from Controller $addClient sent in the same order.
    public function insertClient ($client_name, $client_surname, $client_email, $client_phone, $client_password) {

        $sql_insertClient = "INSERT INTO clients( client_name, client_surname, client_email, client_phone, client_password)
                            VALUES(?, ?, ?, ?, ?)";

        $query_insertClient = $this -> _connection -> prepare ($sql_insertClient);
        $insertClient = $query_insertClient -> execute ([$client_name, $client_surname, $client_email, $client_phone, $client_password]);
        // execute and return 5 values
        return $insertClient;
    }// end insertClient

  // 1 parameter -> client email
    public function getClientByEmail($client_email) {
        $sql_clientByEmail = ("SELECT client_id, client_name, client_surname, client_email, client_password, client_phone
                            FROM clients
                            WHERE client_email = ?");

        $query_client_email = $this -> _connection -> prepare($sql_clientByEmail);
        $client_email = $query_client_email -> execute([$client_email]);
        $email_client = $query_client_email -> fetch();
        return $email_client;
    } //end getClientbyemail

    public function editClient ($client_id, $client_name, $client_surname, $client_email, $client_password, $client_phone) {

        $sql_edit_client = "UPDATE
                                clients
                            SET
                                client_name = ?,
                                client_surname = ?,
                                client_email = ?,
                                client_password = ?,
                                client_phone = ?
                            WHERE
                                client_id = ?";

        $query_edit_client = $this -> _connection -> prepare($sql_edit_client);
        $edit_client = $query_edit_client -> execute([$client_name, $client_surname, $client_email, $client_password, $client_phone,$client_id]);
        return $edit_client;
    }
    
    // public function clientInfo($client_email) {
    //     $sql_client_info = "SELECT client_id, client_name, client_surname, client_email, client_password, client_phone
    //                         FROM clients
    //                         WHERE client_email = ?";

    //     $query_client_info = $this -> _connection -> prepare($sql_client_info);
    //     $client_info = $query_client_info -> execute([$client_email]);
    //     $infoClient = $query_client_info -> fetch();
    //     return $infoClient;
    // } //end getClientInfo
    
    
    
    
    
    
    public function getAllClients() {
        $sql_all_clients = "SELECT client_id, client_name, client_surname, client_email, client_password, client_phone
                            FROM clients";

        $all_clients = $this -> _connection -> prepare ($sql_all_clients);
        $all_clients -> execute();
        $clients = $all_clients -> fetchAll();
        return $clients; //send 6 parameters to home.phtml -> fetchAll
    }// end getAllClients

        // only used in ADMIN mode
    public function deleteClient ($client_email) {
        //  DELETE ON CASCADE?? DELETE verything from that client?

        $sql_delete_client = "DELETE 
                              FROM clients
                              WHERE client_email = ?";


        $query_delete_client = $this -> _connection -> prepare ($sql_delete_client);
        $delete_client = $query_delete_client -> execute([$client_email]);
        return $delete_client;
  }//end deleteClient


}//end class Client
?>
