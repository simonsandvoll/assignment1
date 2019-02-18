<?php
// INCLUDE REQUIRED FILES
include_once './classes/StudentInCourseClass.php';

// GET STUDENTS-IN-COURSE FROM CSV FILE
function sicArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

// GET ARRAY OF STUDENT-IN-COURSE, AND MAKE THEM INTO ARRAY OF STUDENT-IN-COURSE OBJECTS
function sicArrayToObj($CSVarr) {
    $objArr = array();
    foreach ($CSVarr as &$siC) {
        $newSiC = new StudentInCourse($siC[0], $siC[1], $siC[2], $siC[3], $siC[4], $siC[5]); // $studentNo, $courseCode, $year, $semester, $grade, $credit
        array_push($objArr, $newSiC);
    }
    return $objArr;
}


?>