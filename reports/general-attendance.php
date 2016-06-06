<?php 
$generalAttendance = general_attendance_by_venue($dbh, $currentStartDate, $currentEndDate, $currentVenue['venue_id']);
$dailyAvg = round(($generalAttendance[0]['sign_ins'] / $generalAttendance[0]['days_open']),1);
$newMembers = new_members_by_venue($dbh, $currentStartDate, $currentEndDate, $currentVenue['venue_id']);
?>
<div class="col-lg-12">
<h3>General attendance - <?php echo $currentVenue['name']; ?>
	<small>  (  
		<?php echo new_date_string($reportStartDate, 'UTC', $GLOBALS['REPORT_ARRIVING_FMT'], $desired_format='Y-m-d') ; ?> 
		  to  
		<?php echo new_date_string($reportEndDate, 'UTC', $GLOBALS['REPORT_ARRIVING_FMT'], $desired_format='Y-m-d') ; ?> )   
	</small> 
</h3> 
</div>
<div>
<ul>
	<li><strong>Total sign-ins: </strong><?php echo $generalAttendance[0]['sign_ins']; ?></li>
	<li><strong>Total days open: </strong><?php echo $generalAttendance[0]['days_open']; ?></li>
	<li><strong>Daily average: </strong><?php echo $dailyAvg; ?></li>
	<li><strong>Individual members: </strong><?php echo $generalAttendance[0]['individuals']; ?></li>
	<li><strong>New members: </strong><?php echo $newMembers; ?></li>
</ul>
</div>
