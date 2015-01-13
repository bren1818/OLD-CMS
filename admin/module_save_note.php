<?php
	include("db.php");
	
	if( isset($_POST['note']) && $_POST['note'] != ""){
		$mysqldate = date('Y-m-d H:i:s');
		$note = addslashes($_POST['note']);
		$q = "UPDATE `stickynote` SET  `Note_Text` =  \"".urlencode($note)."\", `Last_Update` =  '".$mysqldate."' WHERE `id` = 1 LIMIT 1 ;";
		if(mysql_query($q)){
			echo "1"; //success 
		}else{
			echo "0"; //failure
		}
	}

	if( isset($_REQUEST['loadNote']) && $_REQUEST['loadNote'] == 1){
		$q = "SELECT `Note_Text` FROM  `stickynote` WHERE `id` = 1";
		$q = mysql_query($q);
		if( mysql_num_rows($q)!=0 ){
			while($info = mysql_fetch_assoc( $q ))
			{
				echo $info['Note_Text'] ;
			}
		}
	}
?>