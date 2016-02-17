<?php
include 'configPDO.php';
include 'data.php';
include 'shared_functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['user_name']) {
		$userName = test_input($_POST['user_name']);
		$userId = get_user_id_by_name($dbh, $userName);
	}
	if ($_POST['organisation']) {
		$organisationName = test_input($_POST['organisation']);
		$organisationId = get_organisation_id_by_name($dbh, $organisationName);
	}
	switch ($_POST['do_user']) {
		case 'find':
			if ($userId) {
				setcookie('user_id', $userId);
				header("Location: admin.php");
			} else {
				$message = "user not found" . $userId;
				setcookie('message', $message);
			}
			break;
		case 'add':
			if ($userId) {
				$message = "user already exists";
				setcookie('message', $message);
			} else {
				if ($_POST['user_name'] && $_POST['password'] && isset($_POST['role']) && $_POST['organisation'] && $_POST['email']) {
					if (!$organisationId) {
						add_organisation($dbh, $organisationName);
						$organisationId = get_organisation_id_by_name($dbh, $organisationName);
					}
					add_user($dbh, $userName, $_POST['password'], $_POST['email'], $organisationId, $_POST['role']);
				} else {
					$message = "all fields are mandatory!"; 
					setcookie('message', $message);
				}
			} 
			break;
		case 'save':
			if($userId) {
				if($_POST['password']) {
					update_user_password($dbh, $userId, $_POST['password']);
				}
				if (isset($_POST['role']) && $_POST['organisation'] && $_POST['email']) {
					if (!$organisationId) {
						add_organisation($dbh, $organisationName);
						$organisationId = get_organisation_id_by_name($dbh, $organisationName);
					}
					update_user($dbh, $userId, $_POST['email'], $organisationId, $_POST['role']);
				} else {
					$message = "all fields are mandatory!" . $_POST['role'] . $_POST['organisation'] . $POST['email'];
					setcookie('message', $message);
				}
			} else {
				$message = "User not found, try add";
				setcookie('message', $message);
			}
			break;
		case 'remove':
			if($userId) {
				remove_user($dbh, $userId);
			}
			break;
		default:
			# code...
			break;
	}
}
// prolly a much better way to do this there is
hide_orphaned_organisations($dbh);
show_active_organisations($dbh);
header("Location: admin.php");
?>