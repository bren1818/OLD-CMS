<?php
	include("session.php");
	include("db.php");
	include("../functions.php");
	error_reporting(0);
	$cachingOn = 0;
	printPageHeader("Admin Options", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("adminHeader.php");
?>
	<!--Code Mirror -->
    <script src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
	<script src="Admin_Includes/CodeMirror/mode/clike/clike.js"></script>
	<script src="Admin_Includes/CodeMirror/mode/css/css.js"></script>
	<script src="Admin_Includes/CodeMirror/mode/php/php.js"></script>
	<script src="Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
	<script src="Admin_Includes/CodeMirror/lib/util/searchcursor.js"></script>
    <script src="Admin_Includes/CodeMirror/lib/util/match-highlighter.js"></script>
	<link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css">
	<!--TinyMCE-->
	<script type="text/javascript" src="/admin/Admin_Includes/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
	<script type="text/javascript">
		$(function(){
			$('textarea.tinymce').tinymce({
			
			// Location of TinyMCE script
			script_url : '/admin/Admin_Includes/tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfullformatselect,fontselect,fontsizeselect,styleselect", //save,newdocument,|,,
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "/css/cache_master.css",
		});
	});
	</script>
	
	<script type="text/javascript">
		//call validator
		$(function(){
			$("#page_create_form").validator();
		});
	</script>
	
	<style type="text/css">

	</style>
	
	
	<?php
	if( isset($_REQUEST['load']) && $_REQUEST['load'] > 0 ){
		$page_id = (int)$_REQUEST['load'];
		//echo "load the Page";
		$query = mysql_query("SELECT * FROM  `pages` WHERE `page_id` = ".$page_id." LIMIT 1");
		$num_rows = mysql_num_rows($query);
		if($num_rows > 0 ){
			while($info = mysql_fetch_assoc( $query ))
			{
				$page_title = $info['page_title'];
				$page_index = $info['url_index'];
				$page_hash = md5($info['url_index']);
				$page_parent = $info['parent_Id'];
				$page_description = $info['page_description'];
				$page_keywords = $info['page_keywords'];
			}
			
		}
		mysql_free_result($query);
	}
	
	if( isset($_POST['submit']) )
	{
		$page_id = $_POST['page_id'];
		$page_title= $_POST['page_title'];
		$page_index = $_POST['page_index'];
		$page_hash = md5($_POST['page_index']);
		$page_parent = $_POST['page_parent'];
		$page_description = $_POST['page_description'];
		$page_keywords = $_POST['page_keywords'];
		$page_content = $_POST['page_content'];
		$page_custom_css = $_POST['page_custom_css'];
		$page_custom_js = $_POST['page_custom_js'];
		$page_parent =  $_POST['page_parent'];
		
		$err = "";		
		if( $page_title == ""){ $err = "Page title cannot be blank<br/>"; }
		if( $page_index == ""){ $err = $err."Page Index must not be blank<br/>"; }
		if( preg_match("/[^a-zA-Z0-9 -]+/", $page_title) ){ $err =  $err."Invalid characters in page title (they have been removed)<br/>"; }
		if( preg_match("/[^a-z0-9-]+/", $page_index) ){ $err =  $err."Invalid characters in url index (they have been removed)<br/>"; }
		if( strlen($page_title) > 55 ){  $err =  $err."Page Title too long. Please keep it under 55 characters<br/>"; }
		if( strlen($page_title) > 55 ){  $err =  $err."Page Title too long. Please keep it under 55 characters<br/>"; }
		if( strlen($page_index) > 55||  strlen($page_index) < 4 ){  $err =  $err."Page Index needs to be between 4 and 55 characters long<br/>"; }
		
		if( preg_match("/[^a-zA-Z0-9-, ]+/", $page_keywords) ){ $err =  $err."Invalid characters in page keywords (they have been removed)<br/>"; }
		if( preg_match("/[^a-zA-Z0-9-, .]+/", $page_description) ){ $err =  $err."Invalid characters in page description (they have been removed)<br/>"; }
		
		if( strlen($page_keywords) > 255 ){  $err =  $err."Page Keywords too long. Please keep it under 255 characters<br/>"; }
		if( strlen($page_description) > 255 ){  $err =  $err."Page Description too long. Please keep it under 255 characters<br/>"; }
		
		if( $err == "")
		{
			if( $page_id != "" ){
				//echo "Do Update!";
				$query = mysql_query("UPDATE `pages` SET  `parent_id` =  '".$page_parent."',`url_hash` =  '".mysql_real_escape_string($page_hash)."', `url_index` =  '".mysql_real_escape_string($page_index)."', `page_title` =  '".mysql_real_escape_string($page_title)."', `page_description` =  '".mysql_real_escape_string($page_description)."',`page_keywords` =  '".mysql_real_escape_string($page_keywords)."', `update_creation` = '".date("Y-m-d H:i:s")."' WHERE  `pages`.`page_id` = ".$page_id);
				mysql_free_result($query);
				
				//delete the cache
				$cachedfile = "../cache/".$page_index."_fromDb.php.html";
				//echo $cachedfile;
				
				deleteFile($cachedfile);
				
				//header('Location: adminOptions.php?PageEditOK=1');
			}else{
		
				$query = mysql_query("INSERT INTO `pages` (`page_id`, `parent_id`, `url_hash`, `url_index`, `update_creation`, `page_title`, `page_description`, `page_keywords`) VALUES (NULL, '0', '".$page_hash."', '".mysql_real_escape_string($page_index)."', CURRENT_TIMESTAMP, '".mysql_real_escape_string($page_title)."', '".mysql_real_escape_string($page_description)."', '".mysql_real_escape_string($page_keywords)."');");
				$newPageId = mysql_insert_id();
				$query = mysql_query("INSERT INTO `pages_layout` (`page_id`, `layout_id`) VALUES ('".$newPageId."', '1');");
				
				
				if( $newPageId != "" ){
					$query = mysql_query("INSERT INTO `page_content` (`page_content_id`, `content_id`, `content_type`, `content_Description`, `page_source`, `last_update`) VALUES (NULL, '".$newPageId."', 'text', '".mysql_real_escape_string($page_title)." text', '".mysql_real_escape_string($page_content)."', CURRENT_TIMESTAMP);");
					$contentId = mysql_insert_id();
					
					$query = mysql_query("INSERT INTO  `pages_content_layout` (`page_id` ,`content_id` ,`column_id` ,`order`)VALUES ('".$newPageId."',  '1',  '".$contentId."',  '2');");
					
					//$query = mysql_query("INSERT INTO `pages_layout` (`page_id`, `content_id`, `column_id`, `order`) VALUES (".$newPageId.",1,".$contentId.",2);");
					
					if( $page_custom_css != ""){
						$query = mysql_query("INSERT INTO `page_content` (`page_content_id`, `content_id`, `content_type`, `content_Description`, `page_source`, `last_update`) VALUES (NULL, '".$newPageId."', 'css', '".mysql_real_escape_string($page_title)." css', '".mysql_real_escape_string($page_custom_css)."', CURRENT_TIMESTAMP);");
						$contentId = mysql_insert_id();
						//$query = mysql_query("INSERT INTO `pages_layout` (`page_id`, `content_id`, `column_id`, `order`) VALUES (".$newPageId.",1,".$contentId.",0);");
						$query = mysql_query("INSERT INTO  `pages_content_layout` (`page_id` ,`content_id` ,`column_id` ,`order`)VALUES ('".$newPageId."',  '1',  '".$contentId."',  '0');");
					}
					if( $page_custom_js != ""){
						$query = mysql_query("INSERT INTO `page_content` (`page_content_id`, `content_id`, `content_type`, `content_Description`, `page_source`, `last_update`) VALUES (NULL, '".$newPageId."', 'js', '".mysql_real_escape_string($page_title)." js', '".mysql_real_escape_string($page_custom_js)."', CURRENT_TIMESTAMP);");
						$contentId = mysql_insert_id();
						//$query = mysql_query("INSERT INTO `pages_layout` (`page_id`, `content_id`, `column_id`, `order`) VALUES (".$newPageId.",1,".$contentId.",1);");
						$query = mysql_query("INSERT INTO  `pages_content_layout` (`page_id` ,`content_id` ,`column_id` ,`order`)VALUES ('".$newPageId."',  '1',  '".$contentId."',  '1');");
						
					}
				}
				mysql_free_result($query);
				header('Location: adminOptions.php?PageCreatedOK=1');
			}
			$err= "<span style='color: #00ff00;'>No Errors!</span>";
		}
	}
	?>

	<h1>Page Creator</h1>
	<form id="page_create_form" class="inputForm" method="post" name="page_Form" action="/admin/Page_Create.php"  novalidate> <!--onsubmit="return validateForm()"-->
		<div class="row">
			<span id="message"><?php echo $err; ?></span>
		</div>
		<input type="hidden" name="page_id" value="<?php echo  $page_id; ?>">
		<div class="row">
			<div class="titleCol">
				Page Title:
			</div>
			<div class="valueCol">
				<input type="text" name="page_title" value="<?php echo preg_replace('/[^a-zA-Z0-9 -]+/', '', $page_title); ?>" pattern="[a-zA-Z0-9 -]{5,}" maxlength="55" required="required"/>
			</div>
		</div>
		
		<div class="row">
			<div class="titleCol">
				URL Index:
			</div>
			<div class="valueCol">
				<input type="text" name="page_index" value="<?php echo preg_replace('/[^a-z0-9-]+/', '', strtolower($page_index)); ?>" pattern="[a-zA-Z0-9-]{4,}" maxlength="55" required="required"/><br/>Do not include /
			</div>
		</div>
		<!--
		<div class="row">
			<div class="titleCol">
				Page Parent:
			</div>
			<div class="valueCol">
				<select name="page_parent">
					<option value="0">Root</option>
					<?php
						//to do
					?>
				</select>
			</div>
		</div>
	 	-->
		<div class="row">
			<div class="titleCol">
				Brief Description:
			</div>
			<div class="valueCol">
				<textarea name="page_description" class="" maxlength="255"><?php echo  preg_replace('/[^a-zA-Z0-9-, .]+/', '',$page_description); ?></textarea>
			</div>
		</div>

		<div class="row">
			<div class="titleCol">
				Keywords:
			</div>
			<div class="valueCol">
				<textarea name="page_keywords" class="" maxlength="255"><?php echo preg_replace('/[^a-zA-Z0-9-, ]+/', '',$page_keywords); ?></textarea>(comma delimited)<br/><br/>
			</div>
		</div>
		<?php
		if( $page_id == ""){
		?>
		<div class="row">
			<div class="titleCol">
				Page Content:
			</div>
			<div class="valueCol">
				<textarea name="page_content" class="tinymce"><?php echo $page_content; ?></textarea><br/>
			</div>
		</div>
		
				<div class="row">
			<div class="titleCol">
				Custom CSS:
			</div>
			<div class="valueCol">
				<textarea id="page_custom_css" name="page_custom_css" class="CSS code"><?php echo $page_custom_css; ?></textarea>(do not include &lt;style&gt; tags. If commenting use /* */ as source will be compressed!)<br/><br/>
			</div>
		</div>
		
		<div class="row">
			<div class="titleCol">
				Custom JS:
			</div>
			<div class="valueCol">
				<textarea id="page_custom_js" name="page_custom_js" class="JS code"><?php echo $page_custom_js; ?></textarea>(jQuery is included, do not include &lt;script&gt; tags. If commenting use /* */ as source will be compressed!)<br/>
			</div>
		</div>
		
		<script type="text/javascript">
			var css_editor = CodeMirror.fromTextArea(document.getElementById("page_custom_css"), {
			  mode: "text/css",
			  lineNumbers: true,
			  lineWrapping: true,
			  onCursorActivity: function() {
				css_editor.setLineClass(hlLine, null);
				hlLine = css_editor.setLineClass(css_editor.getCursor().line, "activeline");
				css_editor.matchHighlight("CodeMirror-matchhighlight");
			  }
			});
			var hlLine = css_editor.setLineClass(0, "activeline");
		</script>

		<script type="text/javascript">
			var js_editor = CodeMirror.fromTextArea(document.getElementById("page_custom_js"), {
			  mode: "text/javascript",
			  lineNumbers: true,
			  lineWrapping: true,
			  onCursorActivity: function() {
				js_editor.setLineClass(jshlLine, null);
				jshlLine = js_editor.setLineClass(js_editor.getCursor().line, "activeline");
				js_editor.matchHighlight("CodeMirror-matchhighlight");
			  }
			});
			var jshlLine = js_editor.setLineClass(0, "activeline");
		</script>		
		<?php
			}
		?>
		<div class="row center">
			<input name="submit" type="submit" value="Save"/>
			<?php
			if( $page_id != "" ){
				echo "<a href='adminOptions.php'>Go Back to admin screen</a> | ";
				echo "<a href='Page_layout_setup.php?pageId=".$page_id."'>Change Layout</a> | ";
				echo "<a href='/admin/Page_Delete.php?delete=".$page_id."'>Delete Page</a> | ";
				echo "<a href='/".$page_index."'>View Page</a>";
			}
			?>
		</div>
	</form>
	
	<?php
	printFooter();
?>