<?php
include 'configPDO.php';
include 'db.php';
include 'data.php';
include 'authentication.php';
include 'shared_functions.php';
// sign-in-out
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['sign'] == 'in') {	
		if (isset($_POST['member_name']) && $_POST['member_name']) {
			$name = $_POST['member_name'];
			$name = test_input($name);
			$memberId = get_member_id_by_name($dbh, $name, $_SESSION['organisation_id']);
			if ($memberId) {
				if (already_signed_in($dbh, $memberId)){
					sign_out($dbh, $memberId);
					$message = "${name} signed out";
					header("Location: clubhouse.php");
				} else {
					sign_in($dbh, $memberId, $_SESSION['venue_id'], $_SESSION['organisation_id']);
					header("Location: clubhouse.php");
				}
			} else {
				$cardNo = $_POST['member_name'];
				$memberId = get_member_id_by_card_no($dbh, $cardNo, $_SESSION['organisation_id']);
				if ($memberId) {
					if (already_signed_in($dbh, $memberId)){
						$message = "${cardNo} signed out";
						sign_out($dbh, $memberId);
						header("Location: clubhouse.php");
					} else {
						sign_in($dbh, $memberId, $_SESSION['venue_id'], $_SESSION['organisation_id']);
						header("Location: clubhouse.php");
					}
				} 
				 else {
					$message  = "user not found";
					$signUpPanel = true; 
					setcookie('signUpPanel', $signUpPanel);
					header("Location: clubhouse.php");
				}
			}
		}
		else {
		$message = "enter member name or card number";
		header("Location: clubhouse.php");
		}
	}
}
if (isset($message) && $message) {
	setcookie('message', $message);
}
?>
