<?php
include_once './classes/StudentClass.php';

if (isset($_GET['show'])) {

    $studentCSVArray = studArrayFromFile('./csv/student.csv');

    $studentObjArray = studArrayToObj($studentCSVArray);

    showStudTable($studentObjArray);
}


function studArrayFromFile($path) {
    $csvArr = array_map('str_getcsv', file($path));
    return $csvArr;
}

function studArrayToObj($CSVarr) {
    $objArr = array();
    foreach ($CSVarr as &$stud) {
        $newStud = new Student($stud[0], $stud[1], $stud[2], $stud[3], $stud[4], $stud[5], $stud[6], $stud[7]);
        array_push($objArr, $newStud);
    }
    return $objArr;
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