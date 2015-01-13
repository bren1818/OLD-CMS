<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> Put into HTACCESS-->

	<title>Bren Template Site</title>

	<meta name="author" content="Bren's Template Site" />
	<meta name="description" content="A simple template Site" />
    <meta name="keywords" content="HTML, Javascript, jQuery, CSS, CSS3, less.js" />
    
	<meta property="og:site_name" content="Bren's Website"/> <!-- Website Title -->
	<meta property="og:title" content="Bren's Template Site" /> <!-- Page Title -->
    <meta property="og:type" content="website" /> <!--Type of page -->
    <meta property="og:image" content="theme/touch-icon-iphone4.png" /> <!-- Image shown -->
	
    <meta property="og:url" content="http://bren1818.kicks-ass.net/"/> <!-- canonical link to this page -->
	<link rel="canonical" href="http://bren1818.kicks-ass.net/" /> <!-- canonical link to this page -->
    
    <meta name="revisit-after" content="30 days" /> <!--How often the page should be re-crawled -->
    
	<!-- Mobile -->
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="theme/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="theme/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="theme/touch-icon-iphone4.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="theme/touch-icon-ipad-retina.png" />
	
    <!-- iPod/Phone 320 x 460 image -->
    <link rel="apple-touch-startup-image" href="theme/startup-iPod.jpg"/> 
	<!--iPad Portrait 768 x 1004 -->
    <link rel="apple-touch-startup-image" href="theme/startup-iPad-portrait.jpg" media="(device-width: 768px) and (orientation: portrait)" /> 
	<!--iPad LandScape 1024 x 748--> 
    <link rel="apple-touch-startup-image" href="theme/startup-iPad-landscape.jpg" media="(device-width: 768px) and (orientation: landscape)" /> 
    
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" /> <!--could be default-->
	
	<meta name="HandheldFriendly" content="True" />
	<meta id="Viewport" name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
	
	<!-- End Mobile -->
	
	<!-- CSS -->
	<link href="css/smoothness/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
    <link href="css/cboxStyles/1/colorbox.css" rel="stylesheet"/>
	<!--[if !IE 7]>
        <style type="text/css">
            #wrap {display:table;height:100%}
        </style>
	<![endif]-->

	<!-- End CSS -->
	
	<!-- Scripts -->
	<script src="js/jquery-1.8.3.js">              </script>
	<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="js/modernizr.js">                 </script>
	<script src="js/jquery.colorbox-min.js">       </script>
   
    <link rel="stylesheet" type="text/less" href="css/style.css" /> <!-- This auto includes the styleLib.less must be # 1 -->
   <!-- <link rel="stylesheet" type="text/less" href="css/menuCss.css" /> -->
    
	<script src="js/less-1.3.1.min.js" type="text/javascript"></script>
	<script src="js/blib.js" type="text/javascript"></script>  <!--Bren Scripts --> 
	
    <script type="text/javascript">
		
		
		
		
		$(function(){
			
			// from an input element
var filesToUpload = document.getElementById('files').files;
// from drag-and-drop
function onDrop(e) {
  filesToUpload = e.dataTransfer.files;
  
  	if (!file.type.match(/image.*/)) {
  // this file is not an image.
};

var img = document.createElement("img");
img.src = window.URL.createObjectURL(file);
  
  var img = document.createElement("img");
var reader = new FileReader();  
reader.onload = function(e) {img.src = e.target.result}
reader.readAsDataURL(file);
  
  var ctx = canvas.getContext("2d");
ctx.drawImage(img, 0, 0);
  
  
  
  
  var MAX_WIDTH = 800;
var MAX_HEIGHT = 600;
var width = img.width;
var height = img.height;
 
if (width > height) {
  if (width > MAX_WIDTH) {
    height *= MAX_WIDTH / width;
    width = MAX_WIDTH;
  }
} else {
  if (height > MAX_HEIGHT) {
    width *= MAX_HEIGHT / height;
    height = MAX_HEIGHT;
  }
}
canvas.width = width;
canvas.height = height;
var ctx = canvas.getContext("2d");
ctx.drawImage(img, 0, 0, width, height);
  
  
  
  
  
}
			



		
			
				});
	</script>
	<!-- End Scripts -->
</head>

<body>

   <div class="siteSection" id="siteBody">
            <div class="siteContent">
				<input id="files" type="file" multiple>
            </div>
   </div>
	

</body>
</html>