<?php
include_once './classes/CourseClass.php';
include_once './studentsInCourse.php';

if (isset($_GET['show'])) {

    $courseCSVArray = courseArrayFromFile('./csv/course.csv');
    
    $courseObjArray = courseArrayToObj($courseCSVArray);
    
    showCourseTable($courseObjArray);
}

function courseArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

function courseArrayToObj($CSVarr, $sicArr = array()) {
    if (count($sicArr) == 0) {
        $tempSicArr = array();
        $tempSicArr = sicArrayFromFile('./csv/studentInCourse.csv');
        $sicArr = sicArrayToObj($tempSicArr);
    }
    $objArr = array();
    foreach ($CSVarr as &$course) {
        $newCourse = new Course($course[0], $course[1], $course[2], $course[3], $course[4], $course[5], 0, 0, 0, 0);
        $newCourse->numStudents = $newCourse->findNumStudents($sicArr);
        $newCourse->numStudentsPassed = $newCourse->findNumStudentsPassed($sicArr);
        $newCourse->numStudentsFailed = $newCourse->findNumStudentsFailed($sicArr);
        $newCourse->averageGrade = $newCourse->findAverageGrade($sicArr);
        array_push($objArr, $newCourse);
    }
    validateCourseArray($objArr);
    usort($objArr, 'enrolledComparator');
    return $objArr;
}

// VALIDATE COURSE ARRAY -> SEE IF THERE IS ANOTHER COURSE WITH THE SAME courseCode
// AND REMOVE THAT OBJECT. 
function validateCourseArray($array) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
         if (!in_array($val->courseCode, $key_array)) {
            $key_array[$i] = $val->courseCode;
            $temp_array[$i] = $val;
        }
        $i++; 
    }
    return $temp_array;
} 
// SORTING COURSES BASED ON STUDENTS REGISTERED FOR COURSE IN ACENDING ORDER
// FUNCTION CALLED FORM DATABASE.PHP INSIDE THE getCourses() FUNCTION
function enrolledComparator($object1, $object2) { 
    return $object1->numStudents > $object2->numStudents; 
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