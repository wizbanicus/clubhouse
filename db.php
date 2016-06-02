<?php

	// ensure tables exists!
	// ensure member table exists!
	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `members` (
		`member_id` SERIAL,
		`fname` varchar(255) NOT NULL,
		`lname` varchar(255) NOT NULL,
		`email` varchar(255) DEFAULT NULL,
		`full_name`	varchar(255) NOT NULL,
		`gender_id` bigint(20) DEFAULT NULL,
		`card_no` varchar(255) DEFAULT NULL UNIQUE,
		`birthdate` date NULL DEFAULT NULL,
		`first_visit` date NULL DEFAULT NULL,
		`comments` varchar(255) DEFAULT NULL,
		`street_address` varchar(255) DEFAULT NULL,
		`suburb_id` bigint(20) DEFAULT NULL,
		`city_id` bigint(20) DEFAULT NULL,
		`country_id` bigint(20) DEFAULT NULL,
		`state_id` bigint(20) DEFAULT NULL,
		`zip_code` bigint(20) DEFAULT NULL,
		`phone1` varchar(255) DEFAULT NULL,
		`phone2` varchar(255) DEFAULT NULL,
		`phone3` varchar(255) DEFAULT NULL,
		`guardian_fname` varchar(255) DEFAULT NULL,
		`guardian_lname` varchar(255) DEFAULT NULL,
		`guardian_relationship` varchar(255) DEFAULT NULL,
		`guardian_phone1` varchar(255) DEFAULT NULL,
		`guardian_phone2` varchar(255) DEFAULT NULL,
		`emergency_fname` varchar(255) DEFAULT NULL,
		`emergency_lname` varchar(255) DEFAULT NULL,
		`emergency_relationship` varchar(255) DEFAULT NULL,
		`emergency_phone1` varchar(255) DEFAULT NULL,
		`emergency_phone2` varchar(255) DEFAULT NULL,
		`school_id` bigint(20) DEFAULT NULL,
		`ethnicity_id` bigint(20) DEFAULT NULL,
		`member_type_id` bigint(20) DEFAULT NULL,
		`verified` BOOLEAN NOT NULL DEFAULT FALSE,
		`organisation_id` bigint(20) DEFAULT NULL
		)");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `suburbs` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `countries` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `states` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `schools` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `cities` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `ethnicities` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `member_types` (
	`id` serial,
	`organisation_id` bigint(20),
	`visible` BOOLEAN NOT NULL DEFAULT TRUE,
	`name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;		

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `organisations` (
	`organisation_id` serial,
	`organisation_name` varchar(255) NOT NULL,
	`visible` BOOLEAN NOT NULL DEFAULT TRUE
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `users` (
	`user_id` serial,
	`organisation_id` bigint(20),
	`role_id` bigint(20),
	`user_name` varchar(255) NOT NULL,
	`user_password` varchar(255) NOT NULL,
	`venue_id` bigint(20) DEFAULT NULL,
	`email` varchar(255) DEFAULT NULL,
	`date_format` varchar(255) DEFAULT NULL,
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `roles` (
	`role_id` bigint(20) DEFAULT NULL UNIQUE,
	`role_name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("
	INSERT IGNORE INTO roles
 	SET role_id=1, role_name='admin'");
	$STM->execute();
	$STM = null;
	$STM = $dbh->prepare("
	INSERT IGNORE INTO roles 
 	SET role_id=2, role_name='staff'");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `genders` (
	`gender_id` bigint(20) DEFAULT NULL UNIQUE,
	`gender_name` varchar(255) NOT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("
	INSERT IGNORE INTO genders 
 	SET gender_id=0, gender_name='other'");
	$STM->execute();
	$STM = null;
	$STM = $dbh->prepare("
	INSERT IGNORE INTO genders 
 	SET gender_id=1, gender_name='male'");
	$STM->execute();
	$STM = null;
	$STM = $dbh->prepare("
	INSERT IGNORE INTO genders 
 	SET gender_id=2, gender_name='female'");
	$STM->execute();
	$STM = null;

	// ensure attendance table exists!
	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `attendance` (
		`attendance_id` SERIAL,
		`member_id` varchar(255) DEFAULT NULL,
		`sign_in_time` timestamp NULL DEFAULT NULL,
		`venue_id` bigint(20),
		`organisation_id` bigint(20)
		)");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;
		$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `attendance_records` (
		`attendance_id` SERIAL,
		`member_id` varchar(255) DEFAULT NULL,
		`sign_in_time` timestamp NULL DEFAULT NULL,
		`sign_out_time` timestamp NULL DEFAULT NULL,
		`venue_id` bigint(20),
		`organisation_id` bigint(20),
		`auto_signed_out` BOOLEAN NOT NULL DEFAULT FALSE
		)");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;
	// ensure venues table exists!
	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `venues` (
		`venue_id` SERIAL,
		`organisation_id` bigint(20),
		`name` varchar(255) NOT NULL,
		`visible` BOOLEAN NOT NULL DEFAULT TRUE,
		`timezone` varchar(255) DEFAULT NULL
		)");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `messages` (
	`id` serial,
	`creation_dts` timestamp NULL DEFAULT NULL,
	`message` varchar(255) DEFAULT NULL
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE TABLE IF NOT EXISTS `read_messages` (
	`id` serial,
	`message_id` bigint(20),
	`user_id` bigint(20)
	);");
	$STM->execute();
	$STM = null;

	$STM = $dbh->prepare("CREATE OR REPLACE VIEW view_members AS
		SELECT 
		`members`.`member_id` AS member_id,
		`members`.`fname` AS fname,
		`members`.`lname` AS lname,
		`members`.`email` AS email,
		`members`.`full_name`	AS full_name,
		`genders`.`gender_name` AS gender,
		`members`.`card_no` AS card_no,
		`members`.`birthdate` AS birthdate,
		`members`.`first_visit` AS first_visit,
		`members`.`comments` AS comments,
		`members`.`street_address` AS street_address,
		`suburbs`.`name` AS suburb,
		`cities`.`name` AS city,
		`countries`.`name` AS country,
		`states`.`name` AS state,
		`members`.`zip_code` AS zip_code,
		`members`.`phone1` AS phone1,
		`members`.`phone2` AS phone2,
		`members`.`phone3` AS phone3,
		`members`.`guardian_fname` AS guardian_fname,
		`members`.`guardian_lname` AS guardian_lname,
		`members`.`guardian_relationship` AS guardian_relationship,
		`members`.`guardian_phone1` AS guardian_phone1,
		`members`.`guardian_phone2` AS guardian_phone2,
		`members`.`emergency_fname` AS emergency_fname,
		`members`.`emergency_lname` AS emergency_lname,
		`members`.`emergency_relationship` AS emergency_relationship,
		`members`.`emergency_phone1` AS emergency_phone1,
		`members`.`emergency_phone2` AS emergency_phone2,
		`schools`.`name` AS school,
		`ethnicities`.`name` AS ethnicity,
		`member_types`.`name` AS member_type_name,
		`members`.`verified` AS verified,
		`organisations`.`organisation_name` AS organisation
		FROM members 
		LEFT JOIN genders
		ON members.gender_id = genders.gender_id
		LEFT JOIN suburbs
		ON members.suburb_id = suburbs.id
		LEFT JOIN cities
		ON members.city_id = cities.id
		LEFT JOIN countries
		ON members.country_id = countries.id
		LEFT JOIN states
		ON members.state_id = states.id
		LEFT JOIN schools
		ON members.school_id = schools.id
		LEFT JOIN ethnicities
		ON members.ethnicity_id = ethnicities.id
		LEFT JOIN organisations
		ON members.organisation_id = organisations.organisation_id
		LEFT JOIN member_types
		ON members.member_type_id = member_types.id
		");
	// For Executing prepared statement we will use below function
	$STM->execute();
	$STM = null;

	

?>
