<?php

// The purpose of this API is to act as an intermediary to determing the json information to be returned by the example PageReader page.

$jsonData = get_file_by_id($_GET["id"]);

// -------------- Start paragraph gathering information 
function getParagraphInfo1() {
	return readJSONFile("inputFiles/para1.json");
}

function getParagraphInfo2() {
	return readJSONFile("inputFiles/para2.json");
}

function getParagraphInfo3() {
	return readJSONFile("inputFiles/para3.json");
}

function getParagraphInfo4() {
	return readJSONFile("inputFiles/para4.json");
}

function getParagraphInfo5() {
	return readJSONFile("inputFiles/para5.json");
}
function getParagraphInfo6() {
	return readJSONFile("inputFiles/para6.json");
}

function getParagraphInfo7() {
	return readJSONFile("inputFiles/para7.json");
}

function getParagraphInfo8() {
	return readJSONFile("inputFiles/para8.json");
}

function getParagraphInfo9() {
	return readJSONFile("inputFiles/para9.json");
}


function getParagraphInformation($rand){
//$rand = 1;
	switch ($rand){
	    case "1":
	      $jsonData = getParagraphInfo1();
	      break;
	    case "2":
	      $jsonData = getParagraphInfo2();
	      break;
	    case "3":
	      $jsonData = getParagraphInfo3();
	      break;
	    case "4":
	      $jsonData = getParagraphInfo4();
	      break;
	    case "5":
	      $jsonData = getParagraphInfo5();
	      break;
		case "6":
	      $jsonData = getParagraphInfo6();
	      break;
		case "7":
	      $jsonData = getParagraphInfo7();
	      break;
		case "8":
	      $jsonData = getParagraphInfo8();
	      break;
		case "9":
	      $jsonData = getParagraphInfo9();
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

function getATeamInformation() {
	return readJSONFile("inputFiles/ateam.json");
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
		case "6":
	      $jsonData = getATeamInformation();
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
      $jsonData = getDropDownInformation($rand);
      break;
    case "paragraphInfo":
      $jsonData = getParagraphInformation($rand);
      break;
    case "multChoice":
      $jsonData = getMultChoiceInformation();
      break;
	case "ateam":
      $jsonData = getATeamInformation();
      break;
  	}

}


?>


