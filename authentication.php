<?php
// authentication - check authentication situation
// respond accordinly, should be used every page!
// - if our sessionCookie is not good kill it, also when checking, kill all old sessions (orphaned)
// finnally return the current mode.
session_start();
if (isset($_SESSION) && $_SESSION['user']){

} else {
	header("Location: admin.php");
}
?>