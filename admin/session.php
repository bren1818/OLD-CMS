<?php
session_start();

function pathToRoot(){
			(substr_count( getcwd(), '\\') - 2 > 0) ? $dir_depth = substr_count( getcwd(), '\\') - 2  : $dir_depth=0; 
			$toRoot= "";
			for( $x = 0; $x < $dir_depth; $x++){
				$toRoot = $toRoot."../";
			}
			return $toRoot;
		}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

$inactive = 1800;

if(isset($_SESSION['userId']) ) {
	$session_life = time() - $_SESSION['time'];
	if($session_life > $inactive)
    { 
		session_destroy(); 
		header("Location: admin.php?timeOut=1"); 
	}else{
		$userId = $_SESSION['userId'];
		$username = $_SESSION['username']; 
		$startTime = $_SESSION['start_time'];
		$activeFor = (time() - $startTime);
	}
	
	if ( curPageName() == "admin.php" ){
		header('Location: adminOptions.php');
	}
	
}else{
	if ( curPageName() != "admin.php" ){
		header("Location: ".pathToRoot()."admin/admin.php?login=1"); 
	}
}

$_SESSION['time'] = time(); //reset the time



if( isset($_SESSION['ip']) && $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']){ //are we on the session registered to the machine?
	$sessionWarning = "IP mis-match, you may be logged in at multiple locations or someone may be trying to do a session highjack";
}

if( isset($_REQUEST['destroy']) ){ //called on logout
	session_destroy(); 
	header("Location: admin.php?logout=1"); 
}
?>