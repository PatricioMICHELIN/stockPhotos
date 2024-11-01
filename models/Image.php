<?php

// https://www.ptsecurity.com/ww-en/analytics/knowledge-base/how-to-prevent-sql-injection-attacks/

// class Image
class Image {
    private $_database;
    private $_connection;
    
    // set the number of images listed in every page. Manually set to 10. There IS NO inyection from outside via a prompt or window or butoon... 
    public const LIMIT_IMAGES_PER_PAGE = 10;

    public function __construct() {
        //calls get Connection function in DataBase.php //
        $this -> _database = new DataBase();
        $this -> _connection = $this -> _database -> getConnection();
    }//end __construct

    public function getImages() {
        // show Images in landing page 
        // image. before, if not query is ambigous by SQL
        
        $sql_images = " SELECT
                        image.image_id, image.client_id, image.image_name, image.image_caption, image.image_date, image.image_hashtag, image.image_author, image.image_use
                        FROM images AS image";

        $query_images = $this -> _connection -> prepare ($sql_images);
        $query_images -> execute();
        $images = $query_images -> fetchAll();
        return $images; //send 8 parameters to home.phtml -> fetchAll
    }//end getImages

    public function getTotalImagesCounter() {
        //  Returns a single column from the next row of a result set. 
        // fetchColumn return boolean false when a row not is found or don't had more rows.
        // return $prepare_counter, has to be an integer, because I need the number of images counted.
        
        $counter_images = "SELECT COUNT(distinct(image_id)) FROM images";
        
        $prepare_counter = $this -> _connection -> prepare ($counter_images);
        $prepare_counter -> execute();
        
        return  (int) $prepare_counter -> fetchColumn();
    }

    public function getImagesByPage($current_page) {
        
        // I need to access the constant of limit number per page with ClassName::ConstantName, therefore, the synthaxis and call to the variable is written like this (both are integers):
        
        $offset = $current_page * Image::LIMIT_IMAGES_PER_PAGE;
        $limit_images_per_page = Image::LIMIT_IMAGES_PER_PAGE; 
        
        // The LIMIT clause specifies the number of rows of the pages. This value comes from a constant at hte beginning of this file. It is not an external inyection as a variable. Instead of '?' I need to write between { } because it could change. I could also write LIMIT 10 in the query... 
        
        $sql_images = "SELECT image_id, client_id, image_name, image_caption, image_date, image_hashtag, image_author, image_use
                       FROM images
                       LIMIT {$limit_images_per_page} 
                       OFFSET {$offset}";

        $query_images = $this -> _connection -> prepare ($sql_images);
        $query_images -> execute();
        $images = $query_images -> fetchAll();
        return $images; //send 7 parameters to home.phtml -> fetchAll
    }

    public function getImageById($image_id) {
    // 9 parameters 8 from Images columm + 1 from client with Inner Join used.
    
        $sql_image_ById = "SELECT 
                            image.image_id, 
                            image.client_id, 
                            image.image_name, 
                            image.image_caption, 
                            image.image_date, 
                            image.image_hashtag, 
                            image.image_author, 
                            image.image_use, 
                            client.client_name
                        
                        FROM images AS image
                        INNER JOIN clients AS client 
                        ON client.client_id = image.client_id
                        
                        WHERE image.image_id = ?";
                        
        // image.image_** because if not PhPMuAdmin returns ambiguous parameter.
        // INNER JOIN has the information of client_id and then fetch that info in the html table of ImageInfo.phtml 

        $query_sql_image_ById = $this -> _connection -> prepare ($sql_image_ById);
        
        $query_sql_image_ById -> execute([$image_id]);
        
        $image_ById = $query_sql_image_ById -> fetch();
        return $image_ById;
    }//end function imageById

    public function addImage ($client_id, $pix_name, $image_caption, $image_date, $image_hashtag, $image_author, $image_use) {

        $sql_add_image = "INSERT INTO images (client_id, image_name, image_caption, image_date, image_hashtag, image_author, image_use)
                         VALUES(?,?,?,?,?,?,?)";

        $query_sql_add_image = $this -> _connection -> prepare ($sql_add_image);       
        $add_image =  $query_sql_add_image -> execute([$client_id, $pix_name, $image_caption, $image_date, $image_hashtag, $image_author, $image_use]);
         //execute every parameter in the same order IMPORTANT
        return $add_image;
    }// end addImage
                            
   public function editImage ($image_id, $image_caption, $image_date, $image_hashtag, $image_author, $image_use) {

        $sql_edit_image = "UPDATE images SET image_caption = ?,image_date = ?, image_hashtag = ?, image_author = ?, image_use = ? WHERE image_id = ?";

        $query_edit_image = $this -> _connection -> prepare($sql_edit_image);
        $edit_image = $query_edit_image -> execute([$image_caption, $image_date, $image_hashtag, $image_author, $image_use, $image_id]);
        return $edit_image;
   }//end editImage

   public function deleteImage ($image_id) {
        $sql_delete_image = "DELETE 
                            FROM images
                            WHERE image_id = ?";

        $query_delete_image = $this -> _connection -> prepare ($sql_delete_image);
        $delete_image = $query_delete_image -> execute([$image_id]);
        return $delete_image;
   }//end deleteImage

}// end Class Image
