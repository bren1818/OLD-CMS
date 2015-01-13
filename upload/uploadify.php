<?php
	function endswith($string, $test) {
		$strlen = strlen($string);
		$testlen = strlen($test);
		if ($testlen > $strlen) return false;
		return substr_compare(strtolower($string), strtolower($test), -$testlen) === 0;
	}
  
    function createThumbnail($filename, $relId) {  
		
		$thumbName = $filename;
	
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $filename;
		
		$final_width_of_image = 100;  
		if( endswith($filename , "jpg") || endswith($filename , "jpeg") ) {  
			$filename = $targetFile;
			$im = imagecreatefromjpeg($filename);  
		} else if (endswith($filename , "gif")) {  
			$filename = $targetFile;
			$im = imagecreatefromgif($filename);  
		} else if ( endswith($filename , "png") ) {  
			$filename = $targetFile;
			$im = imagecreatefrompng($filename);  
		}  
		$ox = imagesx($im);  
		$oy = imagesy($im);  
		$nx = $final_width_of_image;  
		$ny = floor($oy * ($final_width_of_image / $ox));  
		$nm = imagecreatetruecolor($nx, $ny);  
		imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);  
		$thumb =  substr($filename,0, -4)."_thumb.jpg";
		imagejpeg($nm, $thumb );  
	
		//do upload
		
		$fp = fopen($thumb, 'r');
		$size = filesize($thumb);
		$fileType= "application/octet-stream";
		$content = fread($fp, filesize($thumb));
		$content = addslashes($content);
		fclose($fp);
		
		$query = "INSERT INTO `uploaded_file_thumbs` (`thumb_id`,`name`, `size`, `type`, `content` ) ".
		"VALUES ($relId, '$thumbName', '$size', '$fileType', '$content')";

		mysql_query($query);// or die('Error, query failed'); 
		unlink($filename);
		unlink($thumb);
   }  

if (!empty($_FILES)) {
	include("../admin/db.php");
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	$fileName = $_FILES['Filedata']['name'];
	$fileSize = $_FILES['Filedata']['size'];
	$fileType = $_FILES['Filedata']['type'];

	$fp = fopen($tempFile, 'r');
	$content = fread($fp, filesize($tempFile));
	$content = addslashes($content);
	fclose($fp);

	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}
	
	$query = "INSERT INTO `uploaded_files` (`name`, `size`, `type`, `content` ) ".
"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

	mysql_query($query);// or die('Error, query failed'); 
	
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

	move_uploaded_file($tempFile,$targetFile);
	if(  endswith($_FILES['Filedata']['name'], ".jpg") || endswith($_FILES['Filedata']['name'], ".jpeg") || endswith($_FILES['Filedata']['name'], ".png") || endswith($_FILES['Filedata']['name'], ".gif") ){	
		createThumbnail($_FILES['Filedata']['name'], mysql_insert_id() );
	}
	echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
}
?>