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


    /**
     * ECHO TABLE ROWS FOR EACH OBJECT IN ARRAY OF STUDENT OBJECTS. 
     * Also convert birtday from unix into normal date format (for display purposes)
    */
    public function __toString(){
        echo '<tr>
            <td>' . $this->studentNo . '</td>
            <td>' . $this->firstName . '</td>
            <td>' . $this->lastName . '</td>
            <td>' . $this->convertUnix($this->birthdate) . '</td>
            <td>' . $this->coursesCompleted . '</td>
            <td>' . $this->coursesFailed . '</td>
            <td>' . $this->GPA . '</td>
            <td>' . $this->status . '</td>
        </tr>';
    }

    
    /**
     * CONVERTS STORED UNIX TIMESTAMP INTO A READABLE DATE
     * @return { date string } returned date as Greenwich Mean Time (GMT).
    */
    function convertUnix ($unix) {
        return gmdate("Y-m-d", $unix);  
    }
    /**
     * GET NUMBER OF COURSES COMPLETED FOR STUDENT
     * @param { array } $arr is array of student-in-course, meaning array with info about all students who took courses with grade and credits. From data.php
     * @return { int } count of the number of course completed (where grade != F) for one student. 
    */
    function findCoursesCompleted($arr) {
        $tempArr = array();
        foreach ($arr as &$stud) {
            if ($stud->grade != 'F' && $stud->studentNo == $this->studentNo) {
                $stud->grade = strtoupper($stud->grade);
                array_push($tempArr, $stud);
            }
        }
        return count($tempArr);
    }

    /**
     * GET NUMBER OF COURSES FAILED BY STUDENT
     * @param { array } $arr is array of student-in-course. From data.php
     * @return { int } count of the number of course failed (where grade == F) for one student. 
    */
    function findCoursesFailed($arr) {
        $tempArr = array();
        foreach ($arr as &$stud) {
            if ($stud->grade == 'F' && $stud->studentNo == $this->studentNo) {
                $stud->grade = strtoupper($stud->grade);
                array_push($tempArr, $stud);
            }
        }
        return count($tempArr);
    }
    
    /**
     * CALCULATE GPA FOR STUDENT FOR STUDENT
     * @param { array } $arr is array of student-in-course. From data.php
     * @return { float } $result -> result of the GPA calculation: sum(course_credit x grade) / sum(credits_taken). 
    */    
    function calculateGPA($arr) {
        $tempCredit = 0;
        $pointPerCourse = array();
        $point = 0;
        $mulCredit = 0;
        $gradeCredit = 0;
        $gradeCreditSum = 0;
        $result = 0;

        $grades = ["F", "E", "D", "C", "B", "A"];
        
        // GET ACCUMULATED CREDIT OF STUDENT
        foreach ($arr as &$course) {
            if ($course->studentNo == $this->studentNo) {
                $mulCredit += $course->credit;
            }
        }

        // FIND SUM COURSE_CREDIT MULTIPLIED WITH GRADE
        foreach ($arr as &$stud) {
            if ($stud->studentNo == $this->studentNo) {
                $stud->grade = strtoupper($stud->grade);
                // FIND POINT BY GETTING KEY FROM GRADES ARRAY
                $point = array_search($stud->grade, $grades);
                $tempCredit = $stud->credit;
                $gradeCredit = $point*$tempCredit;
                array_push($pointPerCourse, $gradeCredit);
            }
        }
        $gradeCreditSum = array_sum($pointPerCourse);
        // CALCULATE sum(course_credit x grade) / sum(credits_taken).
        $result = $gradeCreditSum / $mulCredit;
        $result = round($result, 2);
        // RETURN GPA
        return $result;
    }
    /**
     * FIND STATUS BASED ON GPA FOR STUDENT
     * @param { float } $gpa is the gpa calculated from the calculateGPA function.
     * @return { string } $status -> string with the student status -> if high GPA status = 'High Honour'. 
    */ 
    function findStatus($gpa) {
        $status = '';
        switch ($gpa) {
            case ($gpa>=0 && $gpa<=1.9):
                $status = 'Unsatisfactory';
                break;
            case ($gpa>=2 && $gpa<=2.9):
                $status = 'Satisfactory';
                break;
            case ($gpa>=3 && $gpa<=3.9):
                $status = 'Honour';
                break;
            case ($gpa>=4 && $gpa<=5):
                $status = 'High Honour';
                break;
        }
        return $status;
    }
}

?>