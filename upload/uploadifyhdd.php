<?php
	function endswith($string, $test) {
		$strlen = strlen($string);
		$testlen = strlen($test);
		if ($testlen > $strlen) return false;
		return substr_compare(strtolower($string), strtolower($test), -$testlen) === 0;
	}
  
    function createThumbnail($filename) {  
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
    }  
	
	if (!empty($_FILES)) {
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

		move_uploaded_file($tempFile,$targetFile);
		if(  endswith($_FILES['Filedata']['name'], ".jpg") || endswith($_FILES['Filedata']['name'], ".jpeg") || endswith($_FILES['Filedata']['name'], ".png") || endswith($_FILES['Filedata']['name'], ".gif") ){
		createThumbnail($_FILES['Filedata']['name']);
		}
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	}


?>