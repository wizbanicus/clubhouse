<?php
// global vars
/*
*
* DATES - CHANGE THE TOP ONLY!
*/

 $GLOBAL_DATE_FORMAT = 'Y/D/M';
//$GLOBAL_DATE_FORMAT = 'D/M/Y';
// $GLOBAL_DATE_FORMAT = 'M/D/Y';


switch ($GLOBAL_DATE_FORMAT) {
	case 'Y/D/M': {
		$GLOBALS['JS_DATE_FMT'] = 'YYYY/MM/DD'; // js ete
		$GLOBALS['DB_DATE_FMT'] = '%Y/%m/%d'; // data.php add_unconfirmed_member update_member_birthdate
		$GLOBALS['STR_ARRIVING_FMT'] = 'Y-m-d H:i:s'; //shared_functions string to date
		$GLOBALS['REPORT_ARRIVING_FMT'] = 'Y/m/d H:i:s'; //shared_functions string to date
		$GLOBALS['STR_DESIRED_FMT'] = 'Y-m-d H:i';
		$GLOBALS['VLDT_DATE_DEFAULT'] = 'Y/m/d'; // shared_functions validate date
		break;
	}
	case 'D/M/Y': {
		$GLOBALS['JS_DATE_FMT'] = 'DD/MM/YYYY'; // js ete
		$GLOBALS['DB_DATE_FMT'] = '%d/%m/%Y'; // data.php add_unconfirmed_member update_member_birthdate
		$GLOBALS['STR_ARRIVING_FMT'] = 'Y-m-d H:i:s'; //shared_functions string to date
		$GLOBALS['STR_DESIRED_FMT'] = 'Y-m-d H:i';
		$GLOBALS['REPORT_ARRIVING_FMT'] = 'd/m/Y H:i:s'; //shared_functions string to date
		$GLOBALS['VLDT_DATE_DEFAULT'] = 'd/m/Y'; // shared_functions validate date
		break;
	}
	case 'M/D/Y': {
		$GLOBALS['JS_DATE_FMT'] = 'MM/DD/YYYY'; // js ete
		$GLOBALS['DB_DATE_FMT'] = '%m/%d/%Y'; // data.php add_unconfirmed_member update_member_birthdate
		$GLOBALS['STR_ARRIVING_FMT'] = 'Y-m-d H:i:s'; //shared_functions string to date
		$GLOBALS['STR_DESIRED_FMT'] = 'Y-m-d H:i';
		$GLOBALS['REPORT_ARRIVING_FMT'] = 'm/d/Y H:i:s'; //shared_functions string to date
		$GLOBALS['VLDT_DATE_DEFAULT'] = 'm/d/Y'; // shared_functions validate date
		break;
	}
}
?>
