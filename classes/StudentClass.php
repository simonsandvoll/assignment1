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
        $tempArr = array();
        foreach ($arr as &$stud) {
            if ($stud->grade != 'F' && $stud->studentNo == $this->studentNo) {
                array_push($tempArr, $stud);
            }
        }
        return count($tempArr);
    }

    function findCoursesFailed($arr) {
        // get the number of courses failed from student in course array. 
        $tempArr = array();
        foreach ($arr as &$stud) {
            if ($stud->grade == 'F' && $stud->studentNo == $this->studentNo) {
                array_push($tempArr, $stud);
            }
        }
        return count($tempArr);
    }

    function calculateGPA($arr) {
        // get gpa
        $tempCredit = 0;
        
        $pointPerCourse = array();

        $point = 0;
        $mulCredit = 0;
        $gradeCredit = 0;
        $gradeCreditSum = 0;
        $result = 0;

        $grades = ["F", "E", "D", "C", "B", "A"];
        
        foreach ($arr as &$course) {
            if ($course->studentNo == $this->studentNo) {
                $mulCredit += $course->credit;
            }
        }

        foreach ($arr as &$stud) {
            if ($stud->studentNo == $this->studentNo) {
                $point = array_search($stud->grade, $grades);
                $tempCredit = $stud->credit;
                $gradeCredit = $point*$tempCredit;
                array_push($pointPerCourse, $gradeCredit);
            }
        }
        $gradeCreditSum = array_sum($pointPerCourse);
        $result = $gradeCreditSum / $mulCredit;

        $result = round($result, 2);

        return $result;
    }
    
    function findStatus($gpa) {
        // find status from GPA
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