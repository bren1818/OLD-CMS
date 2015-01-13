<?php
session_start();
$inactive = 1800;
if(isset($_SESSION['userId']) ) {
	$session_life = time() - $_SESSION['time'];
	if($session_life > $inactive)
    { 
		session_destroy(); 
		header("Location: /admin/admin.php?timeOut=1"); 
	}else{
		$userId = $_SESSION['userId'];
		$username = $_SESSION['username']; 
		$startTime = $_SESSION['start_time'];
		$activeFor = (time() - $startTime);
	}
}

if( isset($_SESSION) ){
	$_SESSION['time'] = time(); //reset the time
	if( $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){ //are we on the session registered to the machine?
		$sessionWarning = "IP mis-match, you may be logged in at multiple locations or someone may be trying to do a session highjack";
	}
}

if( isset($_REQUEST['destroy']) ){ //called on logout
	session_destroy(); 
	header("Location: /admin/admin.php?logout=1"); 
}
?>