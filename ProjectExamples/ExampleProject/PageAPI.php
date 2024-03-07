<?php

// The purpose of this API is to act as an intermediary to determing the json information to be returned by the example PageReader page.

$jsonData = get_file_by_id($_GET["id"]);






// -------------- Start paragraph gathering information 
function getAlphateam1() {
	return readJSONFile("inputFiles/Alphateam1.json");
}

function getAlphateam2() {
	return readJSONFile("inputFiles/Alphateam2.json");
}

function getTigers1() {
	return readJSONFile("inputFiles/Tigers1.json");
}

function getTigers2() {
	return readJSONFile("inputFiles/Tigers2.json");
}

function getATeam1() {
	return readJSONFile("inputFiles/ATeam1.json");
}
function getATeam2() {
	return readJSONFile("inputFiles/ATeam2.json");
}
function getCodeCrafters1() {
	return readJSONFile("inputFiles/CodeCrafters1.json");
}
function getCodeCrafters2() {
	return readJSONFile("inputFiles/CodeCrafters2.json");
}
function getInstructor() {
	return readJSONFile("inputFiles/Instructor.json");
}

function getOrigStudentNames()
{
	return readJSONFile("inputFiles/dropDownListStudentsEdits.json");
}

function getParagraphInformation($rand){
//$rand = 1;
	switch ($rand){
	    case "1":
	      $jsonData = getAlphateam1();
	      break;
	    case "2":
	      $jsonData = getAlphateam2();
	      break;
	    case "3":
	      $jsonData = getTigers1();
	      break;
	    case "4":
	      $jsonData = getTigers2();
	      break;
	    case "5":
	      $jsonData = getATeam1();
	      break;
            case "6":
	      $jsonData = getATeam2();
	      break;
            case "7":
	      $jsonData = getCodeCrafters1();
	      break;
            case "8":
	      $jsonData = getCodeCrafters2();
	      break;
            case "9":
	      $jsonData = getInstructor();
	      break;
	  }
}




// -------------- Start dropdown gathering information 

// Call the JSON files using these functions.
//		This could likely be removed and the file calls made directly in the if statement.
function getDropDownInformationState() {
	return readJSONFile("inputFiles/dropDownListState.json");
}

function getDropDownInformationStooge() {
	return readJSONFile("inputFiles/dropDownListStooge.json");
}

function getDropDownInformationMLB() {
	return readJSONFile("inputFiles/dropDownListBaseball.json");
}

function getDropDownInformationNFL() {
	return readJSONFile("inputFiles/dropDownListNFL.json");
}

function getDropDownInformationNHL() {
	return readJSONFile("inputFiles/dropDownListNHL.json");
}


function getMultChoiceInformation() {
	return readJSONFile("inputFiles/shortOptions.json");
}

function getdropDownListStudents() {
	return readJSONFile("inputFiles/dropDownListStudents.json");
}



// If it is a dropdown list, take the random value that is being passed in to randomly determine what the contents of the dropdown list should be. This will help with dynamically creating the page.
function getDropDownInformation($rand){
//$rand = 1;
	switch ($rand){
	    case "1":
	      $jsonData = getDropDownInformationState();
	      break;
	    case "2":
	      $jsonData = getDropDownInformationStooge();
	      break;
	    case "3":
	      $jsonData = getDropDownInformationMLB();
	      break;
	    case "4":
	      $jsonData = getDropDownInformationNFL();
	      break;
	    case "5":
	      $jsonData = getDropDownInformationNHL();
	      break;
	  }
}






// ----------------------- THE PRIMARY PAGE FUNCTIONS -----------------------

// Create a basic file for just getting the contents of a JSON file
function readJSONFile($url) {

	$JSON = file_get_contents($url);
	echo $JSON; // return the information to be read by the reader page
}


// Get a random value from an external API.
function getRandomValue(){

// Make this a variable
	// https://l3harriscourseexamples.onrender.com/ProjectExamples/RandomAPI.php?action=get_RandomValue
	$extRandomURL = "https://l3harriscourseexamples.onrender.com/ProjectExamples/RandomAPI.php?action=get_RandomValue"; // make this a global variable
	$content = file_get_contents($extRandomURL);
	$result  = json_decode($content);
	return $result;
}

// The main function that drives the page
function get_file_by_id($id){
	//$rand = getRandomValue();
        $jsonDataSel = $_GET["sel"]; 
        $rand = $jsonDataSel;  
 	switch ($id){
    case "dropdown":
      $jsonData = getdropDownListStudents($rand);
      break;
    case "paragraphInfo":
      $jsonData = getParagraphInformation($rand);
      break;
    case "multChoice":
      $jsonData = getMultChoiceInformation();
      break;
  	}
}
// Function to store students list
function storeStudentsList()
{
	// Check if the request method is POST
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		http_response_code(400); // Bad request
		echo json_encode(array('error' => 'Invalid request method'));
		return;
	}

	// Get the JSON data from the request body
	$jsonString = file_get_contents('php://input');

	// Decode the JSON data
	$requestData = json_decode($jsonString, true);

	// Check if 'students' array is present
	if (!isset($requestData['students'])) {
		http_response_code(400); // Bad request
		echo json_encode(array('error' => 'Missing students data'));
		return;
	}

	// Extract students array
	$students = $requestData['students'];

	// Prepare data to write to the JSON file
	$data = array('dropdownOptions' => array());
	foreach ($students as $student) {
		// Debugging: Inspect the $student array
		var_dump($student);

		// Ensure required keys are set
		if (isset($student['value']) && isset($student['label'])) {
			$data['dropdownOptions'][] = array('value' => $student['value'], 'label' => $student['label']);
		} else {
			// Error handling: Log or echo an error message
			error_log("Invalid student data: " . print_r($student, true));
			// You can also return an error response if needed
			http_response_code(500);
			echo json_encode(array('error' => 'Invalid student data'));
			return;
		}
	}

	// Convert data to JSON format
	$jsonData = json_encode($data, JSON_PRETTY_PRINT);

	// Path to the JSON file
	$jsonFilePath = 'inputFiles/dropDownListStudents.json';

	// Write data to the JSON file
	if (file_put_contents($jsonFilePath, $jsonData) !== false) {
		echo json_encode(array('success' => 'Students list saved successfully'));
	} else {
		http_response_code(500); // Internal server error
		echo json_encode(array('error' => 'Failed to save students list'));
	}
}

// Call the function to save students list when the script receives a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	storeStudentsList();
}

?>


