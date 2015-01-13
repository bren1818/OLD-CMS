<?php
	include("session.php");
	include("../functions.php");
	error_reporting(0);
	//$cachingOn = 0;
	printPageHeader("Clearing Cache", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("adminHeader.php");

	deleteFiles("../cache");

	if( file_exists("css/cache_master.css") ){
	unlink( "css/cache_master.css" );
		echo "filename: cache_master.css - deleted<br/>";
	}

	if( file_exists("js/cache_master.js") ){	
		unlink( "js/cache_master.js" );
		echo "filename: cache_master.js - deleted<br/>";
	}
	echo "Cache and logs successfully cleared";

	printFooter();
?>
