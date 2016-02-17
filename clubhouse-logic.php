<?php
// clubhouse logic

if (isset($_COOKIE['message']) && $_COOKIE['message']) {
	$message = $_COOKIE['message'];
	setcookie('message', false);
}
if (isset($_COOKIE['signUpPanel']) && $_COOKIE['signUpPanel']) {
	$signUpPanel = $_COOKIE['signUpPanel'];
	setcookie('signUpPanel', false);
}
// gather the members if the mode is signin
if (isset($_SESSION) && $_SESSION['mode'] == 'signin') { 
	$members = get_members($dbh, $_SESSION['organisation_id']);
	$signedInMembers = get_signed_in_members($dbh, $_SESSION['venue_id']);
	$organisationName = get_organisation_by_id($dbh, $_SESSION['organisation_id']);
	$venueName = get_venue_by_id($dbh, $_SESSION['venue_id']);
	$venueTimezone = get_venue_timezone($dbh, $_SESSION['venue_id']);
} else {
	$message = "you'll need to sign in first ";
	setcookie('message', $message);
	header("Location: admin.php");
}
?>
