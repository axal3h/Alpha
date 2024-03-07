<?php
session_start();

// Assuming a session variable 'studentList' holds the current list for the session.
if (!isset($_SESSION['studentList'])) {
    // If not set, initialize it with the content of the original JSON file.
    $_SESSION['studentList'] = json_decode(file_get_contents("inputFiles/dropDownListStudents.json"), true);
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request is to update the student list.
    if (isset($_POST['updateList']) && isset($_POST['students'])) {
        // Decode the JSON sent from the client.
        $newList = json_decode($_POST['students'], true);
        if ($newList) {
            // Update the session variable.
            $_SESSION['studentList']['dropdownOptions'] = $newList;
            // Return a success response.
            echo json_encode(['success' => true]);
        } else {
            // Return an error if JSON is invalid.
            echo json_encode(['error' => 'Invalid JSON']);
        }
    }
    exit;
}

// If the request is not POST, just return the current list from the session.
echo json_encode($_SESSION['studentList']);
<?php
session_start();

// Assuming 'dropDownListStudents.json' holds the original list of students.
$originalJsonFile = "inputFiles/dropDownListStudents.json";
$sessionJsonFile = "inputFiles/sessionStudentList.json";

// Initialize the session student list with the original list if not already present
if (!isset($_SESSION['studentList'])) {
    $_SESSION['studentList'] = json_decode(file_get_contents($originalJsonFile), true);
}

header('Content-Type: application/json');

// If the client is requesting the list, just return it
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($_SESSION['studentList']);
    exit;
}

// If the client is sending an updated list, validate and save it
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonInput = file_get_contents('php://input');
    $updatedList = json_decode($jsonInput, true);

    // Perform your validation/sanitization on $updatedList here

    // If the list is valid, save it to the session and the file for persistence
    if ($updatedList) {
        $_SESSION['studentList'] = $updatedList;
        
        // Write the new list to a file for persistence across sessions
        if (file_put_contents($sessionJsonFile, json_encode($updatedList))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Could not write to file']);
        }
    } else {
        echo json_encode(['error' => 'Invalid JSON in POST request']);
    }
    exit;
}
?>

?>
