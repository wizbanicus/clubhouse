<?php
include 'authentication.php';
if (isset($_COOKIE['message']) && $_COOKIE['message']) {
 	$message = $_COOKIE['message'];
 	setcookie('message', false);
}
if ($_SESSION['role'] == 'staff' && $_SESSION['mode'] == 'edit_member') {
	$members = get_members($dbh, $_SESSION['organisation_id']);
	$schools = get_things($dbh, $_SESSION['organisation_id'], 'schools');
	$ethnicities = get_things($dbh, $_SESSION['organisation_id'], 'ethnicities');
	$countries = get_things($dbh, $_SESSION['organisation_id'], 'countries');
	$states = get_things($dbh, $_SESSION['organisation_id'], 'states');
	$cities = get_things($dbh, $_SESSION['organisation_id'], 'cities');
	$suburbs = get_things($dbh, $_SESSION['organisation_id'], 'suburbs');
	$member_types = get_things($dbh, $_SESSION['organisation_id'], 'member_types');
	// find the member either by the name or id number - member_name, comes first as it means
	// we are changing which member to look at.
	if (isset($_POST['member_name']) && $_POST['member_name']) {
		$name = $_POST['member_name'];
		$name = test_input($name);
		$memberId = get_member_id_by_name($dbh, $name, $_SESSION['organisation_id']);
		// if we still haven't found it, try by card number.
		if (!$memberId) {
			$cardNo = $_POST['member_name'];
			$memberId = get_member_id_by_card_no($dbh, $cardNo, $_SESSION['organisation_id']);
		} 
	} 
	// if there is already an ID present from do_edit_member.php (ie. we are editing a memebr we already found)
	else if ( isset($_COOKIE['post_member_id']) && $_COOKIE['post_member_id'] ){
		$memberId = $_COOKIE['post_member_id'];
		setcookie('post_member_id', false);
	} else if (isset($_COOKIE['post_name']) && $_COOKIE['post_name']) {
		$name = $_COOKIE['post_name'];
		setcookie('post_name', false);
		$memberId = get_member_id_by_name($dbh, $name, $_SESSION['organisation_id']);
		if (!$memberId) {
			$cardNo = $name;
			$memberId = get_member_id_by_card_no($dbh, $cardNo, $_SESSION['organisation_id']);
		}
	}

	// if we still haven't found it display the error
	if ( isset($memberId) && $memberId) {
		$memberFull = get_member_full($dbh, $memberId);
	} else {
		$message  = "User not found. Perhaps you would like to add a new member?";
		setcookie('message', $message);
	}
}
?>
