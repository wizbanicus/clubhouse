        <div class="panel">
          	<div class="panel-body">
					<table class="view-signed-in">
						<tr class="column"><td>Member</td><td>Arrival Time</td><td>status</td></tr>
						<?php if ($signedInMembers) {  
							foreach ($signedInMembers as $signedInMember) {	
								echo "<tr><td>" . '<a href="#" onclick="name_out(' . "'" . addslashes($signedInMember['full_name']) 
								 . "'" . ')">' . "${signedInMember['full_name']}</a></td><td>"
								 . /* $venueTimezone */new_date_string($signedInMember['sign_in_time'],$venueTimezone) . 
								"</td>";
								if ($signedInMember['verified']) { echo '<td>
									<a tabindex="0" class="popup" role="button" data-toggle="popover" 
								data-trigger="focus" title="member confirmed" >
								<span class="glyphicon glyphicon-ok-sign"></span></a>
								</td></tr>'; }
								else { echo '<td>
									<a tabindex="0" class="popup" role="button" data-toggle="popover" 
								data-trigger="focus" title="member not confirmed" >
								<span class="glyphicon glyphicon-exclamation-sign"></span></a>
									</td></tr>'; }
							}
						}
						?>
					</table>
			</div>
      	</div>
