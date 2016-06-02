<?php
include 'configPDO.php';
include 'data.php';
//include 'shared_functions.php';
include 'reports/data-reports.php';
include 'reports-logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
<?php include 'navbar.php'; ?>
	<div class="bg">
		<div class="row">
			<div class="panel">
				<div class="panel-body panel-body-321 meths">
					<form class="form-inline" action="do_reports.php" method="post" autocomplete="off">
					<label class="control-label" for="reporttype">report type</label>
						<select class="form-control" name="reporttype" id="reportType">
							<?php if (isset($reportTypes) && $reportTypes) {
								foreach($reportTypes as $typeOfReport) {
									echo '<option value="' . $typeOfReport . '" onclick="updateInputs()" >' . $typeOfReport
									. '</option>';
								}
							}?>
						</select>
						<label class="control-label ch-rt-ga" for="daterange">date range</label>
						<input class="form-control ch-rt-ga" type="text" name="daterange" 
							value="<?php echo $lastMonthStart; ?> - <?php echo $lastMonthEnd; ?>" />
						<label class="control-label" for="as_of_date">as of date</label>
						<input class="form-control ch-rt-mi" type="text" name="as_of_date" />
						<label class="control-label ch-rt-mi" for="start_age">start age</label>
						<input class="form-control ch-rt-mi" type="text" name="start_age" />
						<label class="control-label ch-rt-mi" for="end_age">end age</label>
						<input class="form-control ch-rt-mi" type="text" name="end_age" />
						<label class="control-label ch-rt-ga" for="venue">venue</label>
						<select class="form-control ch-rt-ga" name="venue">
							<option value="all" selected>all</option>
							<?php if (isset($venues) && $venues) {
								foreach($venues as $venue) {
									echo '<option value="' . $venue['venue_id'] . '">' . $venue['name']
									. '</option>';
								}
							}?>
						</select>
						
						<button class="btn btn-success" type="submit" name="report_button" value="go">go!</button>
						<button class="btn btn-warning" type="submit" name="report_button" value="cancel">done</button>
					</form>
				</div>
			</div>
		</div>
		<?php // reportTypes defined in reports-logic correspond to files 'report_type.php' ?>
		<?php if (isset($reportType) && $reportType) { include 'view_reports_panel.php'; } ?>
	</div>
	<?php if (isset($message) && $message) { include 'view_message.php'; } ?>
	<?php include 'view_footer.php' ?>    
	<script type="text/javascript" src="js/reports.js"></script>          
</body>
</html>
