<!-- STUDENT.PHP FILE -->

<!-- INCLUDE BOOTSTRAP AND JQUERY-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<?php
// INCLUDE REQUIRED FILES
include_once './classes/StudentClass.php';
include_once './studentsInCourse.php';

// IF SHOW IS TRUE, SHOW TABLE
if (isset($_GET['show'])) {

    $studentCSVArray = studArrayFromFile('./csv/student.csv');
    $obj = 
    $studentObjArray = studArrayToObj($studentCSVArray);

    showStudTable($studentObjArray);
}

/**
 * GET STUDENTS FROM CSV FILE
 * @param { string } $path -> path of the file to get array from
 * @return { array } $csvArr -> array of students
*/
function studArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

/**
 * GET ARRAY OF STUDENTS, AND MAKE THEM INTO ARRAY OF STUDENT OBJECTS
 * if sicArr is not defined get sicArr from studentsInCourse.php
 * @param { array } $CSVarr -> array of students.
 * @param { array } $sicArr -> array of students part of course.
 * @return { array of objects } $objArr -> array of student objects. 
*/
function studArrayToObj($CSVarr, $sicArr = array()) {
    if (count($sicArr) == 0) {
        $tempSicArr = array();
        $tempSicArr = sicArrayFromFile('./csv/studentInCourse.csv');
        $sicArr = sicArrayToObj($tempSicArr);
    }
    $objArr = array();
    foreach ($CSVarr as &$stud) {
        $newStud = new Student($stud[0], $stud[1], $stud[2], $stud[3], 0, 0, 0, 0); 
        
        // run functions in studentClass.php to calculate the following;
        // coursesCompleted, coursesFailed, GPA and status
        $newStud->coursesCompleted = $newStud->findCoursesCompleted($sicArr);
        $newStud->coursesFailed = $newStud->findCoursesFailed($sicArr);
        $newStud->GPA = $newStud->calculateGPA($sicArr);
        $newStud->status = $newStud->findStatus($newStud->GPA);
        
        // Push it the student object into objArr
        array_push($objArr, $newStud);
    }

    // run validate function with the student array
    $objArr = validateStudentArray($objArr);
    // run compare function to sort array
    usort($objArr, 'GPAComparator');
    return $objArr;
}

/**
 * VALIDATE STUDENT ARRAY 
 * SEE IF THERE IS ANOTHER STUDENT WITH THE SAME STUDENTNO AND REMOVE THAT OBJECT. 
 * if sicArr is not defined get sicArr from studentsInCourse.php
 * @param { array } $array -> array of students to be validated.
 * @return { array } $temp_array -> cleaned array. 
*/
function validateStudentArray($array) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
         if (!in_array($val->studentNo, $key_array)) {
            $key_array[$i] = $val->studentNo;
            $temp_array[$i] = $val;
        }
        $i++; 
    }
    return $temp_array;
} 

/**
 * COMPARE GPA FOR EACH STUDENT, AND SORT THEM IN DECENDING ORDER
 * if sicArr is not defined get sicArr from studentsInCourse.php
 * @param { object } $a -> one course object from the array of course objects to reposition based on the other object
 * @param { object } $b -> object to check against
 * @return { bool } if first object is going to be moved or not (true or false)
*/
function GPAComparator ($a, $b){
    return $a->GPA < $b->GPA;
}

/**
 * SHOW TABLE WITH ALL STUDENT DATA THROUGH ECHOs
 * @param { array of objects } $studArr -> array of student objects.
*/
function showStudTable($studArr) {
    echo '<table class="table">
        <tr>
            <th scope="col">Student Number</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Birthday</th>
            <th scope="col">Course completed</th>
            <th scope="col">Course failed</th>
            <th scope="col">GPA</th>
            <th scope="col">Status</th>
        </tr>';
    // run function __toString in studentClass.php
    foreach ($studArr as &$stud) {
        $stud->__toString();
    }
    echo '</table>';
}
?>
<!-- go to course.php or back to index.php -->
<body>
    <div class="container-fluid">
        <a href="course.php?show=true"  class="btn btn-primary">Show courses</a>  
        <a href="index.php"   class="btn btn-primary">Back</a>
    </div>
</body>