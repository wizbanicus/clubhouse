<?php
// clubhouse updates - run on login.
// displays new info when needed and ensures the database is up to date.
function clubhouse_updates($dbh, $userId){
// this will add the latest messages and call any updates required
$messages = get_update_messages($dbh, $userId);
$update_messages = '';
if (isset($messages) && $messages) {
	foreach($messages as $message) {
		$update_messages .= ' <br /> ' . $message;
	} 
	setcookie('message', $update_messages);
}
purge_old_messages($dbh, $userId);
// next each update called as its own function with a unique number
// new ones should be added at the top!
added_to_reports($dbh,"9");
add_message_uid($dbh,"8");
}


function added_to_reports($dbh,$uid){
	$message = "added member_info to reports (just basic total number at this stage)";
	add_message($dbh, $message, $uid);
} 

/* we'll come back to this
function add_date_formats($dbh,$uid){
		$STM = $dbh->prepare("ALTER TABLE `users` ADD `date_format` varchar(255) DEFAULT NULL");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;
	$message = "added date format - now you can set your sate format on the main page :)";
	add_message($dbh, $message, $uid);
} 
*/

function add_message_uid($dbh,$uid){
		$STM = $dbh->prepare("ALTER TABLE `messages` ADD message_uid bigint(20) UNIQUE");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;
	$message = "added messaging system - now you'll get a message when you sign in after new features have been added!";
	add_message($dbh, $message, $uid);
} 

?>
