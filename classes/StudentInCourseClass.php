<?php
class StudentInCourse {
    function __construct($studentNo, $courseCode, $year, $semester, $grade) {
        $this->studentNo = $studentNo;      // Primary key (Composite key) Foreign key from student
        $this->courseCode = $courseCode;    // Primary key (Composite key) Foreign key from courses
        $this->year = $year;                // Primary key (Composite key) Foreign key from courses
        $this->semester = $semester;        // Primary key (Composite key) Foreign key from courses
        $this->grade = $grade;
    }
}
?>