<?php

include_once './student.php';
include_once './course.php';
include_once './studentsInCourse.php';

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
                /* echo '<pre>'; print_r($importArray); echo '</pre>'; */
                
                $sicArr = splitArray($importArray, 'sic');
                
                $studArr = splitArray($importArray, 'stud');
                $courseArr = splitArray($importArray, 'course');

                foreach ($studArr as &$item) {
                    foreach($sicArr as &$stud) {
                        if ($item[0] == $stud[0]) {
                            foreach($courseArr as &$course) {
                                if ($stud[1] == $course[0]) {
                                    $stud[5] = $course[5];
                                }
                            }
                        }
                    }
                }

                $sicArr = sicArrayToObj(removeDuplicates($sicArr));
                $studArr = studArrayToObj(removeDuplicates($studArr), $sicArr);
                $courseArr = courseArrayToObj(removeDuplicates($courseArr), $sicArr);
                
               /*  echo '<pre>'; print_r($sicArr); echo '</pre>';
                echo '<pre>'; print_r($studArr); echo '</pre>';
                echo '<pre>'; print_r($courseArr); echo '</pre>'; */
               
                writeToFile($sicArr, './csv/studentInCourse.csv');
                writeToFile($studArr, './csv/student.csv');
                writeToFile($courseArr, './csv/course.csv');
                
            }
        }
    } else {
            echo "No file selected <br />";
    }
}

function splitArray($arr, $value) {
    if ($value == 'stud') {
        $studArr = array();
        foreach($arr as &$stud) {
            array_push($studArr, array($stud[0], $stud[1], $stud[2], $stud[3]));
        }
        return $studArr;
    }
    if ($value == 'course') {
        $courseArr = array();
        foreach($arr as &$course) {
            array_push($courseArr, array($course[4], $course[5], $course[6], $course[7], $course[8], $course[9]));
        }
        return $courseArr;
    }
    if ($value == 'sic') {
        $sicArr = array();
        foreach($arr as &$sic) {
            array_push($sicArr, array($sic[0], $sic[4], $sic[6], $sic[7], $sic[10]));
        }// $studentNo, $courseCode, $year, $semester, $grade
        return $sicArr;
    }
}

/* _____________________________________ REMOVE DUPLICATES _____________________________________ */

// FINDS AND REMOVES DUPLICATES FORM ARRAY.
function removeDuplicates($arr) {
    $arr = array_map("unserialize", array_unique(array_map("serialize",  $arr)));
    $arr = array_values($arr);
    return $arr;
}

/* _____________________________________ WRITE ARRAY OF OBJECTS TO CSV _____________________________________ */
// GETS ARRAY OF OBJECTS AND THE PATH TO THE FILE THAT IS BEING OVERWRITTEN AND WRITES A LINE FOR
// EACH OBJECT. 
function writeToFile($arr, $path) {
    $csv_file = fopen($path, 'w');
    foreach ($arr as &$fields) {
        fputcsv($csv_file, get_object_vars($fields));
    }
    fclose($csv_file);
}

// redirect back to index.php
header('Location: index.php?upload=true');


?>