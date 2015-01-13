<?php
	include("admin/db.php");
	date_default_timezone_set('America/New_York'); // set the time
	
	function mround($number, $precision=0) {
		$precision = ($precision == 0 ? 1 : $precision);   
		$pow = pow(10, $precision);
	   
		$ceil = ceil($number * $pow)/$pow;
		$floor = floor($number * $pow)/$pow;
	   
		$pow = pow(10, $precision+1);
	   
		$diffCeil     = $pow*($ceil-$number);
		$diffFloor     = $pow*($number-$floor)+($number < 0 ? -1 : 1);
	   
		if($diffCeil >= $diffFloor) return $floor;
		else return $ceil;
	} 
	
	function getTimestamp($ts)
	{
		$ts = $ts / 1000;
		return date("Y-m-d h:i:s", $ts);
	}
	
	function formatTime($sec){
		if( $sec < 60 ){
			return mround($sec,2)." seconds";
		}
		else if( $sec < 3600){
			return mround(($sec / 60),2)." minutes";
		}
		else if( $sec < 216000){
			return mround(($sec / 60 / 60),2)." hours";
		}
	}
			
	$query = "SELECT *FROM `user_tracking` ORDER BY `ip`, `page_Entry` ASC"; //inner join ip by name?
	$query = mysql_query($query);
	$ip = 0;
	$startTime = 0;
	$exitTime = 0;
	$count = 1;
	while($info = mysql_fetch_array( $query )){
	
		if(  $info['ip'] != $ip){
			$ip = $info['ip'];
			$count = 1;
			echo "<h3>User (".$ip.")</h3>";
			$startTime = $info['page_Entry'];
			echo "<p><b>Start</b> > [ " . getTimestamp($info['page_Entry']) ." ] --><br />";	
		}
		
		$id = $info['log_Id'];
		
		$cur_page = $info['current_Page'];
		
		
		$cur_page = preg_replace('/http:\/\//', '', $cur_page);
		$cur_page = preg_replace('/'.$_SERVER['HTTP_HOST'].'/', '', $cur_page);
		
		//$prev_page = $info['page_Referrer'];
		$next_page = $info['next_Page'];
		//$page_entry = $info['page_Entry'];
		$page_exit =  $info['page_Exit'];
		$page_time =  ($info['Page_Time'] / 1000);
		
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$count.".&nbsp;&nbsp;&nbsp;&nbsp;<b>".$cur_page."</b> (".formatTime($page_time).")";
		$count++;
		if( $info['next_Page'] == "EXTERNAL" ){
			$exitTime = $page_exit;
			$siteTime = (( $exitTime - $startTime) / 1000) ;
			echo "<br /><br/>Time on site: ".formatTime($siteTime).".";
			echo "<br /><br />End [ ".getTimestamp($page_exit)." ]</p>";
			$ip = 0;
			echo "<hr/>";
		}else{
			echo " --> <br/>";
		}
	}
?>