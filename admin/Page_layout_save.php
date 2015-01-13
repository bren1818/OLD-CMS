<?php
/*Page update handler!*/
session_start();
$inactive = 1800;
if(isset($_SESSION['userId']) ) {
	include("db.php");
	include("../functions.php");
	$session_life = time() - $_SESSION['time'];
	if($session_life > $inactive)
    { 
		echo "Your Session has expired, could not save!";
	}else{
		$userId = $_SESSION['userId'];
		$username = $_SESSION['username']; 
		$startTime = $_SESSION['start_time'];
		$activeFor = (time() - $startTime);
		
		if( isset($_REQUEST['data']) && $_REQUEST['data'] != "" && $_REQUEST['page'] && $_REQUEST['page'] != ""  ){
			$page = (int)$_REQUEST['page'];
			$dataString = $_REQUEST['data'];
			$sections = explode("}{",$dataString); // columns should be same as number of coumns
			$error = 0;
			if( $page != "" )
			{
				/*Drop initial junk (old layout)*/
				
				$lr = "DELETE  FROM `pages_content_layout` WHERE `page_id` = ".$page;
				$lr = mysql_query($lr);
				if( $lr ){
			
					for($x = 0; $x < count($sections); $x++){
						$sections[$x] =  preg_replace('/[^0-9,\s]/', '', $sections[$x]);
						$entry = explode(",", $sections[$x]);
						for( $y = 0; $y < count( $entry ); $y++){
							$data = explode(" ", $entry[$y]);
								//echo "Page id: ".$data[0]." Content_id : ".$data[2]." Column Id : ".$data[4]." Order : ".$data[6]."\n";
							$addData = "INSERT INTO  `pages_content_layout` (`page_id` ,`content_id` ,`column_id` ,`order`)VALUES ('".$data[0]."',  '".$data[2]."',  '".$data[4]."',  '".$data[6]."');";
							$addData = mysql_query($addData);
							if( !$addData){
								$error = 1;
							}
						}
					}
					$delPage = "Select `url_index` from `pages` where `page_id` = ".$page;
					$delPage = mysql_query($delPage);
					if( $delPage && mysql_num_rows($delPage) != 0){
						 while($del = mysql_fetch_assoc( $delPage ))
						{
							$cachedfile = "../cache/".$del['url_index']."_fromDb.php.html";
							//echo $cachedfile;
							deleteFile($cachedfile);
						}
					}

					if( $error == 0){
						echo "Layout Saved!";	
					}else{
						echo "Some errors occurred during save...";
					}
				}
				else{
					echo "Could not remove old layout";	
				}
			}
			
			//echo "Recieved : ".$dataString." for page : ".$page;
		}else{
			echo "Invalid data sent";
		}
	}
}else{
	echo "Your Session has expired, could not save!";
}
?>