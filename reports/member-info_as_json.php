<?php
include '../authentication.php'
include 'data-reports.php';
$memberInfo = get_member_info($dbh, $_POST['startAge'], $_POST['endAge'], $_POST['asOfDate'], $_SESSION['organisation_id']);
$memberInfoJson = json_encode($memberInfo);
header('Content-type: application/json');
echo $memberInfoJson;
?>
