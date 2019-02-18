<!-- COURSE.PHP FILE -->

<!-- INCLUDE BOOTSTRAP AND JQUERY-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<?php
// INCLUDE REQUIRED FILES
include_once './classes/CourseClass.php';
include_once './studentsInCourse.php';

// IF SHOW IS TRUE, SHOW TABLE
if (isset($_GET['show'])) {

    $courseCSVArray = courseArrayFromFile('./csv/course.csv');
    
    $courseObjArray = courseArrayToObj($courseCSVArray);
    
    showCourseTable($courseObjArray);
}

// GET COURSES FROM CSV FILE
function courseArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

// GET ARRAY OF COURSES, AND MAKE THEM INTO ARRAY OF COURSE OBJECTS
// if sicArr is not defined get sicArr from studentsInCourse.php
function courseArrayToObj($CSVarr, $sicArr = array()) {
    if (count($sicArr) == 0) {
        $tempSicArr = array();
        $tempSicArr = sicArrayFromFile('./csv/studentInCourse.csv');
        $sicArr = sicArrayToObj($tempSicArr);
    }
    $objArr = array();
    foreach ($CSVarr as &$course) {
        $newCourse = new Course($course[0], $course[1], $course[2], $course[3], $course[4], $course[5], 0, 0, 0, 0);
        
        // run functions in courseclass.php to calculate the following; 
        // numStudents, numStudentsPassed, numStudentsFailed and averageGrade
        $newCourse->numStudents = $newCourse->findNumStudents($sicArr);
        $newCourse->numStudentsPassed = $newCourse->findNumStudentsPassed($sicArr);
        $newCourse->numStudentsFailed = $newCourse->findNumStudentsFailed($sicArr);
        $newCourse->averageGrade = $newCourse->findAverageGrade($sicArr);
        
        // Push it the student object into objArr
        array_push($objArr, $newCourse);
    }

    // run validate function with the course array
    $objArr = validateCourseArray($objArr);
    // run compare function to sort array
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
function enrolledComparator($object1, $object2) { 
    return $object1->numStudents > $object2->numStudents; 
} 

// SHOW TALBE WITH ALL COURSE DATA
function showCourseTable($courseArr) {
    echo '<table class="table">
    <tr>
        <th scope="col">Course code</th>
        <th scope="col">Course name</th>
        <th scope="col">Year</th>
        <th scope="col">Semester</th>
        <th scope="col">Instructor</th>
        <th scope="col">Credits</th>
        <th scope="col">Students registered</th>
        <th scope="col">Students passed</th>
        <th scope="col">Students failed</th>
        <th scope="col">Average grade</th>
    </tr>'; 
    // run function __toString in courseClass.php
    foreach ($courseArr as &$course) {
        $course->__toString();
    }
    echo '</table>';
}


?>
<!-- go to student.php or back to index.php -->
<body>
    <div class="container-fluid">
        <a href="student.php?show=true"  class="btn btn-primary">Show students</a>  
        <a href="index.php"   class="btn btn-primary">Back</a>
    </div>
</body>