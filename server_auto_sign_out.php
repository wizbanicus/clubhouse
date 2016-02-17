<?php
include 'configPDO.php';
include 'shared_functions.php';
/* Get the venues where the time is now between 11:55pm - midnight.
Then for each one, sign everyone out of that venue!
*/

get_midnight_venues($dbh);

function get_midnight_venues($dbh) {
// comparing now in each timezone but only for our venues
	$STM = $dbh->prepare("SELECT venue_id, timezone FROM venues");
	$STM->execute();
	$STMrecords = $STM->fetchAll();
	$STM = null;
	$timeNow = date('H:i');
	$dailyCutOff = strtotime('23:54');
	if ($STMrecords) {
			foreach($STMrecords as $row) {
			$venueTimeNowString = new_date_string($timeNow, $row['timezone'], 'H:i', 'H:i');
			$venueTimeNow = strtotime($venueTimeNowString);
			if ( $venueTimeNow > $dailyCutOff ) {
				auto_sign_out_by_venue($dbh, $row['venue_id']);
			}
		}
	} 
}

function auto_sign_out_by_venue($dbh, $venueId, $autoSignedOut=true) {
	// cerate attendance record then delete attendance
	$STM = $dbh->prepare("INSERT INTO attendance_records (member_id, sign_in_time, sign_out_time, venue_id, organisation_id, auto_signed_out )
	 SELECT member_id, sign_in_time, UTC_TIMESTAMP(), venue_id, organisation_id, :auto_signed_out FROM attendance WHERE venue_id = :venue_id");
	// bind parameters, Named parameters alaways start with colon(:)                      
   $STM->bindParam(':venue_id', $venueId);
   $STM->bindParam(':auto_signed_out', $autoSignedOut);
	$STM->execute();
	$STM = null;
	$STM = $dbh->prepare("DELETE FROM attendance WHERE venue_id = :venue_id");
	// bind parameters, Named parameters alaways start with colon(:)                      
   $STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STM = null;
}

?>
