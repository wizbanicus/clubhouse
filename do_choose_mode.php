<?php
include 'configPDO.php';
include 'data.php';
include 'shared_functions.php';

session_start();
	if ($_POST['do'] == 'edit_member') {
		$_SESSION['mode'] = "edit_member";
		if (isset($_POST['member_name']) && $_POST['member_name']) {
			$name = $_POST['member_name'];
			$name = test_input($name);
			setcookie('post_name', $name);
		} 
		header("Location: edit_member.php");
	}
	if ($_POST['do'] == 'accept_signins') {
		if (isset($_POST['venue']) && $_POST['venue'] 
		&& isset($_POST['timezone']) && $_POST['timezone'] 
		&& in_array($_POST['timezone'], timezone_identifiers_list())) {
			$_SESSION['mode'] = "signin";
			$venueName = test_input($_POST['venue']);
			$venueId = get_venue_id_by_name($dbh, $venueName, $_SESSION['organisation_id']);
			if ($venueId) {
				$_SESSION['venue_id'] = $venueId;
				set_user_venue($dbh, $venueId, $_SESSION['user_id']);
				set_venue_timezone($dbh, $venueId, $_POST['timezone']);
			} else {
				add_venue($dbh, $venueName, $_SESSION['organisation_id']);
				$venueId = get_venue_id_by_name($dbh, $venueName, $_SESSION['organisation_id']);
				set_venue_timezone($dbh, $venueId, $_POST['timezone']);
				$_SESSION['venue_id'] = $venueId;
				set_user_venue($dbh, $venueId, $_SESSION['user_id']);
			} 
			show_venue($dbh, $venueId);
			purge_orphaned_attendance($dbh);
			header("location: clubhouse.php");
		} else {
			$message = "sorry, to sign in we'll need a venue and timezone!";
			setcookie('message', $message);
			header("Location: admin.php");
		}
	}
	if ($_POST['do'] == 'remove_venue') {
		if (isset($_POST['venue']) && $_POST['venue']) {
			$venueName = test_input($_POST['venue']);
			$venueId = get_venue_id_by_name($dbh, $venueName, $_SESSION['organisation_id']);
			if ($venueId) {
				$venueEmpty = is_venue_empty($dbh, $venueId);
				if ($venueEmpty) {
					hide_venue($dbh, $venueId);
					remove_default_venue($dbh, $venueId);
					$message = "removed venue " . $venueName;
					setcookie('message', $message);
					header("Location: admin.php");				
				} else {
					$message = "sorry we can't remove a venue while there are people signed in!";
					setcookie('message', $message);
					header("Location: admin.php");
				}
			} else {
				$message = "venue not found.";
				setcookie('message', $message);
				header("Location: admin.php");
			}
		}
	}
	if ($_POST['do'] == 'reports') {
		$_SESSION['mode'] = "reports";
		header("Location: reports.php");
	}
	if ($_POST['do'] == 'set_date_format') {
		$dateFormat = test_input($_POST['date_format']);
		$dateFormat = strtolower($dateFormat);
		set_date_format($dbh, $_SESSION['user_id'], $dateFormat);
		$_SESSION['date_format'] = $dateFormat;
		header("Location: admin.php");
	}
?>
