<?php
$studentsJson = file_get_contents('inputFiles/students.json');
$studentsArray = json_decode($studentsJson, true);
file_put_contents('inputFiles/ateam.json', json_encode($studentsArray, JSON_PRETTY_PRINT));

?>
