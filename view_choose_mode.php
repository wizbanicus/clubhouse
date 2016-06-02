<form class="form-inline" action="do_choose_mode.php" method="post" autocomplete="off">
	<div class="row">
		<div class="col-lg-6">
			<h2>Do stuff</h2>
			<h3>Edit member</h3>
		  <input id="inout" class="<?php if($members) { echo 'awesomplete';} ?> form-control" 
		    <?php if ($members) {
			echo 'data-list="';
			foreach ($members as $member) {
				echo $member['full_name'] . ',';
		      	}
		      	echo '"';
		    }?>
		    name="member_name" placeholder="name or id number"
		    autofocus="autofocus" data-autofirst="true" onclick="button_submit()" onblur="button_button()" />
		    <button id="button" type="submit" onclick="button_submit()" class="form-control btn btn-success" name="do" value="edit_member" tabindex="-1">edit</button>
		    <br />
		    <h3>Accept signins</h3>
		    <input id="venue" type="text" class="form-control <?php if($venues) { echo 'awesomplete';} ?>" 
			    <?php if ($venues) {
			    	echo 'data-list="';
			      foreach ($venues as $venue) {
			        echo $venue['name'] . ',';
			      }
			      echo '"';
			    }?>
		    name="venue" placeholder="venue" data-autofirst="true" 
		    <?php if(isset($defaultVenue['venue']) && $defaultVenue['venue']) 
		    { echo ' value="' . $defaultVenue['venue'] . '" ';} ?>
		    onblur="set_timezone()">
		    <input id="timezone" type="text" class="form-control <?php if($timezones) { echo 'awesomplete';} ?>" 
		       <?php if ($timezones) {
		       	echo 'data-list="';
		         foreach ($timezones as $timezone) {
		           echo $timezone . ',';
		         }
		         echo '"';
		       }?>
		    name="timezone" placeholder="timezone" data-autofirst="true" 
		    <?php if(isset($defaultVenue['timezone']) && $defaultVenue['timezone']) 
		    { echo ' value="' . $defaultVenue['timezone'] . '" ';} ?>
		    />
		    <button type="submit" class="form-control btn btn-success" name="do" value="accept_signins">accept signins</button>
			<div>
				<button type="submit" class="btn btn-xs btn-danger" name="do" value="remove_venue">
					remove venue <span class="glyphicon glyphicon-remove"></span>
				</button>
			</div>
		    <h3>Reports</h3>
			<button type="submit" class="form-control btn btn-success" name="do" value="reports">reports</button>
		 </div>
		 <!-- commenting out for now
		 <div class="col-lg-6">
			 <h2>My Preferences</h2>
			 <h3>Date format</h3>
				<input id="date_format" class="awesomplete form-control dropdown-input" 
				  data-list="d/m/Y, m/d/Y, Y-m-d"
				  name="date_format" placeholder="set date format"
				  autofocus="autofocus" data-autofirst="true"
				  <?php if(isset($userDateFormat) && $userDateFormat){echo 'value="' . $userDateFormat . '"';} ?>
				  /><button class="dropdown-btn" type="button"><span class="caret"></span></button>
				  <button id="button" type="submit" onclick="button_submit()" class="form-control btn btn-info" name="do" value="set_date_format" tabindex="-1">set</button>
				  <br />
		 
		 </div>
		 -->
   </div>
</form>
<script type="text/javascript"> 
	var js_venues = [];
	var js_timezones = [];
	<?php 
	foreach ($venues as $venue) {
		echo "js_venues.push(\"${venue['name']}\");";
		echo "js_timezones.push(\"${venue['timezone']}\");";
	}
	?>
</script>
