<?php
class Course {
    function __construct($courseCode, $courseName, $year, $semester, $instructor, $credits, 
                        $numStudents, $numStudentsPassed, $numStudentsFailed, $averageGrade) {
        $this->courseCode = $courseCode;    // Primary key (Composite key)
        $this->courseName = $courseName;
        $this->year = $year;                // Primary key (Composite key)
        $this->semester = $semester;        // Primary key (Composite key)
        $this->instructor = $instructor;
        $this->credits = $credits;
        $this->numStudents = $numStudents;
        $this->numStudentsPassed = $numStudentsPassed;
        $this->numStudentsFailed = $numStudentsFailed;
        $this->averageGrade = $averageGrade;
    }

    public function __toString(){
        echo '<tr>
            <td>' . $this->courseCode . '</td>
            <td>' . $this->courseName . '</td>
            <td>' . $this->year . '</td>
            <td>' . $this->semester . '</td>
            <td>' . $this->instructor . '</td>
            <td>' . $this->credits . '</td>
            <td>' . $this->numStudents . '</td>
            <td>' . $this->numStudentsPassed . '</td>
            <td>' . $this->numStudentsFailed . '</td>
            <td>' . $this->averageGrade . '</td>
        </tr>';
    }
    
    function findNumStudents($arr) {
        // find number of students registered for course
    }

    function findNumStudentsPassed($arr) {
        // find number of students that passed the course
    }

    function findNumStudentsFailed($arr) {
        // find number of students that failed the course
    }
    function findAverageGrade($arr) {
        // find grade average
    }



}

?>