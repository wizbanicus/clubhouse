<?php
include 'authentication.php';
if (isset($_COOKIE['message']) && $_COOKIE['message']) {
 	$message = $_COOKIE['message'];
 	setcookie('message', false);
}
if ($_SESSION['role'] == 'staff' && $_SESSION['mode'] == 'reports') {
	$m = date('n');
	$lastMonthStart = date('d/m/Y',mktime(1,1,1,$m-1,1,date('Y')));
	$lastMonthEnd = date('d/m/Y',mktime(1,1,1,$m,0,date('Y'))); 
	$venues = get_venues($dbh, $_SESSION['organisation_id']);
// report types are listed here - for each report type there must be a 
// corresponding view file in reports folder eg. "reports/general-attendance.php"
	$reportTypes = array ( "general-attendance", "other" );
// now if we have posted to do_reports, we'll have some cookies to make reports with
	if (isset($_COOKIE['reportStartDate']) && $_COOKIE['reportStartDate']) {
		$reportStartDate = $_COOKIE['reportStartDate'];
		setcookie('reportStartDate', false);
	} if (isset($_COOKIE['reportEndDate']) && $_COOKIE['reportEndDate']) {
		$reportEndDate = $_COOKIE['reportEndDate'];
		setcookie('reportEndDate', false);
	}	if (isset($_COOKIE['reportVenue']) && $_COOKIE['reportVenue']) {
		$reportVenue = $_COOKIE['reportVenue'];
		setcookie('reportVenue', false);
	}	if (isset($_COOKIE['reportType']) && $_COOKIE['reportType']) {
		$reportType = $_COOKIE['reportType'];
		setcookie('reportType', false);
	} 
// ensuring our $reportVenues is always an array so that we can foreach
// note view_reports_panel.php then uses this to iterate venues
	if ($reportVenue == 'all'){
		$reportVenues = $venues;
	} else {
		$reportVenues[0]['venue_id'] = $reportVenue;
		$reportVenues[0]['name'] = get_venue_by_id($dbh, $reportVenue);
		$reportVenues[0]['timezone'] = get_venue_timezone($dbh, $reportVenue);
	}
}
?>
