<?php
// MEMBERS
function get_members($dbh, $organisationId) {
	// Prepare query for showing requested results.
	$STM = $dbh->prepare("SELECT `member_id`, `full_name` FROM members WHERE organisation_id = :organisation_id");
    $STM->bindParam(':organisation_id', $organisationId);
	// For Executing prepared statement we will use below function
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$members = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $members[$count] = array( 'member_id' => $row['member_id'], 'full_name' => $row['full_name']);
	        $count = $count + 1;
	    }
	} 
	return $members;
}

function get_member_full($dbh, $memberId) {
	$STM = $dbh->prepare("SELECT member_id, fname, lname, email, gender, card_no, birthdate, first_visit,
		comments, street_address, suburb, city, state, country, zip_code, phone1, phone2, phone3,
		guardian_fname, guardian_lname, guardian_relationship, guardian_phone1, guardian_phone2,
		emergency_fname, emergency_lname, emergency_relationship, emergency_phone1, emergency_phone2,
		school, ethnicity, member_type_name, verified, organisation
	 FROM view_members WHERE member_id = :member_id");
    $STM->bindParam(':member_id', $memberId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0];}
	else {return false;}
	$STM = null;
}

function sign_in($dbh, $memberId, $venueId, $organisationId) {
	$STM = $dbh->prepare("INSERT INTO attendance (member_id, sign_in_time, venue_id,
		organisation_id ) VALUES ( :member_id, UTC_TIMESTAMP(), :venue_id, :organisation_id)");
	// bind parameters, Named parameters alaways start with colon(:)                      
    $STM->bindParam(':member_id', $memberId);
    $STM->bindParam(':venue_id', $venueId);
    $STM->bindParam(':organisation_id', $organisationId);
	$STM->execute();
	$STM = null;
}

function sign_out($dbh, $memberId, $autoSignedOut=false) {
	// cerate attendance record then delete attendance
	$STM = $dbh->prepare("INSERT INTO attendance_records (member_id, sign_in_time, sign_out_time, venue_id, organisation_id, auto_signed_out )
	 SELECT member_id, sign_in_time, UTC_TIMESTAMP(), venue_id, organisation_id, :auto_signed_out  
	 FROM attendance WHERE member_id = :member_id");
	// bind parameters, Named parameters alaways start with colon(:)                      
    $STM->bindParam(':member_id', $memberId);
    $STM->bindParam(':auto_signed_out', $autoSignedOut);
	$STM->execute();
	$STM = null;
	$STM = $dbh->prepare("DELETE FROM attendance WHERE member_id = :member_id");
	// bind parameters, Named parameters alaways start with colon(:)                      
    $STM->bindParam(':member_id', $memberId);
	$STM->execute();
	$STM = null;
}

function purge_orphaned_attendance($dbh) {
	$STM = $dbh->prepare("DELETE FROM attendance WHERE member_id NOT IN (SELECT member_id FROM members)");                   
    $STM->bindParam(':member_id', $memberId);
	$STM->execute();
	$STM = null;
}

function get_member_id_by_name($dbh, $name, $organisationId) {
	$STM = $dbh->prepare("SELECT member_id FROM members WHERE full_name = :name AND organisation_id = :organisation_id");
    $STM->bindParam(':organisation_id', $organisationId);
    $STM->bindParam(':name', $name);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['member_id'];}
	else {return false;}
	$STM = null;
}

function get_member_id_by_card_no($dbh, $cardNo, $organisationId) {
	$STM = $dbh->prepare("SELECT member_id FROM members WHERE card_no = :card_no AND organisation_id = :organisation_id");
    $STM->bindParam(':card_no', $cardNo);
    $STM->bindParam(':organisation_id', $organisationId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['member_id'];}
	else {return false;}
	$STM = null;
}

function get_signed_in_members($dbh, $venueId) { 
	$STM = $dbh->prepare("SELECT members.full_name as full_name, members.verified as verified, 
		attendance.sign_in_time as sign_in_time FROM attendance INNER JOIN members 
		ON members.member_id = attendance.member_id WHERE attendance.venue_id = :venue_id");
    $STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$signedInMembers = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $signedInMembers[$count] = array( 'full_name' => $row['full_name'],
	        'verified' => $row['verified'], 'sign_in_time' => $row['sign_in_time'] );
	        $count = $count + 1;
	    }
	} 
	return $signedInMembers;
}

function already_signed_in($dbh, $memberId) {
	$STM = $dbh->prepare("SELECT member_id FROM attendance WHERE member_id = :member_id");
    $STM->bindParam(':member_id', $memberId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord) && $STMrecord) {return true;}
	else {return false;}
	$STM = null;
}

function add_unconfirmed_member($dbh, $signUpFname, $signUpLname, $signUpGenderId, $signUpBirthdate, $organisationId) {
	$STM = $dbh->prepare("INSERT INTO members ( fname, lname, full_name, gender_id, birthdate, organisation_id, first_visit ) 
		VALUES ( :fname, :lname, :full_name, :gender_id, STR_TO_DATE(:birthdate, '%d/%m/%Y'), :organisation_id, CURDATE() )");
	$fullName = $signUpFname . ' ' . $signUpLname;
	$STM->bindParam(':fname', $signUpFname); 
	$STM->bindParam(':lname', $signUpLname);
	$STM->bindParam(':full_name', $fullName); 
	$STM->bindParam(':gender_id', $signUpGenderId);  
	$STM->bindParam(':birthdate', $signUpBirthdate); 
	$STM->bindParam(':organisation_id', $organisationId); 
	$STM->execute();
	$STM = null;
}

function update_member($dbh, $memberId, $attribute, $value) {
	$sql = 'UPDATE members SET ' . $attribute . ' = :value WHERE member_id = :member_id';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':member_id', $memberId); 
	$STM->bindParam(':value', $value);  
	$STM->execute();
	$STM = null;
}
function update_member_birthdate($dbh, $memberId, $birthdate) {
	$STM = $dbh->prepare("UPDATE members SET birthdate = STR_TO_DATE(:birthdate, '%d/%m/%Y') WHERE member_id = :member_id");
	$STM->bindParam(':member_id', $memberId); 
	$STM->bindParam(':birthdate', $birthdate); 
	$STM->execute();
	$STM = null;
}

function already_a_member($dbh, $signUpFname, $signUpLname, $organisationId) {
	$fullName = $signUpFname . ' ' . $signUpLname;
	$STM = $dbh->prepare("SELECT member_id FROM members WHERE full_name = :full_name AND organisation_id = :organisation_id");
    $STM->bindParam(':organisation_id', $organisationId);
    $STM->bindParam(':full_name', $fullName);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord) && $STMrecord) {return true;}
	else {return false;}
	$STM = null;
}

// USERS
function get_user_full($dbh, $userId) {
	$STM = $dbh->prepare("SELECT users.user_name as user_name, users.email as email, 
		organisations.organisation_id as organisation_id, organisations.organisation_name as organisation_name, 
		users.role_id as role_id, roles.role_name as role_name
	 FROM users INNER JOIN organisations ON users.organisation_id = organisations.organisation_id
	 INNER JOIN roles ON users.role_id = roles.role_id WHERE user_id = :user_id");
    $STM->bindParam(':user_id', $userId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0];}
	else {return false;}
	$STM = null;
}

function get_users($dbh) {
	// Prepare query for showing requested results.
	$STM = $dbh->prepare("SELECT `user_name`, `user_id` FROM users");
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$users = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $users[$count] = array( 'user_name' => $row['user_name'], 'user_id' => $row['user_id']);
	        $count = $count + 1;
	    }
	} 
	return $users;
}

function get_roles($dbh) {
	// Prepare query for showing requested results.
	$STM = $dbh->prepare("SELECT `role_name`, `role_id` FROM roles");
	// For Executing prepared statement we will use below function
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$roles = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $roles[$count] = array( 'role_name' => $row['role_name'], 'role_id' => $row['role_id']);
	        $count = $count + 1;
	    }
	} 
	return $roles;
}

function log_in_user($dbh, $userName, $password) {
	$STM = $dbh->prepare("SELECT user_id FROM users WHERE user_name = :user_name AND user_password = :user_password");
    $STM->bindParam(':user_name', $userName);
    $STM->bindParam(':user_password', $password);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['user_id'];}
	else {return false;}
	$STM = null;
}

function add_user($dbh, $name, $password, $email, $organisationId, $roleId) {
	$STM = $dbh->prepare("INSERT INTO users ( user_name, user_password, email, organisation_id, role_id ) VALUES 
		( :user_name, :user_password, :email, :organisation_id, :role_id)");
	$STM->bindParam(':user_name', $name); 
	$STM->bindParam(':user_password', $password);
	$STM->bindParam(':email', $email); 
	$STM->bindParam(':organisation_id', $organisationId); 
	$STM->bindParam(':role_id', $roleId);  
	$STM->execute();
	$STM = null;
}

function remove_user($dbh, $userId) {
	$STM = $dbh->prepare("DELETE FROM users WHERE user_id = :user_id");
	// bind parameters, Named parameters alaways start with colon(:)                      
    $STM->bindParam(':user_id', $userId);
	$STM->execute();
	$STM = null;
}

function update_user($dbh, $userId, $email, $organisationId, $roleId) {
	$STM = $dbh->prepare("UPDATE users SET email = :email, organisation_id = :organisation_id, role_id = :role_id  
	WHERE user_id = :user_id");
	$STM->bindParam(':user_id', $userId); 
	$STM->bindParam(':email', $email); 
	$STM->bindParam(':organisation_id', $organisationId); 
	$STM->bindParam(':role_id', $roleId);  
	$STM->execute();
	$STM = null;
}

function update_user_password($dbh, $userId, $password) {
	$STM = $dbh->prepare("UPDATE users SET user_password = :password  
	WHERE user_id = :user_id");
	$STM->bindParam(':user_id', $userId); 
	$STM->bindParam(':password', $password); 
	$STM->execute();
	$STM = null;
}

function get_user_id_by_name($dbh, $userName) {
	$STM = $dbh->prepare("SELECT user_id FROM users WHERE user_name = :name");
    $STM->bindParam(':name', $userName);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['user_id'];}
	else {return false;}
	$STM = null;
}

function get_users_default_venue($dbh, $userId) {
	$STM = $dbh->prepare("SELECT venues.name as venue, venues.timezone as timezone FROM users 
		INNER JOIN venues ON users.venue_id = venues.venue_id
		WHERE user_id = :user_id AND venues.visible = 1");
    $STM->bindParam(':user_id', $userId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0];}
	else {return false;}
	$STM = null;
}

function is_venue_empty($dbh, $venueId) {
	$STM = $dbh->prepare("SELECT * FROM attendance WHERE venue_id = :venue_id");
   $STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return false;}
	else {return true;}
	$STM = null;
}

function show_venue($dbh, $venueId) {
	$STM = $dbh->prepare("UPDATE venues SET visible = 1 WHERE venue_id = :venue_id");
   $STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STM = null;
}

// ORGANISATIONS
function get_organisations($dbh) {
	// Prepare query for showing requested results.
	$STM = $dbh->prepare("SELECT `organisation_id`, `organisation_name` FROM organisations WHERE visible = 1");
	// For Executing prepared statement we will use below function
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$organisations = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $organisations[$count] = array( 'organisation_id' => $row['organisation_id'], 'organisation_name' => $row['organisation_name']);
	        $count = $count + 1;
	    }
	} 
	return $organisations;
}

function get_organisation_id_by_name($dbh, $name) {
	$STM = $dbh->prepare("SELECT organisation_id FROM organisations WHERE organisation_name = :name");
    $STM->bindParam(':name', $name);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['organisation_id'];}
	else {return false;}
	$STM = null;
}

function get_organisation_id_by_user($dbh, $userId) {
	$STM = $dbh->prepare("SELECT organisation_id FROM users WHERE user_id = :user_id");
    $STM->bindParam(':user_id', $userId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['organisation_id'];}
	else {return false;}
	$STM = null;
}

function get_organisation_by_id($dbh, $organisationId) {
	$STM = $dbh->prepare("SELECT organisation_name FROM organisations WHERE organisation_id = :organisation_id");
    $STM->bindParam(':organisation_id', $organisationId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['organisation_name'];}
	else {return false;}
	$STM = null;
}

function hide_orphaned_organisations($dbh) {
	$STM = $dbh->prepare("UPDATE organisations set visible = 0 WHERE organisation_id NOT IN 
		(SELECT organisation_id FROM users)");
	$STM->execute();
	$STM = null;
}

function show_active_organisations($dbh) {
	$STM = $dbh->prepare("UPDATE organisations set visible = 1 WHERE organisation_id IN 
		(SELECT organisation_id FROM users)");
	$STM->execute();
	$STM = null;
}

function add_organisation($dbh, $name) {
	$STM = $dbh->prepare("INSERT INTO organisations (organisation_name) VALUES ( :name )");
	$STM->bindParam(':name', $name); 
	$STM->execute();
	$STM = null;
}

// VENUES
function get_venues($dbh, $organisationId) {
	// Prepare query for showing requested results.
	$STM = $dbh->prepare("SELECT `venue_id`, `name`, `timezone` FROM venues WHERE visible = 1 
		AND organisation_id = :organisation_id");
	$STM->bindParam(':organisation_id', $organisationId); 
	// For Executing prepared statement we will use below function
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$venues = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $venues[$count] = array( 'venue_id' => $row['venue_id'], 'name' => $row['name'], 'timezone' => $row['timezone']);
	        $count = $count + 1;
	    }
	} 
	return $venues;
}

function add_venue($dbh, $name, $organisationId) {
	$STM = $dbh->prepare("INSERT INTO venues (name, organisation_id) VALUES ( :name, :organisation_id )");
	$STM->bindParam(':name', $name);
	$STM->bindParam(':organisation_id', $organisationId);
	$STM->execute();
	$STM = null;
}

function get_venue_id_by_name($dbh, $name, $organisationId) {
	$STM = $dbh->prepare("SELECT venue_id FROM venues WHERE name = :name AND organisation_id = :organisation_id");
    $STM->bindParam(':organisation_id', $organisationId);
    $STM->bindParam(':name', $name);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['venue_id'];}
	else {return false;}
	$STM = null;
}

function get_venue_by_id($dbh, $venueId){
	$STM = $dbh->prepare("SELECT name FROM venues WHERE venue_id = :venue_id");
    $STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['name'];}
	else {return false;}
	$STM = null;
}

function get_venue_timezone($dbh, $venueId){
	$STM = $dbh->prepare("SELECT timezone FROM venues WHERE venue_id = :venue_id");
    $STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['timezone'];}
	else {return false;}
	$STM = null;
}

function set_user_venue($dbh, $venueId, $userId) {
	$STM = $dbh->prepare("UPDATE users SET venue_id = :venue_id WHERE user_id = :user_id");
    $STM->bindParam(':venue_id', $venueId);
    $STM->bindParam(':user_id', $userId);
	$STM->execute();
	$STM = null;
}

function set_venue_timezone($dbh, $venueId, $timezone) {
	$STM = $dbh->prepare("UPDATE venues SET timezone = :timezone WHERE venue_id = :venue_id");
    $STM->bindParam(':venue_id', $venueId);
    $STM->bindParam(':timezone', $timezone);
	$STM->execute();
	$STM = null;
}

function hide_venue($dbh, $venueId){
	$STM = $dbh->prepare("UPDATE venues SET visible = 0 WHERE venue_id = :venue_id");
	$STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STM = null;
}

function remove_default_venue($dbh, $venueID){
	$STM = $dbh->prepare("UPDATE users SET venue_id = 0 WHERE venue_id = :venue_id");
	$STM->bindParam(':venue_id', $venueId);
	$STM->execute();
	$STM = null;
}

// THINGS - ie. referenced for members by id. like school, suburb etc
function get_things($dbh, $organisationId, $things) {
	$sql = 'SELECT name FROM ' . $things . ' WHERE organisation_id = :organisation_id AND visible = 1';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':organisation_id', $organisationId); 
	// For Executing prepared statement we will use below function
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$things = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $things[$count] = array( 'name' => $row['name']);
	        $count = $count + 1;
	    }
	} 
	return $things;
}

function add_thing($dbh, $organisationId, $things, $name) {
	$sql = 'INSERT INTO ' . $things . ' (name, organisation_id) VALUES ( :name, :organisation_id)';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':name', $name); 
	$STM->bindParam(':organisation_id', $organisationId); 
	$STM->execute();
	$STM = null;
}

function get_thing_id_by_name($dbh, $organisationId, $things, $name) {
	$sql = 'SELECT id FROM ' . $things . ' WHERE name = :name AND organisation_id = :organisation_id'; 
	$STM = $dbh->prepare($sql);
    $STM->bindParam(':organisation_id', $organisationId);
    $STM->bindParam(':name', $name);
	$STM->execute();
	$STMrecord = $STM->fetchAll();
	if (isset($STMrecord[0]) && $STMrecord[0]) {return $STMrecord[0]['id'];}
	else {return false;}
	$STM = null;
}

function show_thing($dbh, $things, $thingId){
	$sql = 'UPDATE ' . $things . ' SET visible = 1 WHERE id = :id';
	$STM = $dbh->prepare($sql);
    $STM->bindParam(':id', $thingId);
    $STM->execute();
    $STM = null;
}

function hide_thing($dbh, $things, $thingId){
	$sql = 'UPDATE ' . $things . ' SET visible = 0 WHERE id = :id';
	$STM = $dbh->prepare($sql);
    $STM->bindParam(':id', $thingId);
	$STM->execute();
	$STM = null;
}

function hide_orphaned_things($dbh, $things, $attribute) {
	$sql = 'UPDATE ' . $things . ' SET visible = 0 WHERE id NOT IN (SELECT ' . $attribute . 
		' FROM members WHERE ' . $attribute . ' IS NOT NULL)';
	$STM = $dbh->prepare($sql);
	$STM->execute();
	$STM = null;
}

function set_date_format($dbh, $userId, $dateFormat) {
	$sql = 'UPDATE users SET date_format = :date_format WHERE user_id = :user_id';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':date_format', $dateFormat);
	$STM->bindParam(':user_id', $userId);	
	$STM->execute();
	$STM = null;
}

/* later
function get_date_format($dbh, $userId) {
	$sql = 'SELECT date_format from user WHERE user_id = :user_id';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':user_id', $userId);	
	$STM->execute();
	$STMrecords = $STM->fetchAll();
	$dateFormat = "Y-m-d";
		if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $dateFormat = $row['date_format'];
	    }
	}
	return $dateFormat;
	$STM = null;
}
*/

function get_update_messages($dbh, $userId) {
	$sql = 'SELECT message FROM messages WHERE id NOT IN ( SELECT message_id FROM read_messages WHERE user_id = :user_id)';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':user_id', $userId); 
	// For Executing prepared statement we will use below function
	$STM->execute();
	// // fetch records like this and use foreach loop to show multiple Results
	$STMrecords = $STM->fetchAll();
	// then disconnect
	$STM = null;
	// populate array with fetched results.
	$count = 0;
	$things = false;
	if ($STMrecords) {
	    foreach($STMrecords as $row) {
	        $things[$count] = $row['message'];
	        $count = $count + 1;
	    }
	} 
	return $things;
}

function purge_old_messages($dbh, $userId) {
	$sql = 'INSERT INTO read_messages (message_id, user_id) SELECT messages.id, :user_id FROM messages WHERE ';
	$sql .= 'messages.id NOT IN ( SELECT message_id FROM read_messages WHERE user_id = :user_id)';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':user_id', $userId);	
	$STM->execute();
	$STM = null;
	$sql = 'DELETE FROM messages WHERE creation_dts < DATE_SUB(UTC_TIMESTAMP(), INTERVAL 6 MONTH)';
	$STM = $dbh->prepare($sql);
	$STM->execute();
	$STM = null;
	
}

function add_message($dbh, $message, $message_uid){
	$sql = 'INSERT INTO messages (message, message_uid, creation_dts) VALUES (:message, :message_uid, UTC_TIMESTAMP())';
	$STM = $dbh->prepare($sql);
	$STM->bindParam(':message', $message);
	$STM->bindParam(':message_uid', $message_uid);	
	$STM->execute();
	$STM = null;
}

?>
