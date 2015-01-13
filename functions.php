<?php
$cssFile = "cache_master.css"; //cached & merged CSS Files
$jsFile = "cache_master.js"; //cacged & merged JS Files
$cacheFile= "cache/".curPageURL().".html";
$cacheTime = 24 * 60 * 60; //seconds of life
$cachingOn = 0; //should it cache stuff
include("/admin/db.php");

if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
	$cachingOn = 0; //no caching when logged in
}

date_default_timezone_set('America/New_York'); // set the time

function curPageURL(){
	if( substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1) == "index.php" &&  isset($_GET['page']) ){
		$loadPage = $_GET['page'];
		if($loadPage != "" && $loadPage!="index.php")
		{	
			if( !endsWith($loadPage,".php") )
			{
				$test = $loadPage.".php";
				if(  file_exists ($test) ){
					return $test;
				}else{
					return $loadPage."_fromDb.php";
				}
			}else{
				return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
			}
		}
	}else{
		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
}

function compress($compressed){
	//compress unnecesary spaces 
	$pattern = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s'); 
	$replace = array('>','<','\\1'); 
	$compressed = preg_replace($pattern, $replace, $compressed);
	return $compressed; 
}

function urlIsPublic() {
        /* Check URL is not private */
        $ip = gethostbyname($_SERVER['REMOTE_ADDR']);
        $long = ip2long($ip);
        if (($long >= 167772160 AND $long <= 184549375) OR ($long >= -1408237568 AND $long <= -1407188993) OR ($long >= -1062731776 AND $long <= -1062666241) OR ($long >= 2130706432 AND $long <= 2147483647) OR $long == -1) {
            return false;
        }
        return true;
}

function logToFile($filename, $message){
	
	if( urlIsPublic() &&  !isset($_SESSION['userId'])){
	
		$logfile = date('l jS \of F Y h:i:s A')." - ".$filename." - ".$message."<br/>";
		if (!file_exists( $_SERVER['DOCUMENT_ROOT']."/logs/".$filename."_updateLog.txt") ){
			$fp = fopen($_SERVER['DOCUMENT_ROOT']."/logs/".$filename."_updateLog.txt",'w');
			fwrite($fp,  $logfile );
			fclose($fp); 
		}else{
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/logs/".$filename."_updateLog.txt", "\r\n".$logfile, FILE_APPEND | LOCK_EX);
		}
	}
	
}

if( check($cssFile, "css", "css") == 1){ mergeFiles( $cssFile , "css", "css"); }else{}
if( check($jsFile, "js", "js") ==1){ mergeFiles( $jsFile , "js", "js"); }else{}

// Serve the cached file if it is older than $cacheTime
if( isset($fileFromDb) && $fileFromDb == 1 ){ // need to determine if this is a file time we're checking or mysql timestamp
	//check timestamp from page
	
	if (file_exists($cacheFile) && time() - $cacheTime < filemtime($cacheFile) && (strtotime($pageUpdateTime) )  <  filemtime($cacheFile) && $cachingOn == 1 ) { // check if curPageURL() is newer than $cacheFile, if so re-build cache else use cache
		include($cacheFile);
	//	logToFile( curPageURL()."_Access" , "<br/>Accessed from : ".$_SERVER['REMOTE_ADDR'] );
		exit;
	}else{
		ob_start();
		//logToFile( curPageURL() , "Re Generated");
	}
}else{
	if (file_exists($cacheFile) && time() - $cacheTime < filemtime($cacheFile) && filemtime(curPageURL()) <  filemtime($cacheFile) && $cachingOn == 1 ) { // check if curPageURL() is newer than $cacheFile, if so re-build cache else use cache
		include($cacheFile);
	//	logToFile( curPageURL()."_Access" , "<br/>Accessed from : ".$_SERVER['REMOTE_ADDR'] );
		exit;
	}else{
		ob_start();
		//logToFile( curPageURL() , "Re Generated");
	}
}

function mergeFiles($file, $dir, $filetype)
{
	$newfile='/*File "'.$file.'" Generated at: '.date('l jS \of F Y h:i:s A').'*/';
	//logToFile($file,"File Re-Merged/Updated");
	if (is_dir($dir)) 
	{
		if ($dh = opendir($dir)) {
			while (($incfile = readdir($dh)) !== false) 
			{
				if( filetype($dir."/".$incfile) == "file" && pathinfo( ($dir."/".$incfile), PATHINFO_EXTENSION) == $filetype  )
				{
					if( ($dir."/".$incfile) != ($dir."/".$file) )
					{
						$newfile.= "\n" . file_get_contents($dir."/".$incfile);	
					}
				}
			}
			closedir($dh);
		}
		$fp = fopen($dir."/".$file, 'w'); 
    	// save the contents of output buffer to the file
    	fwrite($fp,  compress( $newfile ) );  //compress the files if they aren't already
   		 // close the file
  		fclose($fp); 
	}
}

function deleteFile($file){
	if( is_file($file) ){
			unlink( $file );
	}
}

function deleteFiles($dir){
	if (is_dir($dir)) 
	{
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) 
			{
				if( is_file($dir."/".$file) ){
				//	echo "filename: $file - deleted<br/>";
					unlink( ($dir."/".$file) );
				}
			}
			closedir($dh);
		}
	}
}

function check( $cacheFile, $filetype, $dir ) //returns 1 if the cache should be updated
{
	$regenerate = 0;
	if(  file_exists( $dir."/".$cacheFile ) )
	{
		if (is_dir($dir)) 
		{
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) 
				{
					//echo "filename: $file - ".filemtime($dir."/".$file)." - file type: ".filetype($dir."/".$file)." - extension : ". pathinfo(($dir."/".$file), PATHINFO_EXTENSION)." <br/>";
					if( filetype($dir."/".$file) == "file" && pathinfo( ($dir."/".$file), PATHINFO_EXTENSION) == $filetype  ){
						//echo $file."<br/>";	
						if(   filemtime($dir."/".$file) < filemtime($dir."/".$cacheFile)  ){
								//use the cached file
						}else{
							if( ($dir."/".$file) != $dir."/".$cacheFile ){
								$regenerate = 1; //regenerate the cached file
								break;
							}
						}
					}
				}
				closedir($dh);
			}
		}
	}else{
		$regenerate = 1;	
	}
	return $regenerate;
}
	
function printPageHeader($pageTitle, $metaDescription, $metaKeywords , $id = null )
{
if( !isset( $id )){ $id = 0; }
$date = date('l jS \of F Y h:i:s A');
$header =<<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>{$pageTitle}</title>
	<!--Brendon Irwin&rsquo;s Page, cached and compressed for optimal speed. Cached & Compressed on $date-->
	<meta name='description' content="{$metaDescription}" />
	<meta name='Keywords' content="{$metaKeywords}" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
	<link rel="apple-touch-icon" href="/images/apple_touch_icon.png" />
	<link href='/css/cache_master.css' rel='stylesheet' type='text/css' />
	<link rel="stylesheet/less" type="text/css" href="/css/styles.less">
	<link rel="stylesheet" href="/admin/Admin_Includes/CodeMirror/lib/codemirror.css"/>
	<script type="text/javascript" src="/admin/Admin_Includes/CodeMirror/lib/codemirror.js"></script>
	<script type="text/javascript" src="/admin/Admin_Includes/CodeMirror/mode/xml/xml.js"></script>
	<script type="text/javascript" src="/admin/Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
	<script type="text/javascript" src="/admin/Admin_Includes/CodeMirror/mode/css/css.js"></script>
	<script type="text/javascript" src="/admin/Admin_Includes/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
	<script type='text/javascript' src='/js/cache_master.js'></script>
 <!--
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'/>
<link href='http://fonts.googleapis.com/css?family=Dynalight' rel='stylesheet' type='text/css'/>
-->
<script type="text/javascript">
var pageId = $id;
</script>	
</head>
<body>
<div id="pageWrapper">\n
HTML;
print compress($header);
}

function printMenu(){
	echo '<div id="pageMenu">';
    include("admin/module_menu_functions.php");
    $menu = renderMenu( 1 );
	echo '</div><div id="pageBody">';
}

function printHeader($title){
$header =<<<HTML
	<div id="pageHeader">
		<h1>$title</h1>
	</div>\n
HTML;
print $header;
printMenu();	
}

function printFooter()
{
$footer =<<<HTML
	<div id="push">&nbsp;</div>
	</div><!-- pageBody-->
</div><!-- pageWrapper-->
<div id="pageFooterWrapper">
<div id="pageFooterBody">
HTML;
if( urlIsPublic() ){
$footer = $footer.<<<HTML
	<p id="footerText">&copy; Brendon Irwin &ndash; 2012 | <g:plusone size="small"></g:plusone> <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a> <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fbrendonirwin.dyndns.org&amp;send=false&amp;layout=standard&amp;width=150&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:24px;" allowTransparency="true"></iframe></p>
HTML;
}
$footer = $footer.<<<HTML
</div>
</div>

</body>
</html>
HTML;
print compress($footer);
writeCache();
}

function writeCache(){
if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
	//dont write the files while logged in
}else{
	$cacheFile= $_SERVER['DOCUMENT_ROOT']."/cache/".curPageURL().".html";
    $fp = fopen($cacheFile, 'w'); 
    fwrite($fp,   ob_get_contents()  ); /*compress()*/
    // close the file
    fclose($fp); 
}
    // Send the output to the browser
    ob_end_flush(); 

}
?>