<?php

/* * ************************************************************
 * This script is brought to you by Vasplus Programming Blog
 * Website: www.vasplus.info
 * Email: info@vasplus.info
 * ************************************************************** */


if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
    // You may change any of the below information if you wish
    $vpb_upload_image_directory = "uploads/";
    $vpb_with_of_first_image_file = 960;      // You may adjust the width here as you wish
    $vpb_with_of_second_image_file = 960;     // You may adjust the height here as you wish

    /* Variables Declaration and Assignments */
    $vpb_image_filename = $_FILES["browsed_file"]["name"];
    $vpb_image_tmp_name = $_FILES['browsed_file']['tmp_name'];
    $vpb_file_size = filesize($_FILES['browsed_file']['tmp_name']);
    $vpb_file_extensions = pathinfo($vpb_image_filename, PATHINFO_EXTENSION);



    $vpb_maximum_allowed_file_size = 5120 * 3840; // You may change the maximum allowed upload file size here if you wish
    $vpb_additional_file_size = $vpb_file_size - $vpb_maximum_allowed_file_size;


    //Validate file upload field to be sure that the user attached a file and did not upload an empty field to proceed
    if ($vpb_image_filename == "") {
        echo '<div class="info">Please browse for the file that you wish to upload and resize to proceed. Thanks.</div>';
    } else {
        //Validate attached file for allowed file extension types
        if ($vpb_file_extensions != "gif" && $vpb_file_extensions != "jpg" && $vpb_file_extensions != "jpeg" && $vpb_file_extensions != "png" && $vpb_file_extensions != "GIF" && $vpb_file_extensions != "JPG" && $vpb_file_extensions != "JPEG" && $vpb_file_extensions != "PNG") {
            echo '<div class="info">Sorry, the file type you attempted to upload is invalid. <br>This system only accepts gif, jpg, jpeg or png image files whereas you attached <b>' . $vpb_file_extensions . '</b> file format. Thanks.</div>';
        } elseif ($vpb_file_size > $vpb_maximum_allowed_file_size) { //Validate attached file to avoid large files
            echo "<div class='info'>Sorry, you have exceeded this system's maximum upload file size limit of <b>" . $vpb_maximum_allowed_file_size . "</b> by <b>" . $vpb_additional_file_size . "</b><br>Please reduce your file size to proceed. Thanks.</div>";
        } else {
            /* Create images based on their file types */
            if ($vpb_file_extensions == "gif") { //If the attached file extension is a gif, carry out the below action
                $vpb_image_src = imagecreatefromgif($vpb_image_tmp_name); //This will create a gif image file
            } elseif ($vpb_file_extensions == "jpg" || $vpb_file_extensions == "jpeg" || $vpb_file_extensions == "JPG" || $vpb_file_extensions == "JPEG") { //If the attached file is a jpg or jpeg, carry out the below action
                $vpb_image_src = imagecreatefromjpeg($vpb_image_tmp_name); //This will create a jpg or jpeg image file
            } else if ($vpb_file_extensions == "png" || $vpb_file_extensions == "PNG") { //If the attached file extension is a png, carry out the below action
                $vpb_image_src = imagecreatefrompng($vpb_image_tmp_name); //This will create a png image file
            } else {
                $vpb_image_src = "invalid_file_type_realized";
            }

            //The file attached is unknow
            if ($vpb_image_src == "invalid_file_type_realized") {
                echo '<div class="info">Sorry, the file type you attempted to upload is invalid. <br>This system only accepts gif, jpg, jpeg or png image files whereas you attached <b>' . $vpb_file_extensions . '</b> file format. Thanks.</div>';
            } else {
                //Get the size of the attached image file from where the resize process will take place from the width and height of the image
                list($vpb_image_width, $vpb_image_height) = getimagesize($vpb_image_tmp_name);

                /* The uploaded image file is supposed to be just one image file but 
                  we are going to split the uploaded image file into two images with different sizes for demonstration purpose and that process
                  starts from below */


                //This is the width of the first image file from where its height will be determined
                $vpb_first_image_new_width = $vpb_with_of_first_image_file;
                $vpb_first_image_new_height = ($vpb_image_height / $vpb_image_width) * $vpb_first_image_new_width;
                $vpb_first_image_tmp = imagecreatetruecolor($vpb_first_image_new_width, $vpb_first_image_new_height);


                //This is the width of the second image file from where its height will be determined

                $vpb_second_image_new_width = $vpb_with_of_second_image_file;

                $vpb_second_image_new_height = ($vpb_image_height / $vpb_image_width) * $vpb_second_image_new_width;

                $vpb_second_image_tmp = imagecreatetruecolor($vpb_second_image_new_width, $vpb_second_image_new_height);


//martin
                /*
                  $vpb_second_image_new_height = $vpb_with_of_second_image_file;
                  $vpb_second_image_new_width = ($vpb_image_width/$vpb_image_height)*$vpb_with_of_second_image_file;
                  $vpb_second_image_tmp = imagecreatetruecolor($vpb_second_image_new_width,$vpb_second_image_new_height);

                 */

///martin
                //Resize the first image file
                imagecopyresampled($vpb_first_image_tmp, $vpb_image_src, 0, 0, 0, 0, $vpb_first_image_new_width, $vpb_first_image_new_height, $vpb_image_width, $vpb_image_height);

                //Resize the second image file
                imagecopyresampled($vpb_second_image_tmp, $vpb_image_src, 0, 0, 0, 0, $vpb_second_image_new_width, $vpb_second_image_new_height, $vpb_image_width, $vpb_image_height);

                //Pass the attached file to the uploads directory for the first image file

                $findme = "jpg";
                $pos = strripos($vpb_image_filename, $findme);
                if ($pos === false) {
                    
                } else {
                    $vpb_uploaded_file_movement_one = $vpb_upload_image_directory . "image_" . rand() . ".jpg";
                    $vpb_uploaded_file_movement_two = $vpb_upload_image_directory . "image_small_" . rand() . ".jpg";
                }

                $findme = "gif";
                $pos = strripos($vpb_image_filename, $findme);
                if ($pos === false) {
                    
                } else {
                    $vpb_uploaded_file_movement_one = $vpb_upload_image_directory . "image_" . rand() . ".gif";
                    $vpb_uploaded_file_movement_two = $vpb_upload_image_directory . "image_small_" . rand() . ".gif";
                }

                $findme = "jpeg";
                $pos = strripos($vpb_image_filename, $findme);
                if ($pos === false) {
                    
                } else {
                    $vpb_uploaded_file_movement_one = $vpb_upload_image_directory . "image_" . rand() . ".jpeg";
                    $vpb_uploaded_file_movement_two = $vpb_upload_image_directory . "image_small_" . rand() . ".jpeg";
                }

                $findme = "png";
                $pos = strripos($vpb_image_filename, $findme);
                if ($pos === false) {
                    
                } else {
                    $vpb_uploaded_file_movement_one = $vpb_upload_image_directory . "image_" . rand() . ".png";
                    $vpb_uploaded_file_movement_two = $vpb_upload_image_directory . "image_small_" . rand() . ".png";
                }


                //			$vpb_uploaded_file_movement_one = $vpb_upload_image_directory."image_".rand()."_".$vpb_image_filename;
                //Pass the attached file to the uploads directory for the second image file
                //			$vpb_uploaded_file_movement_two = $vpb_upload_image_directory."image_small_".rand()."_".$vpb_image_filename;
                //Upload the first and second images
                imagejpeg($vpb_first_image_tmp, $vpb_uploaded_file_movement_one, 100);
                imagejpeg($vpb_second_image_tmp, $vpb_uploaded_file_movement_two, 100);

                imagedestroy($vpb_image_src);
                imagedestroy($vpb_first_image_tmp);
                imagedestroy($vpb_second_image_tmp);

                echo '<div class="sliki"><div class="image-cropper  img-polaroid"><input type="hidden" name="slika" value="' . $vpb_uploaded_file_movement_one . '"><input type="hidden" name="slikathumb" value="' . $vpb_uploaded_file_movement_two . '"><img class="centered" src="' . $vpb_uploaded_file_movement_two . '"></div></div>';
            }
        }
    }
}
?>