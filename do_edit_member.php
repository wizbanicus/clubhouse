<?php
// do edit member
include 'configPDO.php';
include 'data.php';
include 'shared_functions.php';
include 'authentication.php';
switch ($_POST['member_button']) {
	case 'save':
		if (isset($_POST['fname']) && $_POST['fname'] && isset($_POST['lname']) && $_POST['lname']
		&& isset($_POST['gender']) && $_POST['gender'] && isset($_POST['birthdate']) && $_POST['birthdate']) {
			$firstName = test_input($_POST['fname']);
			$lastName = test_input($_POST['lname']);
			$fullName = $firstName . ' ' . $lastName;
			$signUpGenderId = set_gender_id();
			$birthdate = $_POST['birthdate'];
			$organisationId = $_SESSION['organisation_id'];
			if (isset($_POST['member_id']) && $_POST['member_id']) {
				$memberId = $_POST['member_id'];
				update_member_from_post($dbh, $memberId, $firstName, $lastName, $fullName, $birthdate, $signUpGenderId);
				$name = $firstName . ' ' . $lastName;
				setcookie('post_name', $name);
				header("Location: edit_member.php");
			} else {
				// if there is no member id we must be dealing with a new member,
				// so well create them, then update.
				add_unconfirmed_member($dbh, $firstName, $lastName, $signUpGenderId, $birthdate, $organisationId);
				$memberId = get_member_id_by_name($dbh, $fullName, $organisationId);
				// if successful, there will be a member id
				if ($memberId) {
					update_member_from_post($dbh, $memberId);
					$name = $firstName . ' ' . $lastName;
					setcookie('post_name', $name);
					// set the cookie incase there are porblems and we wanna come back to this user in edit_member.php
					setcookie('post_member_id', $memberId);
					header("Location: edit_member.php");
				}
			} } else {
			if (isset($_POST['member_id']) && $_POST['member_id']) {
				$memberId = $_POST['member_id'];
				update_member_from_post($dbh, $memberId, $firstName, $lastName, $fullName, $birthdate, $signUpGenderId);
				$name = $firstName . ' ' . $lastName;
				setcookie('post_name', $name);
				header("Location: edit_member.php");
			}
			$message  = "minimum of first name, last name gender and dob required";
			setcookie('message', $message);	
			header("Location: edit_member.php");
			}	
		break;
	case 'cancel':
		setcookie('message', false);
		header("Location: admin.php");
		break;
	case 'delete':
		$message  = "still working on it!";
		setcookie('message', $message);
		header("Location: edit_member.php");
		break;
	default:
		# code...
		break;
}

function set_gender_id(){
	if ($_POST['gender'] == 'other' || $_POST['gender'] == 'male' || $_POST['gender'] == 'female') {
		$signUpGender = $_POST['gender'];
		switch ($signUpGender) {
		    case 'other':
		        $signUpGenderId = '0';
		        break;
		    case 'male':
		        $signUpGenderId = '1';
		        break;
		    case 'female':
		        $signUpGenderId = '2';
		        break;
		}
		return $signUpGenderId;
	}
}

function update_member_from_post($dbh, $memberId, $firstName, $lastName, $fullName, $birthdate, $signUpGenderId){
	// although data is grabbed from post, we must have the minimum info to proceed!
	if ( $firstName){
	$attribute = 'fname';
	update_member($dbh, $memberId, $attribute, $firstName);
	}
	if ( $lastName ){
	$attribute = 'lname';
	update_member($dbh, $memberId, $attribute, $lastName);
	}
	if ( $fullName){
	$attribute = 'full_name';
	update_member($dbh, $memberId, $attribute, $fullName);
	}
	if ( isset($birthdate)){
	    update_member_birthdate($dbh, $memberId, $birthdate);
	}
	if (isset($signUpGenderId)) {
	$attribute = 'gender_id';
	update_member($dbh, $memberId, $attribute, $signUpGenderId);
	}
// once the essentials are done - add the rest
	if ( isset($_POST['card_no'])){
	$attribute = 'card_no';
	update_member($dbh, $memberId, $attribute, $_POST['card_no']);
	}
	if ( isset($_POST['comments'])){
	$attribute = 'comments';
	update_member($dbh, $memberId, $attribute, $_POST['comments']);
	}
	if ( isset($_POST['zip_code'])){
	$attribute = 'zip_code';
	update_member($dbh, $memberId, $attribute, $_POST['zip_code']);
	}
	if ( isset($_POST['phone1'])){
	$attribute = 'phone1';
	update_member($dbh, $memberId, $attribute, $_POST['phone1']);
	}
	if ( isset($_POST['phone2'])){
	$attribute = 'phone2';
	update_member($dbh, $memberId, $attribute, $_POST['phone2']);
	}
	if ( isset($_POST['phone3'])){
	$attribute = 'phone3';
	update_member($dbh, $memberId, $attribute, $_POST['phone3']);
	}
	if ( isset($_POST['guardian_fname'])){
	$attribute = 'guardian_fname';
	update_member($dbh, $memberId, $attribute, $_POST['guardian_fname']);
	}
	if ( isset($_POST['guardian_lname'])){
	$attribute = 'guardian_lname';
	update_member($dbh, $memberId, $attribute, $_POST['guardian_lname']);
	}
	if ( isset($_POST['guardian_relationship'])){
	$attribute = 'guardian_relationship';
	update_member($dbh, $memberId, $attribute, $_POST['guardian_relationship']);
	}
	if ( isset($_POST['guardian_phone1'])){
	$attribute = 'guardian_phone1';
	update_member($dbh, $memberId, $attribute, $_POST['guardian_phone1']);
	}
	if ( isset($_POST['guardian_phone2'])){
	$attribute = 'guardian_phone2';
	update_member($dbh, $memberId, $attribute, $_POST['guardian_phone2']);
	}
	if ( isset($_POST['emergency_fname'])){
	$attribute = 'emergency_fname';
	update_member($dbh, $memberId, $attribute, $_POST['emergency_fname']);
	}
	if ( isset($_POST['emergency_lname'])){
	$attribute = 'emergency_lname';
	update_member($dbh, $memberId, $attribute, $_POST['emergency_lname']);
	}
	if ( isset($_POST['emergency_relationship'])){
	$attribute = 'emergency_relationship';
	update_member($dbh, $memberId, $attribute, $_POST['emergency_relationship']);
	}
	if ( isset($_POST['emergency_phone1'])){
	$attribute = 'emergency_phone1';
	update_member($dbh, $memberId, $attribute, $_POST['emergency_phone1']);
	}
	if ( isset($_POST['emergency_phone2'])){
	$attribute = 'emergency_phone2';
	update_member($dbh, $memberId, $attribute, $_POST['emergency_phone2']);
	}
	if ( isset($_POST['school'])){
	$attribute = 'school_id';
	$things = 'schools';
	$name = test_input($_POST['school']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['ethnicity'])){
	$attribute = 'ethnicity_id';
	$things = 'ethnicities';
	$name = test_input($_POST['ethnicity']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['member_type_name'])){
	$attribute = 'member_type_id';
	$things = 'member_types';
	$name = test_input($_POST['member_type_name']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['state'])){
	$attribute = 'state_id';
	$things = 'states';
	$name = test_input($_POST['state']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['city'])){
	$attribute = 'city_id';
	$things = 'cities';
	$name = test_input($_POST['city']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['suburb'])){
	$attribute = 'suburb_id';
	$things = 'suburbs';
	$name = test_input($_POST['suburb']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['country'])){
	$attribute = 'country_id';
	$things = 'countries';
	$name = test_input($_POST['country']);
	member_things($dbh, $attribute, $things, $name, $memberId, $_SESSION['organisation_id']);
	}
	if ( isset($_POST['verified'])){
	$verified = "1";
	} else {
	$verified = "0";
	}
	$attribute = 'verified';
	update_member($dbh, $memberId, $attribute, $verified);

	if ( isset($_POST['street_address'])){
	$attribute = 'street_address';
	update_member($dbh, $memberId, $attribute, $_POST['street_address']);
	}
}

?>
