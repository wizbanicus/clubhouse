<?php
// do edit member
include 'configPDO.php';
include 'data.php';
include 'shared_functions.php';
include 'authentication.php';
switch ($_POST['report_button']) {
	case 'cancel':
		header("Location: admin.php");
		break;
	case 'go':
		if (isset($_POST['daterange']) && $_POST['daterange']
			&& isset($_POST['venue']) && $_POST['venue']
			&& isset($_POST['reporttype']) && $_POST['reporttype']) {
			$dates = explode(" - ",$_POST['daterange']);
				if (isset($dates) && $dates) {
		 			$startDate = $dates[0];
					$endDate = $dates[1];
					if (validate_date($startDate) && validate_date($endDate)) {
						$startDate .= ' 00:00:01';
						$endDate .= ' 23:59:59';
					} else { 
						$message = "date error, try again!";
						setcookie('message', $message);
					}
					setcookie('reportStartDate', $startDate);
					setcookie('reportEndDate', $endDate);
					setcookie('reportVenue', $_POST['venue']);
					setcookie('reportType', $_POST['reporttype']);
				} 
			header("Location: reports.php");
		} else {
			$message = "parameters: daterange, venue and report type are needed!";
			setcookie('message', $message);
			header("Location: reports.php");
		}
		break;
}
?>
