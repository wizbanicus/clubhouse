<form class="form-inline" method="post" action="do_administer_users.php" autocomplete="off">
	<h2>Users</h2>
	<div>
		<input autofocus="autofocus" class="form-control awesomplete" name="user_name" placeholder="user name"
            data-autofirst="true" <?php if(isset($userFull)) {echo 'value="' . $userFull['user_name'] . '"';} ?>
            data-list="
            <?php if ($users) {
              foreach ($users as $user) {
                echo $user['user_name'] . ',';
              }
            }?>
            " 
        />
		<button tabindex="-1" class="form-control btn btn-success" type="submit" name="do_user" value="find">find</button>
	</div>
		<input class="form-control" type="password" name="password" placeholder="password" />
		<input class="form-control" type="email" name="email" placeholder="email" 
		<?php if(isset($userFull)) {echo 'value="' . $userFull['email'] . '"';} ?> />
		<input class="form-control awesomplete dropdown-input" type="text" name="organisation" placeholder="organisation" 
		<?php if(isset($userFull)) {echo 'value="' . $userFull['organisation_name'] . '"';} ?> 
			data-autofirst="true"
			data-list="<?php if ($organisations) {
              foreach ($organisations as $organisation) {
                echo (trim($organisation['organisation_name'])) . ',';
              }
            }?>
            " 
		/><button class="dropdown-btn" type="button"><span class="caret"></span></button>
			<label for="role">role</label>
			<select class="form-control" name="role">
				<option value="none">choose</option>
				<?php foreach ($roles as $role) {
					echo '<option ' ;
					if (isset($userFull) && $userFull['role_id'] == $role['role_id']) { echo "selected ";}
					echo 'value="' . $role['role_id'] . '">' . $role['role_name'] . '</option>';
				}
				?>
			</select>
		<div class="pull-right">
			<button class="form-control btn btn-success" type="submit" name="do_user" value="add"> add </button>
			<button class="form-control btn btn-info" type="submit" name="do_user" value="save"> save </button>
			<button class="form-control btn btn-danger" type="submit" name="do_user" value="remove"> remove </button>
		</div>
</form>
