<?php
include_once './classes/CourseClass.php';
if (isset($_GET['show'])) {

    $courseCSVArray = courseArrayFromFile('./csv/course.csv');
    
    $courseObjArray = courseArrayToObj($courseCSVArray);
    
    showCourseTable($courseObjArray);
}

function courseArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

function courseArrayToObj($CSVarr) {
    $objArr = array();
    foreach ($CSVarr as &$course) {
        $newCourse = new Course($course[0], $course[1], $course[2], $course[3], $course[4], $course[5], $course[6], 0, 0, 0);
        array_push($objArr, $newCourse);
    }
    return $objArr;
}

function showCourseTable($courseArr) {
    echo '<table>
    <tr>
        <th>Course code</th>
        <th>Course name</th>
        <th>Year</th>
        <th>Semester</th>
        <th>Instructor</th>
        <th>Credits</th>
        <th>Students registered</th>
        <th>Students passed</th>
        <th>Students failed</th>
        <th>Average grade</th>
    </tr>'; 
    foreach ($courseArr as &$course) {
        $course->__toString();
    }
    echo '</table>';
}


?>