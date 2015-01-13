<?php
	include("../admin/db.php");
	$id =  $_REQUEST['id'];
	$type = $_REQUEST['type'];

	if( $type == "thumb"){
		$query = "SELECT name, type, size, content " .
			 "FROM `uploaded_file_thumbs` WHERE `thumb_id` = '$id'";
	}else{
		$query = "SELECT name, type, size, content " .
			 "FROM `uploaded_files` WHERE id = '$id'";
	}
			 
	$result = mysql_query($query) or die('Error, query failed');
	list($name, $type, $size, $content) =  mysql_fetch_array($result);
	header("Content-length: $size");
	header("Content-type: $type");
	header("Content-Disposition: attachment; filename=$name");
	echo $content;
?>