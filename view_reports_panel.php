<!-- view reports panel -->
<?php include 'shared_functions.php'; ?>
<div class="panel panel-dark">
 <div class="panel-body panel-body-321 text-lightgray">
	<?php foreach ($reportVenues as $currentVenue) 
		{ 
			$currentStartDate = new_date_string($reportStartDate, 'UTC' , $arriving_format = 'd/m/Y H:i:s', $desired_format='Y-m-d H:i:s', $currentVenue['timezone']);
			$currentEndDate = new_date_string($reportEndDate, 'UTC', $arriving_format = 'd/m/Y H:i:s', $desired_format='Y-m-d H:i:s', $currentVenue['timezone']);
			include 'reports/' . $reportType . '.php'; 
		}
	?>
 </div>
</div>  

