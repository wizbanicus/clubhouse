<div class="container">
	<div class="row">
		<div class="pull-left col-lg-6">
			<p>Thanks to <a href="http://www.proaxiom.co.nz">proaxiom</a> for all their support!</p>
		</div>
		<div class="pull-right col-lg-6">
			<p>clubhouse version: 0.1</p>
		</div>
	</div>
</div>
<input name="date_format" value="
<?php if ($_SESSION['date_format']) { echo $_SESSION['date_format']; }else { echo 'd/m/Y'; } ?> " type="hidden" id="date_format" >
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/awesomplete.js"></script>
    <script type="text/javascript" src="js/moment.js"></script>
    <script type="text/javascript" src="js/daterangepicker.js"></script>
    <script src="js/clubhouse.js"></script>
