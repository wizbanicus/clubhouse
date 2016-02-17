<?php
// check session situation - delete the session cookie, but also delete the session if it exists.
session_start();
if (isset($_SESSION['mode']) && $_SESSION['mode'] == "signin") {
	session_unset();
	session_destroy();
}
if (isset($_SESSION['user']) && $_SESSION['role'] == "staff") {
	$members = get_members($dbh, $_SESSION['organisation_id']);
	$venues = get_venues($dbh, $_SESSION['organisation_id']);
//	$signedInMembers = get_signed_in_members($dbh, $_SESSION['venue_id']);
	$defaultVenue = get_users_default_venue($dbh, $_SESSION['user_id']);
	$timezones = timezone_identifiers_list();
}
if (isset($_SESSION['user']) && $_SESSION['role'] == "admin") {
	$users = get_users($dbh);
	$organisations = get_organisations($dbh);
	$roles = get_roles($dbh);
	// note only if role is admin - just to pass on user
	if (isset($_COOKIE['user_id']) && $_COOKIE['user_id']) {
		$userId = $_COOKIE['user_id'];
		$userFull = get_user_full($dbh, $userId);
		setcookie('user_id', false);
	}
}
if (isset($_COOKIE['message']) && $_COOKIE['message']) {
	$message = $_COOKIE['message'];
	setcookie('message', false);
}
?>
