<?php
// shared functions
date_default_timezone_set('UTC');
$timezones = timezone_identifiers_list();
function member_things($dbh, $attribute, $things, $name, $memberId, $organisationId) {
	$thingId = get_thing_id_by_name($dbh, $organisationId, $things, $name );
	if ($thingId) {
		update_member($dbh, $memberId, $attribute, $thingId);
		show_thing($dbh, $things, $thingId);
	} else {
		add_thing($dbh, $organisationId, $things, $name);
		$thingId = get_thing_id_by_name($dbh, $organisationId, $things, $name );
		update_member($dbh, $memberId, $attribute, $thingId);
	}
	hide_orphaned_things($dbh, $things, $attribute);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = ucwords(strtolower($data));
  return $data;
}

function validate_date($date, $format = 'd/m/Y', $newFormat = 'd/m/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($newFormat) == $date;
}

function debug() {
	$message = "DEBUG: userId: " . $userId;
	setcookie('message', $message);

}

function new_date_string($date_string, $desired_tz_str, $arriving_format = 'Y-m-d H:i:s', $desired_format='Y-m-d H:i', $arriving_tz_str = 'UTC') {
	// NOTE: takes a date string and a timezone string and a format and returns a new date string in the desired format
	// IMPORTANT: The date string musta rrive in the format 
	// date_create_from_format creates a datetime object
	$arriving_tz_object = new DateTimeZone($arriving_tz_str);
	$new_date_object = date_create_from_format($arriving_format, $date_string, $arriving_tz_object);
	// finally we'll convert by creating a timezone object
	$desired_tz_object = new DateTimeZone($desired_tz_str);
	// then set the time zone of the date object using the timezone object
	$new_date_object->setTimezone($desired_tz_object);
	// finally create a string to represent the date object
	$new_date_string = $new_date_object->format($desired_format);
	return $new_date_string;
}

?>
