<?php
	include("session.php");
	
	function deleteFile($file){
		if( is_file($file) ){
			unlink( $file );
			echo "<p style='color : #fff;'>File Deleted Successfully</p>";
		}
	}
	
	if( isset($_REQUEST['Delete']) && $_REQUEST['Delete']!= ""){
		deleteFile( '../uploads/'.urldecode($_REQUEST['Delete']) );
	}
?>