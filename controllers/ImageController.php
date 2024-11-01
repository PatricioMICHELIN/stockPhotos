<?php

//Admin Controller requires ONE model.
// Classes must we written in PascalCase notation
// Methods has to be wrtiiten in camelCase notation
require "models/Image.php";

class ImageController extends SecurityController {

    //Class properties with underscored variable to differentiate from common variables
    private $_image;
    private $_author;

    //Class Methods - constructor
    public function __construct() {
        $this -> _image = new Image();
        $this -> _author = new Author();
    } //end __construct

    public function homeImages() {
        // as nobody is connected I do not need to check security login
        //get Images infos from class Image
        $images = $this -> _image -> getImages();
        // set infos to template //
        $title = "home";
        $template = "www/home";
        require "www/layout.phtml";
    }//end ShowImage

    public function addImage($image_author) {
          if ( ($this -> isClientLogged() /*|| $this -> isAdminLogged()*/ ) &&

            isset($_POST["image_caption"]) &&
            isset ($_POST["image_date"]) &&
            isset ($_POST["image_hashtag"]) &&
            isset ($_POST["image_author"]) &&
            isset ($_POST["image_use"]) &&
            isset ($_FILES["client_image"]) &&

            !empty($_POST["image_caption"]) &&
            !empty($_POST["image_date"]) &&
            !empty($_POST["image_hashtag"]) &&
            !empty($_POST["image_author"]) &&
            !empty($_POST["image_use"]) &&
            !empty($_FILES["client_image"])) {

            //   https://www.php.net/manual/en/function.move-uploaded-file.php

            $image_caption = htmlspecialchars($_POST['image_caption']);
            $image_date    = htmlspecialchars($_POST['image_date']);
            $image_hashtag = htmlspecialchars($_POST['image_hashtag']);
            $image_author  = htmlspecialchars($_POST['image_author']);
            $image_use     = htmlspecialchars($_POST['image_use']);
            $image_name    = htmlspecialchars($_FILES["client_image"]["name"]);

            $tmp_name  = $_FILES["client_image"]["tmp_name"];
            $size      = $_FILES["client_image"]["size"];

            $type_ext  = explode(".", $image_name);
            $final_ext = strtolower(end($type_ext));

            /* ============ extension JPG - PNG - BMP ONLY ===== */
            $extensions = ["jpg", "png", "bmp", "jpeg", "tiff"];
            $max_size   = 2097152;

                // <!--https://codingstatus.com/preview-an-image-before-uploading-using-php/-->
                // https://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded

            if (in_array($final_ext, $extensions) && ($size < $max_size) && ($size != 0)) {

                $unique_name = uniqid("", true);
                $pix_name    = $unique_name . "." . $final_ext;
                move_uploaded_file($tmp_name, "www/images/" . $pix_name);
                $message = "image uploaded correctly";

                $addImage = $this-> _image -> addImage ($this->clientLoggedId(), $pix_name, $image_caption, $image_date, $image_hashtag, $image_author, $image_use);

            } else {
                $message = "extension not allowed or file too large, please choose below 2Mb or choose a JPG or PNG or BMP.";
            }

            header("location:index.php?action=addImage&message=" . $message);
        }

        $isClientLogged = $this-> isClientLogged();
        // $isAdminLogged = $this-> isAdminLogged();

        $title = "addImage";
        $template = "client/addImage";
        require "www/layout.phtml";

    }// end AddImage

    public function editImage($image_author) {
        if ($this -> isClientLogged() || $this -> isAdminLogged() ) {

            if(array_key_exists("current_page",$_GET))
            {
                $currentPage = (int) $_GET['current_page'];
                $images = $this-> _image-> getImagesByPage($currentPage);

                $totalImages = $this -> _image -> getTotalImagesCounter();
                $needShowNextButton = $this -> needShowNextButton($currentPage, $totalImages);

                $loggedClientId = null;
                if ($this -> isClientLogged()) {
                    $loggedClientId = $_SESSION['client']['client_id'];
                }

                $imagesToShow = [];
                foreach ($images as $image) {
                    $image['isFromLoggedClient'] = $loggedClientId === $image['client_id'];
                    $imagesToShow[]  = $image;
                }
            }//end test current_page

            if (array_key_exists("image_id", $_GET)) {
                $image_id = $_GET["image_id"];
                $image    = $this -> _image -> getImageById($image_id);
            }
        }

        if (!empty($_POST)) {
            $image_id      = $_POST['image_id'];
            $image_caption = $_POST['image_caption'];
            $image_date    = $_POST['image_date'];
            $image_hashtag = $_POST['image_hashtag'];
            $image_author  = $_POST['image_author'];
            $image_use     = $_POST['image_use'];
        
            $editImage = $this-> _image -> editImage($image_id, $image_caption, $image_date, $image_hashtag, $image_author, $image_use);

            if ($editImage) {
                $message = "you've edited the image correctly";
                header("location:index.php?action=editImage&current_page=0&message=".$message);
            } else {
                    $message = "ERROR";
            }
                header ("location:index.php?action=editImage&current_page=0&message=".$message);
        }//end elseif


        $isClientLogged = $this -> isClientLogged();
        $isAdminLogged = $this -> isAdminLogged();

        $title = "editImage";
        $template ="client/editImage";
        require "www/layout.phtml";

    }//end editImage

    public function imageInfo() {
        if ($this->isClientLogged() || $this->isAdminLogged()) {

            if (array_key_exists("image_id", $_GET)) {
                $image_id = $_GET["image_id"];
                $image = $this -> _image -> getImageById($image_id);
            }

            $isClientLogged = $this -> isClientLogged();
            $isAdminLogged = $this -> isAdminLogged();

            $title = "imageInfo";
            $template ="client/imageInfo";
            require "www/layout.phtml";
        }
        else {
                $message = "ERROR";
        }
    }//end imageInfo

    public function deleteImage() {

        if (($this->isClientLogged() || $this->isAdminLogged()) && array_key_exists("image_id", $_GET)) {

            $image_id = $_GET["image_id"];
            $image = $this -> _image -> getImageById($image_id);
          
            if ( ($image["client_id"] === $this -> clientLoggedId()) || $this -> isAdminLogged() ) {
                $delete_image = $this -> _image -> deleteImage($image_id);

                //   First I need to check image is deleted from DB, then, I can delete it from folder www/images/
                if($delete_image) {
                    // var_dump($image["image_name"]);
                    $message = $image["image_name"]." deleted correctly";
                    $file = 'www/images/'.$image["image_name"];
                    $test = unlink($file) ;
                    // var_dump($test);
                    if($test)
                    {
                        header("location:index.php?action=editImage&current_page=0&message=".$message);
                    }
                }
            }
            else {
                $message = "ERROR";
            }
        }
        header("location:index.php?action=editImage&current_page=0&message=".$message);

    }//end public deleteImage

    public function downloadImage() {

     // https://stackoverflow.com/questions/39741383/check-box-form-select-files-zip-and-download-via-php -->

     // https://forums.phpfreaks.com/topic/285037-multiple-downloads-using-checkboxes/

   // https://www.codegrepper.com/code-examples/php/download+multiple+files+in+zip+from+path+in+php


        if (($this->isClientLogged() || $this->isAdminLogged()) && array_key_exists("images_name", $_GET)) {
            // Takes a JSON encoded string and converts it into a PHP variable.
            $images_name = json_decode($_GET["images_name"]);
            $zip         = new ZipArchive();
            // create a unique name with present date and time
            $filename = "./www/ZipClients/" . 'Forms-' . date(strtotime("now")) . '.zip';
            // look for images in specific folder
            $file_path = $_SERVER['DOCUMENT_ROOT'] . "/stockPhotos2004/www/images/";

            if ($zip->open($filename, ZipArchive::CREATE) !== true) {
                exit("File cannot be opened <$filename>\n");
            }

            foreach ($images_name as $key => $image) {
                $zip->addFile($file_path . $image, $key . $image);
            }

            $zip->close();
            echo $filename;
        }
        // end security check
    }//end downloadImage

    // I need to separate ecery page with a MAX number of images. Hence I need a next buton to be shown at the bottom of the table.
    // Image::10 for the page that Client is and then a calculation of how many numbers of images are left before and after.

    public function needShowNextButton($currentPage, $totalImages) {

        $imagesShownUntilCurrentPage = $currentPage * Image::LIMIT_IMAGES_PER_PAGE;
        $imagesLeft                  = $totalImages - $imagesShownUntilCurrentPage;

        return $imagesLeft >= Image::LIMIT_IMAGES_PER_PAGE;
    }

}//end ImageController

?>
