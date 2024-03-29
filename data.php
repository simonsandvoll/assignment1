<?php
// include required files
include_once './student.php';
include_once './course.php';
include_once './studentsInCourse.php';

// when file is submitted check the file
if ( isset($_POST['submit']) ) {
    if ( isset($_FILES["file"]) ) {
        //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
             echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
             header('Location: index.php?upload=false');
        } else {
            echo 'file uploaded ';

            $fileName = $_FILES["file"]["name"];
            if ($_FILES["file"]["size"] > 0) {
                $fh = fopen($_FILES['file']['tmp_name'], 'r+');
                $importArray = array();
                while( ($row = fgetcsv($fh)) !== FALSE ) {
                    $importArray[] = $row;
                }
                $sicArr = splitArray($importArray, 'sic');
                $studArr = splitArray($importArray, 'stud');
                $courseArr = splitArray($importArray, 'course');
                
                // runs functions in their respected php files -> sicArr to studentIncourse.php. ->studArr to student.php. ->courseArr to course.php
                $sicArr = sicArrayToObj(removeDuplicates($sicArr));
                $studArr = studArrayToObj(removeDuplicates($studArr), $sicArr);
                $courseArr = courseArrayToObj(removeDuplicates($courseArr), $sicArr);

               // write array of objects to csv file. 
                writeToFile($sicArr, './csv/studentInCourse.csv');
                writeToFile($studArr, './csv/student.csv');
                writeToFile($courseArr, './csv/course.csv');
                
                // redirect back to index.php
                header('Location: index.php?upload=true');   
            }
        }
    } else {
            echo "No file selected <br />";
            header('Location: index.php?upload=false');
    }
}

/**
 * SPLIT IMPORTED ARRAY INTO IT'S RESPECTED ARRAYS: STUDENTARRAY, COURSEARRAY AND STUDENTINCOURSEARRAY
 * @param { array } $arr -> array to split
 * @param { string } $value -> what type of array it is; student, course, or student-in-course
 * @return { array } $--Arr -> dependant on what the value is. Returns array with only the selected values.
*/
function splitArray($arr, $value) {
    if ($value == 'stud') {
        $studArr = array();
        $studCsv = studArrayFromFile('./csv/student.csv');
        if (count($studCsv) != 0) {
            foreach($studCsv as &$cStud) {
                array_push($studArr, $cStud);
            }
        }
        foreach($arr as &$stud) {
            array_push($studArr, array($stud[0], $stud[1], $stud[2], $stud[3]));
        }
        return $studArr;
    }
    if ($value == 'course') {
        $courseArr = array();
        $courseCsv = courseArrayFromFile('./csv/course.csv');
        if (count($courseCsv) != 0) {
            foreach($courseCsv as &$cCourse) {
                array_push($courseArr, $cCourse);
            }
        }
        foreach($arr as &$course) {
            array_push($courseArr, array($course[4], $course[5], $course[6], $course[7], $course[8], $course[9]));
        }
        return $courseArr;
    }
    if ($value == 'sic') {
        $sicArr = array();
        $sicCsv = sicArrayFromFile('./csv/studentInCourse.csv');
        if (count($sicCsv) != 0) {
            foreach($sicCsv as &$cSic) {
                array_push($sicArr, $cSic);
            }
        }
        foreach($arr as &$sic) {
            array_push($sicArr, array($sic[0], $sic[4], $sic[6], $sic[7], $sic[10], $sic[9]));
        }
        return $sicArr;
    }
}

/**
 * FINDS AND REMOVES DUPLICATES FORM ARRAY.
 * @param { array } $arr -> array to clean
 * @return { array } $arr -> with removed duplicates
*/
function removeDuplicates($arr) {
    $arr = array_map("unserialize", array_unique(array_map("serialize",  $arr)));
    $arr = array_values($arr);
    return $arr;
}

/**
 * GETS ARRAY OF OBJECTS AND THE PATH TO THE FILE THAT IS 
 * BEING OVERWRITTEN AND WRITES A LINE FOR EACH OBJECT. 
 * @param { array } $arr -> array to write into a file
 * @return { string } $path -> path of the file 
*/
function writeToFile($arr, $path) {
    $csv_file = fopen($path, 'w');
    foreach ($arr as &$fields) {
        fputcsv($csv_file, get_object_vars($fields));
    }
    fclose($csv_file);
}
?>