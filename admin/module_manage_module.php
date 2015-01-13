<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	include("../admin/session.php");
	include("../functions.php");
	$module = "";
	$action = "";
	if( isset($_REQUEST['modId']) && isset($_REQUEST['action']) ){
		$module = $_REQUEST['modId'];
		$action = $_REQUEST['action'];
	}
	else{
		$module = -1;
		$action = -1;	
	}

	if( isset($_POST['update']) || isset($_POST['new']) && isset($_POST['type'] ) ){
		$action = "";
		$id = -1;
		$type = $_POST['type'];
		
		if( isset($_POST['update'])){
			$action = "update";
			$id = $_POST['id'];
			$query = "UPDATE `page_content` SET  `page_source` = '".mysql_real_escape_string($_POST['module_content'])."', `content_Description` = '".mysql_real_escape_string($_POST['content_description'])."', `last_update` =  '".date("Y-m-d H:i:s")."' WHERE `page_content_id` =".$id.";";
			$query = mysql_query($query);
		}else{
			$action = "new";
			$query = "INSERT INTO `page_content` (
`page_content_id` ,
`content_id` ,
`content_Description` ,
`content_type` ,
`page_source` ,
`last_update`
)
VALUES (
'0',  '0',  '".mysql_real_escape_string($_POST['content_description'])."',  '".$type."',  '".mysql_real_escape_string($_POST['module_content'])."', 
CURRENT_TIMESTAMP
);
";
$query = mysql_query($query);
$id = mysql_insert_id();
		}
		echo "<p>Saved!</p>";
		$module = $id;
		$action = "edit";	
	
	}

	if( $module == -1 && $action == -1){
		//echo "<p class='error'>No Class or Action was specified</p>";
	}else{
		renderModule($module, $action);
	}

	function renderModule($id, $action){
		if( $id != -1){	
			$type = "";
			$query = "Select `content_type` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$type = mysql_result($query,0,"content_type");
			//get the Module Information
			if( $action == "edit"){
				doEdit($id, $type);	
			}
			
			if( $action == "del"){
				doDelete($id);
			}
			
		}else{	
			if( $action == "new" && isset($_REQUEST['type']) ){
				newModule( $_REQUEST['type'] );
			}	
		}
	}
	

	function newModule($type){
		doEdit( -1, $type );
	}
	
	function doEdit($id, $type){
		?>
        <script type='text/javascript' src='/js/cache_master.js'></script>
        <?php
		echo '<form name="UpdateModule" method="post" action="module_manage_module.php">';
			switch($type){
				case "text":
					renderText($id);
					break;
				case "css":
					renderCSS($id);
					break;
				case "js":
					renderJS($id);
					break;
				case "code":
					renderCode($id);
					break;
				case "html":
					renderHTML($id);
					break;
			}
			$parent = 1;
			if( isset($_REQUEST['parent']) ){
				$parent = $_REQUEST['parent'];
			}
		?>

            <input type="hidden" name="parent" value="<?php echo $parent; ?>"/>
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <input type="hidden" name="type" value="<?php echo $type; ?>"/>
            <?php if( $id == -1){ ?>
                <input type="hidden" name="new" value="1"/>
            <?php }else{ ?>
                <input type="hidden" name="update" value="1"/>
            <?php } ?>
            <input type="submit" name="submit" value="Save"/>
            <!--<a href="/admin/module_view_modules.php">Go back to Modules</a>-->
            <a onclick="window.parent.closeIframe();" href="#">Close</a>
            <a href="/admin/module_manage_module.php?action=del&modId=<?php echo $id; ?>">Delete Module</a>
        <?php
		echo "</form>";		
	}

	function doDelete($id){
		if( isset($_REQUEST['confirm']) ){
			if( $_REQUEST['confirm'] == 1){
				$query = "DELETE FROM `page_content` WHERE `page_content_id` = ".$id;
				//echo $query;
				$modulequery = mysql_query($query);
				
				if( $modulequery  )
				{
					?>
                    	<p>Deletion Completed Successfully.</p> 
					<?php
				}else{
					?>
                    	<p>Deletion Failed (or an error occurred).</p>
                    <?php
				}
				?>
					<p><a href="/admin/adminOptions.php">Go Back</a></p>
				<?php
			}
		}else{
			$query = "Select `content_type`, `content_Description` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$type = mysql_result($query,0,"content_type");
			$desc = mysql_result($query,0, "content_Description");		
			//delete the module
			echo "<p>Are you sure you wish to delete the ".$type." module (".$desc.") from the database?</p>";
			?>
				<a href="/admin/module_manage_module.php?action=del&modId=<?php echo $id; ?>&confirm=1">Confirm Delete</a>
				<a href="/admin/adminOptions.php">Cancel</a>
			<?php
		}
	}
	
	function renderText($id){
		//echo "Render Text!";
		if( $id == -1){
				//new else fetch value
		}else{
			$query = "Select `page_source`, `content_Description` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$data = mysql_result($query,0,"page_source");
			$cd = mysql_result($query,0,"content_Description");
		}
		?>
        Description:<br/> <textarea name="content_description"><?php if( isset($cd) ){ echo $cd; } ?></textarea><br/>Content:<br/>
        <textarea name="module_content" class="tinymce"><?php if( isset($data) ){ echo $data; } ?></textarea>
        
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
        <?php
	}//end renderText
	
	function renderCSS($id){
		//echo "Render CSS!";
		if( $id == -1){
				//new else fetch value
		}else{
			$query = "Select `page_source`, `content_Description` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$data = mysql_result($query,0,"page_source");
			$cd = mysql_result($query,0,"content_Description");
		}
		?>
        Description:<br/> <textarea name="content_description"><?php if( isset($cd) ){ echo $cd; } ?></textarea><br/>Content:<br/>
        <textarea id="page_custom_css" name="module_content" class="CSS code"><?php if( isset($data) ){ echo $data; } ?></textarea>
        
        <p><br/>Do not include &lt;style&gt; tags. If commenting use /* */ as source will be compressed!)</p>
        <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
        <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/css/css.js"></script>
        <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/util/searchcursor.js"></script>
    	<script type="text/javascript" src="Admin_Includes/CodeMirror/lib/util/match-highlighter.js"></script>
		<link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css"/>
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
        <?php
		
	}//end renderCSS
	
	function renderJS($id){
		//echo "Render JS!";
		if( $id == -1){
				//new else fetch value
		}else{
			$query = "Select `page_source`, `content_Description` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$data = mysql_result($query,0,"page_source");
			$cd = mysql_result($query,0,"content_Description");
		}
		?>
        Description:<br/> <textarea name="content_description"><?php if( isset($cd) ){ echo $cd; } ?></textarea><br/>Content:<br/>
        <textarea id="page_custom_js" name="module_content" class="JS code"><?php if( isset($data) ){ echo $data; } ?></textarea>
        
        <p><br/>(jQuery is included, do not include &lt;script&gt; tags. If commenting use /* */ as source will be compressed!)</p>
        <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
        <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
        <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/util/searchcursor.js"></script>
    	<script type="text/javascript" src="Admin_Includes/CodeMirror/lib/util/match-highlighter.js"></script>
		<link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css"/>
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
	}//end renderJS


	function renderCode($id){
		if( $id == -1){
				//new else fetch value
		}else{
			$query = "Select `page_source`, `content_Description` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$data = mysql_result($query,0,"page_source");
			$cd = mysql_result($query,0,"content_Description");
		}
		?>
		 <link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css"/>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/xml/xml.js"></script>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
		 <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/css/css.js"></script>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>

		
        Description:<br/> <textarea name="content_description"><?php if( isset($cd) ){ echo $cd; } ?></textarea><br/>Content:<br/>
        <textarea id="page_custom_html" name="module_content" class="CODE_Block code"><?php if( isset($data) ){ echo $data; } ?></textarea><br/>
         <script type="text/javascript">
      		var html_editor = CodeMirror.fromTextArea(document.getElementById("page_custom_html"), {
			  mode: "text/html",
			  tabMode: "indent",
			  lineNumbers: true,
			  lineWrapping: false
			});

    	</script>      
        <?php
	}

	function renderHTML($id){
		if( $id == -1){
				//new else fetch value
		}else{
			$query = "Select `page_source`, `content_Description` from `page_content` where `page_content_id` = ".$id;
			$query = mysql_query($query);
			$data = mysql_result($query,0,"page_source");
			$cd = mysql_result($query,0,"content_Description");
		}
		?>
		 <link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css"/>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/xml/xml.js"></script>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
		 <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/css/css.js"></script>
         <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>

		
        Description:<br/> <textarea name="content_description"><?php if( isset($cd) ){ echo $cd; } ?></textarea><br/>Content:<br/>
        <textarea id="page_custom_html" name="module_content" class="HTML_Block code"><?php if( isset($data) ){ echo $data; } ?></textarea><br/>
         <script type="text/javascript">
      		var html_editor = CodeMirror.fromTextArea(document.getElementById("page_custom_html"), {
			  mode: "text/html",
			  tabMode: "indent",
			  lineNumbers: true,
			  lineWrapping: false
			});

    	</script>      
        <?php
	}
?>