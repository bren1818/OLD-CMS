<?php
	include("admin/db.php");
	
	date_default_timezone_set('America/New_York'); // set the time
	if( isset($_POST)  ){
		$curPage = $_POST['curPage'];
		$pageEntryTime =  $_POST['pageEntryTime']; 
		$pageLeaveTime = $_POST['pageLeaveTime'];
		$comingFrom = $_POST['comingFrom'];
		
		if( isset($_POST['update']) ){
			$update = $_POST['update'];
		}else{
			$update = 0;
		}
		
		$goingTo = $_POST['goingTo']; 
		$timeSpan = $pageLeaveTime - $pageEntryTime;
		$remoteIP = $_SERVER['REMOTE_ADDR'];
	
	
	
		if( $update == 1){
			$query = "UPDATE `user_tracking` SET `next_Page` = '".$goingTo."',`page_Exit` = '".$pageLeaveTime."',`Page_Time` = '".$timeSpan."' WHERE `page_Entry` =".$pageEntryTime.";";
			$query = mysql_query($query);
		}else{
			$query = "INSERT INTO `user_tracking` (`log_Id`, `ip`, `current_Page`, `page_Referrer`, `next_Page`, `page_Entry`, `page_Exit`, `Page_Time`) VALUES (NULL, '".$remoteIP."', '".$curPage."', '".$comingFrom."', '".$goingTo."', '".$pageEntryTime."', '".$pageLeaveTime."', '".$timeSpan."');";
			$query = mysql_query($query);
			echo mysql_insert_id();
		}
		
		if( isset($_POST['pageId']) && $_POST['pageId'] != 0){
			$query = "UPDATE `pages` SET `page_views` = `page_views` + 1 WHERE `page_id` = ".$_POST['pageId'];
			$query = mysql_query($query);
		}
	}
?>