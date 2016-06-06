<?php
include 'configPDO.php';
include 'data.php';
include 'authentication.php';
include 'shared_functions.php';
// sign-in-out
$signUpOk = true;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['sign'] == 'up') {
		if (isset($_POST['fname']) && $_POST['fname']) {
			$signUpFname = $_POST['fname'];
			$signUpFname = test_input($signUpFname);
		}	else {
			$fnameErr = " Error with first name. ";
			$message = $fnameErr;
			$signUpOk = false;
		}
		if (isset($_POST['lname']) && $_POST['lname']) {
			$signUpLname = $_POST['lname'];
			$signUpLname = test_input($signUpLname);
		}	
		else {
			$lnameErr = " Error with last name. ";
			$message .= $fnameErr;
			$signUpOk = false;
		}
		if (isset($_POST['birthdate']) && $_POST['birthdate'] && validate_date($_POST['birthdate'])) {
			$signUpBirthdate = $_POST['birthdate'];
		}
		else { 
			$birthdateErr = " Error with birthdate. ";
			$birthdateErr .= "posted: " . $_POST['birthdate'] . " ... validated : " . validate_date($_POST['birthdate']);
			$message .= $birthdateErr;
			$signUpOk = false;
		}
		if (isset($_POST['gender']) && $_POST['gender']) {
			if ($_POST['gender'] == 'other' || $_POST['gender'] == 'male' || $_POST['gender'] == 'female') {
				$signUpGender = $_POST['gender'];
				switch ($signUpGender) {
				    case 'other':
				        $signUpGenderId = 0;
				        break;
				    case 'male':
				        $signUpGenderId = 1;
				        break;
				    case 'female':
				        $signUpGenderId = 2;
				        break;
				}
			}
			else {
				$genderErr = " Error with gender. ";
				$message .= $genderErr;
				$signUpOk = false;
			}
		}
		// if there are no errors, go ahead and signup
		if ( $signUpOk ) {
			if (already_a_member($dbh, $signUpFname, $signUpLname, $_SESSION['organisation_id'])) {
				$message = "Looks like you are already a member";
				$signUpOk = false;
			} else {
				add_unconfirmed_member($dbh, $signUpFname, $signUpLname, $signUpGenderId, $signUpBirthdate, $_SESSION['organisation_id']);
				$message = "thanks";
				$name = $signUpFname . ' ' . $signUpLname;
				$name = test_input($name);
				$memberId = get_member_id_by_name($dbh, $name, $_SESSION['organisation_id']);
				sign_in($dbh, $memberId, $_SESSION['venue_id'], $_SESSION['organisation_id']);
			}
		} else {
			$signUpPanel = true; 
			setcookie('signUpPanel', $signUpPanel);
		}
		if (isset($message) && $message) {
		setcookie('message', $message);
		}
		header("Location: clubhouse.php");
	}
}

/* delete once tested - now in shared_functions.php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = ucwords(strtolower($data));
  return $data;
}

function validate_date($date, $format = 'd/m/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
*/
?>
