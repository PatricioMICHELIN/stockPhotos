<?php

class Author {

    private $_database;
    private $_connection;

    public function __construct() {
        $this -> _database = new DataBase();
        $this -> _connection = $this -> _database -> getConnection();
    } //end __construct

    public function insertAuthor($client_id, $author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig) {

        $sql_insertAuthor = "INSERT INTO authors(client_id, author_name, author_surname, author_email, author_phone, author_web, author_ig)
                        VALUES(?, ?, ?, ?, ?, ?, ?)";

        $query_insertAuthor = $this -> _connection -> prepare ($sql_insertAuthor);
        $insertAuthor = $query_insertAuthor -> execute ([$client_id, $author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig]);
        return $insertAuthor;
    } //end insertAuthor

    public function getAuthorById($author_id, $author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig) {
        $sql_edit_author = "UPDATE authors SET author_name = ?, author_surname = ?, author_email = ?, author_phone = ?, author_web = ?, author_ig = ?,
                            FROM authors
                            WHERE author_id = ?";

        $query_edit_author = $this -> _connection -> prepare($sql_edit_author);
        $edit_author = $query_edit_author -> execute([$author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig]);
        return $edit_author;
    }//end getAuthorById

    // When clicked in author_name link, call authorInfoByName. This function DOES NOT come from index.php.
    public function authorInfo($author_id) {
        $sql_author_info = "SELECT author_id, author_name, author_surname,  author_email, author_phone, author_web, author_ig
                            FROM authors
                            WHERE author_id = ?";

        $query_author_info = $this -> _connection -> prepare($sql_author_info);
        $author_info = $query_author_info -> execute([$author_id]);
        $infoAuthor = $query_author_info -> fetch();
        return $infoAuthor;
    } //end getAuthorInfo

    // From AuthorController line 127
    public function authorInfoByName($image_author) {
        $sql_author_info = "SELECT author_id, author_name, author_surname, author_email, author_phone, author_web, author_ig
                            FROM authors
                            WHERE author_name = ?";

        $query_author_info = $this -> _connection -> prepare($sql_author_info);
        $author_info = $query_author_info -> execute([$image_author]);
        $infoAuthor = $query_author_info -> fetch();
        return $infoAuthor;
    } //end getAuthorInfoByName

    // 1 parameter -> author_email. Function to check if Author already exists when created
    public function getAuthorByEmail($author_email) {
        $sql_authorByEmail = ("SELECT  author_id, author_name, author_surname, author_email, author_web, author_ig
                            FROM  authors
                            WHERE author_email = ?");

        $query_author_email = $this -> _connection -> prepare($sql_authorByEmail);
        $author_email = $query_author_email -> execute([$author_email]);

        $emailAuthor = $query_author_email -> fetch();
        return $emailAuthor;
    } //end getClientbyemail

    public function editAuthor ($author_id, $author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig) {
        // 6 parameters
        $sql_edit_author = "UPDATE
                                authors
                            SET
                                author_name = ?,
                                author_surname = ?,
                                author_email = ?,
                                author_phone = ?,
                                author_web = ?,
                                author_ig = ?
                            WHERE
                                author_id = ?";

        $query_edit_author = $this -> _connection -> prepare($sql_edit_author);
        $edit_author = $query_edit_author -> execute([$author_name, $author_surname, $author_email, $author_phone, $author_web, $author_ig, $author_id]);
        return $edit_author;

    }// }end editAuthor

    public function deleteAuthor ($author_id) {
        $sql_delete_author = "DELETE 
                            FROM authors
                            WHERE author_id = ?";
   
        $query_delete_author = $this -> _connection -> prepare ($sql_delete_author);
        $delete_author = $query_delete_author -> execute([$author_id]);
        return $delete_author;
   }//end deleteImage

    // only used in ADMIN Mode
    public function getAllAuthors() {
        $sql_all_authors = "SELECT author_id, client_id, author_name, author_surname, author_email, author_phone, author_web, author_ig
                       FROM authors";

        $all_authors = $this -> _connection -> prepare ($sql_all_authors);
        $all_authors -> execute();
        $authors = $all_authors -> fetchAll();
        return $authors; //send 7 parameters to home.phtml -> fetchAll
    }
    //  Fucntion only use by DROPDOWN Menu when add Image or Edit IMage is called.



    // public function dropdownAuthors($client_id)
    public function dropdownAuthors($client_id) {
        $sql_dropdown_authors = "SELECT author_name,author_id
                      FROM authors
                      WHERE client_id = {$client_id}";

        $drop_authors = $this -> _connection -> prepare ($sql_dropdown_authors);
        $drop_authors -> execute();
        $authors = $drop_authors -> fetchAll();
        return $authors;
        //send 1 parameter as a image_author to add or edit Image.phtml -> fetchAll
    }
    
    // public function dropdownAuthorsForAdmin() to show every authors
    public function dropdownAuthorsForAdmin() {
        $sql_dropdown_authors = "SELECT author_name,author_id
                                 FROM authors";

        $drop_authors = $this -> _connection -> prepare ($sql_dropdown_authors);
        $drop_authors -> execute();
        $authors = $drop_authors -> fetchAll();
        return $authors;
        //send 1 parameter as a image_author to add or edit Image.phtml -> fetchAll
    }

}//end class Author
