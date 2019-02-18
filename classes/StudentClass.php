<?php
class Student {
    function __construct($studentNo, $firstName, $lastName, $birthdate, $coursesCompleted, $coursesFailed, $GPA, $status) {
        $this->studentNo = $studentNo;      // Primary key
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->coursesCompleted = $coursesCompleted;
        $this->coursesFailed = $coursesFailed;
        $this->GPA = $GPA;
        $this->status = $status;
    }

    public function __toString(){
        echo '<tr>
            <td>' . $this->studentNo . '</td>
            <td>' . $this->firstName . '</td>
            <td>' . $this->lastName . '</td>
            <td>' . $this->birthdate . '</td>
            <td>' . $this->coursesCompleted . '</td>
            <td>' . $this->coursesFailed . '</td>
            <td>' . $this->GPA . '</td>
            <td>' . $this->status . '</td>
        </tr>';
    }
    function findCoursesCompleted($arr) {
        // get the number of courses completed from student in course array
    }
    function findCoursesFailed($arr) {
        // get the number of courses failed from student in course array. 
    }
    function calculateGPA($arr) {
        // get gpa
        $grades = array('F', 'E', 'D', 'C', 'B', 'A');
        foreach ($arr as &$stud) {
            $tempPoint = array_search($stud->grade, $grades);
            echo $tempPoint . '<br>';
        }
    }
    function findStatus($gpa) {
        // find status from GPA
    }
}

// student number, name,surname, birthdate, total number of courses completed, 
// total number of courses failed, andGPA (grade point average), and status for each student. 
?>