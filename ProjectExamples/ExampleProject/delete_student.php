<?php
$studentsJson = file_get_contents('inputFiles/ateam.json');
$studentsArray = json_decode($studentsJson, true);
$stu = file_get_contents('php://input');
parse_str($stu, $output);
$jsonData = json_encode($output, true);
$data = json_decode($jsonData, true);
$id = $data['id'];
$name = $data['name'];

$indexToRemove = -1;
foreach ($studentsArray['students'] as $index => $student) {
    if (intval($student['id']) === intval($id)) {
        $indexToRemove = $index;
        break;
    }
}

if ($indexToRemove !== -1) {
    array_splice($studentsArray['students'], $indexToRemove, 1);
}

$updatedJson = json_encode($studentsArray, JSON_PRETTY_PRINT);

file_put_contents('inputFiles/ateam.json', $updatedJson);
?>
