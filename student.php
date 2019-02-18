<?php
include_once './classes/StudentClass.php';
include_once './studentsInCourse.php';


if (isset($_GET['show'])) {

    $studentCSVArray = studArrayFromFile('./csv/student.csv');

    $studentObjArray = studArrayToObj($studentCSVArray);

    showStudTable($studentObjArray);
}


function studArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

function studArrayToObj($CSVarr, $sicArr = array()) {
    if (count($sicArr) == 0) {
        $tempSicArr = array();
        $tempSicArr = sicArrayFromFile('./csv/studentInCourse.csv');
        $sicArr = sicArrayToObj($tempSicArr);
    }
    $objArr = array();
    foreach ($CSVarr as &$stud) {
        $newStud = new Student($stud[0], $stud[1], $stud[2], $stud[3], 0, 0, 0, 0); 
        $newStud->coursesCompleted = $newStud->findCoursesCompleted($sicArr);
        $newStud->coursesFailed = $newStud->findCoursesFailed($sicArr);
        $newStud->GPA = $newStud->calculateGPA($sicArr);
        $newStud->status = $newStud->findStatus($newStud->GPA);
        
        array_push($objArr, $newStud);
    }
    $objArr = validateStudentArray($objArr);
    usort($objArr, 'GPAComparator');
    return $objArr;
}

// VALIDATE STUDENT ARRAY -> SEE IF THERE IS ANOTHER STUDENT WITH THE SAME STUDENTNO
// AND REMOVE THAT OBJECT. 
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

function GPAComparator ($a, $b){
    return $a->GPA < $b->GPA;
}

function showStudTable($studArr) {
    echo '<table>
        <tr>
            <th>Student Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Birthday (UNIX)</th>
            <th>Course completed</th>
            <th>Course failed</th>
            <th>GPA</th>
            <th>Status</th>
        </tr>';
    foreach ($studArr as &$stud) {
        $stud->__toString();
    }
    echo '</table>';
}



?>