<?php
$memberInfo = get_all_member_info($dbh, $reportStartAge, $reportEndAge, $currentReportAsOfDate, $_SESSION['organisation_id']);
foreach ($memberInfo as $member) {
echo '<div hidden>' . $member['birthdate'] . '</div>';
}
?>

<div class="col-lg-12">
<h3>Member Info
	<small>  (  
		<?php echo $reportStartAge ; ?> 
		  to
		<?php echo $reportEndAge ; ?> )  
		Years old 
	</small> 
</h3> 
</div>
<div>
<ul>
	<li><strong>Total members: </strong><div id="total_members"><?php echo count($memberInfo); ?></div></li>

</ul>
</div>

