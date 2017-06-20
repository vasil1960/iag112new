<?php

function WA_Auth_GetComparisonsForRule($ruleName){
	$comparisons = array();
	
	switch ($ruleName){
		case "Editor":
			$comparisons[0] = array(FALSE, "".((isset($_SESSION['Active']))?$_SESSION['Active']:"")  ."", 2, "1");
			$comparisons[1] = array(FALSE, "".((isset($_SESSION['Access112']))?$_SESSION['Access112']:"")  ."", 2, "2");
			break;
		case "Editor_and_InsertMessage":
			$comparisons[0] = array(FALSE, "".((isset($_SESSION['Active']))?$_SESSION['Active']:"")  ."", 2, "1");
			$comparisons[1] = array(TRUE, "".((isset($_SESSION['Access112']))?$_SESSION['Access112']:"")  ."", 20, "Editor_and_InsertMessage");
			break;
		case "InsertMessage":
			$comparisons[0] = array(FALSE, "".((isset($_SESSION['Active']))?$_SESSION['Active']:"")  ."", 2, "1");
			$comparisons[1] = array(FALSE, "".((isset($_SESSION['Access112']))?$_SESSION['Access112']:"")  ."", 2, "3");
			break;
		case "User":
			$comparisons[0] = array(FALSE, "".((isset($_SESSION['Active']))?$_SESSION['Active']:"")  ."", 2, "1");
			$comparisons[1] = array(FALSE, "".((isset($_SESSION['Access112']))?$_SESSION['Access112']:"")  ."", 2, "1");
			break;
		case "User_and_Editor":
			$comparisons[0] = array(FALSE, "".((isset($_SESSION['Active']))?$_SESSION['Active']:"")  ."", 2, "1");
			$comparisons[1] = array(TRUE, "".((isset($_SESSION['Access112']))?$_SESSION['Access112']:"")  ."", 20, "User_and_Editor");
			break;
		case "User_and_Editor_and_InsertMessage":
			$comparisons[0] = array(FALSE, "".((isset($_SESSION['Active']))?$_SESSION['Active']:"")  ."", 2, "1");
			$comparisons[1] = array(TRUE, "".((isset($_SESSION['Access112']))?$_SESSION['Access112']:"")  ."", 20, "User_and_Editor_and_InsertMessage");
			break;
	}
	return $comparisons;	
}


function WA_Auth_GetGroup($groupName){
	$group = Array();
	
														switch ($groupName){
		case "Editor_and_InsertMessage":
			$group = array("2","3");
			break;
		case "User_and_Editor":
			$group = array("1","2");
			break;
		case "User_and_Editor_and_InsertMessage":
			$group = array("1","2","3");
			break;
	}
	return $group;
}

?>
