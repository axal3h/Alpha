<?php
$stu = file_get_contents('php://input');
parse_str($stu, $output);
$jsonData = json_encode($output, true);

	$data = json_decode($jsonData, true);
	$studentOrder = $data['studentOrder'];	
    $studentsData = json_decode(file_get_contents('inputFiles/ateam.json'), true);
    $reorderedStudents = [];
    foreach ($studentOrder as $studentId) {
        foreach ($studentsData['students'] as $student) {
            if (intval($student['id']) == intval($studentId)) {
                $reorderedStudents[] = $student;
                break;
            }
        }
    }
    $studentsData['students'] = $reorderedStudents;
    file_put_contents('inputFiles/ateam.json', json_encode($studentsData, JSON_PRETTY_PRINT));
?>