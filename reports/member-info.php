<?php 
$memberInfo = get_member_info($dbh, $reportStartAge, $reportEndAge, $currentReportAsOfDate);
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
	<li><strong>Total members: </strong><div id="total_members"><?php echo $memberInfo; ?></div></li>

</ul>
</div>
