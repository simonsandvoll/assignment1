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

    /**
     * ECHO TABLE ROWS FOR EACH OBJECT IN ARRAY OF COURSE OBJECTS. 
    */
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
    
    /**
     * GET NUMBER OF STUDENTS IN COURSE
     * @param { array } $arr is array of student-in-course, meaning array with info about all students who took courses with grade and credits. From data.php
     * @return { int } $count -> number of students part of course. 
    */
    function findNumStudents($arr) {
        $tempArr = array();
        $count = 0;
        foreach ($arr as &$course) {
            if ($course->courseCode == $this->courseCode){
                $count++;
            }
        }
        return $count;
    }

    /**
     * GET NUMBER OF STUDENT THAT HAS PASSED THE COURSE
     * @param { array } $arr is array of student-in-course. From data.php
     * @return { int } $studentCount -> number of students passed that specific course (students with grade != F)
    */
    function findNumStudentsPassed($arr) {
        $tempArr = array();
        $studentCount = 0;
        foreach ($arr as &$stud) {
            if ($stud->grade != 'F' && $stud->courseCode == $this->courseCode) {
                $stud->grade = strtoupper($stud->grade);
                array_push($tempArr, $stud);
            }
        }
        $studentCount = count($tempArr);
        return $studentCount;
    }
    /**
     * GET NUMBER OF STUDENT THAT HAS FAILED THE COURSE
     * @param { array } $arr is array of student-in-course. From data.php
     * @return { int } $studentCount -> number of students failed that specific course (students with grade = F)
    */
    function findNumStudentsFailed($arr) {

        $tempArr = array();
        foreach ($arr as &$stud) {
            if ($stud->grade == 'F' && $stud->courseCode == $this->courseCode) {
                $stud->grade = strtoupper($stud->grade);
                array_push($tempArr, $stud);
            }
        }
        return count($tempArr);
    }

    /**
     * GET GRADE AVERAGE OF STUDENTS IN COURSE
     * @param { array } $arr is student-in-course-array. From data.php
     * @return { string } $avgGrade -> the average grade for the course
    */
    function findAverageGrade($arr) {
        $grades = ["F", "E", "D", "C", "B", "A"];
        $gradeTemp = array();
        $tempSum = 0;
        $tempCount = 0;
        $avgGrade = '';
        foreach ($arr as &$stud) {
            if ($stud->courseCode == $this->courseCode) {
                $stud->grade = strtoupper($stud->grade);
                // FIND POINT BY GETTING KEY FROM GRADES ARRAY
                $point = array_search($stud->grade, $grades);
                array_push($gradeTemp, $point);
            }
        }
        if(count($gradeTemp)) {
            
            $tempSum = array_sum($gradeTemp);
            $tempCount = count($gradeTemp);

            $gradeTemp = array_filter($gradeTemp);
            $average = $tempSum / $tempCount;
            
        } 
        $avgGrade = $grades[round($average)];
        return $avgGrade;
    }
}

?>