<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="row">
			<div class="navbar-header col-xs-9">
				<span class="navbar-brand navbar-ch" style="color:white;">
				<?php if (isset($organisationName) && isset($venueName)) { 
					echo '<span class="hidden-xs">' . $organisationName . ' - </span>' . $venueName;} ?>
				</span>
			</div>
			<div id="navbar" >
				<span class="navbar-brand navbar-ch pull-right" style="color:white;">
				<?php if ($signedInMembers) { echo count($signedInMembers); } ?> 
				</span>
			</div>
		</div>
	</div>
</nav>
