<?php

include_once './student.php';
include_once './course.php';

if ( isset($_POST['submit']) ) {
    if ( isset($_FILES["file"]) ) {
        //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
             echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
            echo 'file uploaded ';

            $fileName = $_FILES["file"]["name"];
            echo $fileName;
            if ($_FILES["file"]["size"] > 0) {
                $fh = fopen($_FILES['file']['tmp_name'], 'r+');
                $importArray = array();
                while( ($row = fgetcsv($fh)) !== FALSE ) {
                    $importArray[] = $row;
                }
                echo '<pre>'; print_r($importArray); echo '</pre>';

            }
        }
    } else {
            echo "No file selected <br />";
    }
}



?>