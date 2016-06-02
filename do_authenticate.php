<?php
include 'configPDO.php';
include 'db.php';
include 'data.php';
include 'shared_functions.php';
include 'clubhouse_updates.php';
session_unset();
session_destroy();
// server should keep session data for AT LEAST 5 hours
ini_set('session.gc_maxlifetime', 18000);
// each client should remember their session id for EXACTLY 5 hours
session_set_cookie_params(18000);
session_start();
// hard coded admin user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username'] == 'admin' && $_POST['password'] == 'tppanoway!') {
	$_SESSION['user'] = "admin";
	$_SESSION['role'] = "admin";
} if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['username'] && $_POST['password']) {
	$userName = test_input($_POST['username']);
	$loggedInUserId = log_in_user($dbh, $userName, $_POST['password']);
	if ($loggedInUserId) {
		$user = get_user_full($dbh, $loggedInUserId);
		$_SESSION['user'] = $user['user_name'];
		$_SESSION['role'] = $user['role_name'];
		$_SESSION['organisation_id'] = $user['organisation_id'];
		$_SESSION['user_id'] = $loggedInUserId;
		$_SESSION['date_format'] = get_date_format($dbh, $loggedInUserId);
		clubhouse_updates($dbh, $_SESSION['user_id']);
	}
}

if (!$_SESSION['user']){
	$message = "authentication error";
	setcookie('message', $message);
}
	header("Location: admin.php");
	
?>
