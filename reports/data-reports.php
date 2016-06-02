<?php
/*	simply because data.php is getting pretty big and this file should only
*	be required by reports.		
*/

// general-attendance

function general_attendance_by_venue($dbh, $reportStartDate, $reportEndDate, $reportVenueId){
	$STM = $dbh->prepare
		("SELECT COUNT(*) as sign_ins, count(DISTINCT date(sign_in_time)) as days_open,
			count(DISTINCT member_id) as individuals FROM attendance_records WHERE sign_in_time > :start_date
		AND sign_in_time < :end_date AND venue_id = :venue_id");
		error_log("start age: " . $reportStartDate . " end age: " . $reportEndDate); 
   $STM->bindParam(':venue_id', $reportVenueId);
	$STM->bindParam(':start_date', $reportStartDate);
	$STM->bindParam(':end_date', $reportEndDate);
	$STM->execute();
	$totalSignIns = $STM->fetchAll();
	if (isset($totalSignIns) && $totalSignIns) {return $totalSignIns;}
	else {return false;}
	$STM = null;
}

function new_members_by_venue($dbh, $reportStartDate, $reportEndDate, $reportVenueId) {
	$STM = $dbh->prepare
		("SELECT count(DISTINCT members.member_id)FROM `members` INNER JOIN attendance_records ON 
		attendance_records.member_id = members.member_id
		WHERE members.first_visit > :start_date
		AND members.first_visit < :end_date
		AND attendance_records.venue_id = :venue_id");
	$STM->bindParam(':venue_id', $reportVenueId);
	$STM->bindParam(':start_date', $reportStartDate);
	$STM->bindParam(':end_date', $reportEndDate);
	$STM->execute();
	$newMembers = $STM->fetchColumn();
	if (isset($newMembers) && $newMembers) {return $newMembers;}
	else {return 0;}
	$STM = null;	
}

function get_member_info($dbh, $startAge, $endAge, $asOfDate){
error_log("start age: " . $startAge . " end age: " . $endAge . " as of: " . $asOfDate);  
$STM = $dbh->prepare
		("SELECT count(DISTINCT members.member_id)FROM `members` 
		WHERE members.first_visit < :as_of_date
		AND members.birthdate > DATE_SUB(:as_of_date, INTERVAL :end_age YEAR)
		AND members.birthdate < DATE_SUB(:as_of_date, INTERVAL :start_age YEAR)");
	$STM->bindParam(':as_of_date', $asOfDate);
	$STM->bindParam(':start_age', $startAge);
	$STM->bindParam(':end_age', $endAge);
	$STM->execute();
	$members = $STM->fetchColumn();
	if (isset($members) && $members) {return $members;}
	else {return 0;}
	$STM = null;
}

?>
