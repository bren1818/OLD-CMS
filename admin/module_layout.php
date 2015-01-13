<?php
	include("../admin/session.php");
	//error_reporting(0);
	include("../functions.php");
	
	$cachingOn = 0;
	printPageHeader("Admin Options", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("../admin/adminHeader.php");
?>
	
    <script src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
	<script src="Admin_Includes/CodeMirror/mode/xml/xml.js"></script>
    <script src="Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
	<script src="Admin_Includes/CodeMirror/mode/css/css.js"></script>
    <script src="Admin_Includes/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
	<link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css">
    
    <?php
	if( isset($_REQUEST['loadLayout']) && is_int((int)$_REQUEST['loadLayout']) || isset($_POST['loadLayout']) && is_int((int)$_POST['loadLayout'])){
		if( isset($_REQUEST['loadLayout']) ){
			$layoutId = $_REQUEST['loadLayout'];
		}else{
			$layoutId = $_POST['loadLayout'];
		}
	}else{
		$layoutId = ""; //Layout not set;
	}
	
	
	
	if( $layoutId != "" &&  isset($_REQUEST['delete']) && $_REQUEST['delete'] == 1 ){
		//will need to find all layouts and set to a default
		
		//Do you really want to  :
//DELETE FROM `bren_cms`.`module_layouts` WHERE `module_layouts`.`id` = 2
	}	
	
		
	function CleanPOST($data)
	{
		return  mysql_real_escape_string($data);
		//return htmlentities($data, ENT_QUOTES, 'UTF-8');
	}
			
	
	if( isset($_POST["update"]) )
	{
		//do checks and insert
		$_POST = array_map('CleanPOST', $_POST); //clean post data
		$layout_id = $_POST['Layout_Id'];
		$layout_name = $_POST['Layout_name'];
		$layout_number_of_containers = $_POST['Layout_number_of_containers'];
		$layout_default_container = $_POST['Layout_default_container'];
		$layout_brief_description = $_POST['Layout_brief_description'];
		$layout_html = $_POST['layout_custom_html'];
		$layout_image = $_POST['Layout_image'];
		$layout_order = $_POST['layout_order'];
		
		echo "<hr/>";
		echo "Recieved Data: id: '".$layout_id."' name : '".$layout_name."', num containers: '".$layout_number_of_containers."', default container: ".$layout_default_container;
		echo "<br/>Recieved Data: brief desc: '".$layout_brief_description."', image: '".$layout_image."', order: ".$layout_order;
		echo "<br/>Code: <textarea width='100%'>".$layout_html."</textarea>";		
		
		$query = "UPDATE `module_layouts` SET  `name` =  '".$layout_name."',
		`number_of_containers` =  '".$layout_number_of_containers."',
		`default_container` =  '".$layout_default_container."',
		`brief_description` =  '".$layout_brief_description."',
		`html` = '".$layout_html."',
		`image` = '".$layout_image."',
		`order` = '".$layout_order."' WHERE `id` =".$layout_id.";";
		
		echo "<br/>SQL: <textarea width='100%'>".$query."</textarea>";
		
		$query = mysql_query( $query );
		
		if(!$query ){
			echo"Layout Update failed!";
		}else{
			echo"Layout Update Successful!";
		}
		echo "<hr/>";
	}


	if( $layoutId != "" &&  isset($_REQUEST['edit']) )
	{
	
		$query = "SELECT * FROM  `module_layouts`  where `id` = ".$layoutId;
		$query = mysql_query($query);
		$num_rows = mysql_num_rows($query);
		//$num_rows = 0;
		if($num_rows != 0 ){
		
			while($info = mysql_fetch_assoc( $query ))
			{
				$layout_name = $info['name'];
				$layout_number_of_containers = $info['number_of_containers'];
				$layout_default_container = $info['default_container'];
				$layout_brief_description = $info['brief_description'];
				$layout_html = $info['html'];
				$layout_image = $info['image'];
				$layout_order = $info['order'];
			}
		}
				
	?>
    <!--------------Update Validator---------->
    <div id="UpdateLayoutItem">
    <h2>Update Layout Option</h2>
		<form id="update_Layout_item" name="add_Layout_item" method="POST" style="width:300px;" novalidate>
		
			<div class="row hidden">
				<div class="titleCol">Layout ID:</div>
				<div class="valueCol"><input id="Layout_id" type="text" name="Layout_Id" value="<?php echo $layoutId; ?>"/></div>
			</div>	
            
            <div class="row">
                    <div class="titleCol">Image path</div>
                    <div class="valueCol"><input id="Layout_image" type="text" name="Layout_image" value="<?php echo $layout_image; ?>"/>
                    					  <img height="100" width="100" src="<?php echo $layout_image; ?>" />
                    </div>
                </div>	  
            
			<div class="row">
                    <div class="titleCol">Name</div>
                    <div class="valueCol"><input id="Layout_name" type="text" name="Layout_name" value="<?php echo $layout_name; ?>" required="required"/></div>
                </div>	  
                              
                <div class="row">
                    <div class="titleCol">Brief Description</div>
                    <div class="valueCol"><textarea id="Layout_brief_description" type="text" name="Layout_brief_description"><?php echo $layout_brief_description; ?></textarea></div>
                </div>	  
                
                    
                <div class="row">
                 	<div class="titleCol">
                         Html for Layout:
                        </div>
                        <div class="valueCol">
                            <textarea id="layout_custom_html" name="layout_custom_html" class="HTML code"  required="required"><?php echo $layout_html; ?></textarea>
                            <br/><b>Note*</b> Use full comments like: &lt;!-- Comment --&gt; as layout code is compressed<br/>
                          	<br/><b>Example layout:*</b> - Note this style layout is required ( page and column having an id, and using class column.<br/>
                            Column data must be in format: {column_<strong>x</strong>} where x is the column number)<br/<br/>
                            <code>
                           &lt;div class="page" id="page_one_column"><br/>
                           &lt;div id="column1" class="column" style="width: 100%">{column_1} &lt;/div><br/>
                           &lt;/div><br/>
                           </code>
                        </div>
                    </div>

                
                <div class="row">
                    <div class="titleCol">Num Containers:</div>
                    <div class="valueCol"><input type="number" name="Layout_number_of_containers" value="<?php echo $layout_number_of_containers; ?>" required="required"/></div>
                </div>
                
                <div class="row">
                    <div class="titleCol">Default Container:</div>
                    <div class="valueCol"><input type="number" name="Layout_default_container" value="<?php echo $layout_default_container; ?>" required="required"/></div>
                </div>
                
			<div class="row">
				<div class="titleCol">Order:</div>
				<div class="valueCol"><input type="number" name="layout_order" value="<?php echo $layout_order ?>"/></div>
			</div>
			
			
			<div class="row center">
				<input name="update" type="submit" value="update"/>
			</div>
			<input type="hidden" name="loadLayout" value="<?php echo $layoutId; ?>"/>
		</form>
	</div>
    <script type="text/javascript">
		$(function(){
			$("#update_Layout_item").validator();
		});
	</script>
    <script type="text/javascript">
			var html_editor = CodeMirror.fromTextArea(document.getElementById("layout_custom_html"), {
			  mode: "text/html",
			  tabMode: "indent",
			  lineNumbers: true,
			  lineWrapping: false
			});
			
		</script>		
    <?php
	}
	
    
	if( isset($_POST["new"]) && $layoutId == "" )
	{
		//do checks and insert
		$_POST = array_map('CleanPOST', $_POST); //clean post data
		
		//$layout_id = $_POST['Layout_Id'];
		$layout_name = $_POST['Layout_name'];
		$layout_number_of_containers = $_POST['Layout_number_of_containers'];
		$layout_default_container = $_POST['Layout_default_container'];
		$layout_brief_description = $_POST['Layout_brief_description'];
		$layout_html = $_POST['layout_custom_html'];
		$layout_image = $_POST['Layout_image'];
		$layout_order = $_POST['layout_order'];
		
		echo "<hr/>";
		echo "Recieved Data: name : '".$layout_name."', num containers: '".$layout_number_of_containers."', default container: ".$layout_default_container;
		echo "<br/>Recieved Data: brief desc: '".$layout_brief_description."', image: '".$layout_image."', order: ".$layout_order;
		echo "<br/>Code: <textarea width='100%'>".$layout_html."</textarea>";		
		
		$query = "INSERT INTO `module_layouts` (`id`, `name`, `number_of_containers`, `default_container`, `brief_description`, `html`, `image`, `order`) VALUES (NULL, '".$layout_name."', '".$layout_number_of_containers."', '".$layout_default_container."', '".$layout_brief_description."', '".$layout_html."', '".$layout_image."', '".$layout_order."');";
		
		echo "<br/>SQL: <textarea width='100%'>".$query."</textarea>";
		
		$query = mysql_query( $query );
		
		if(!$query ){
			echo"Layout Addition failed!";
		}else{
			echo"Layout Addition Successful!";
			?>
				<script type="text/javascript">
					window.alert("Addition of layout was successful!");
					window.location = "module_layout.php?loadLayout=<?php echo  mysql_insert_id();  ?>&edit=<?php echo  mysql_insert_id();  ?>"; 
				</script>
			<?php
			
		}
		echo "<hr/>";
	}
	
    
    if( $layoutId == "" &&  isset($_REQUEST['newLayout']) )
	{
    ?>
	    <div id="UpdateLayoutItem">
    <h2>New Layout Option</h2>
		<form id="new_Layout_item" name="add_Layout_item" method="POST" style="width:300px;" novalidate>
		
		<!--<div class="row hidden">
				<div class="titleCol">Layout ID:</div>
				<div class="valueCol"><input id="Layout_id" type="text" name="Layout_Id" value="<?php //echo $layoutId; ?>"/></div>
			</div>	
         -->
            <div class="row">
                    <div class="titleCol">Image path</div>
                    <div class="valueCol"><input id="Layout_image" type="text" name="Layout_image" value="<?php //echo $layout_image; ?>"/>
                    					  <!--<img height="100" width="100" src="<?php //echo $layout_image; ?>" />-->
                    </div>
                </div>	  
            
			<div class="row">
                    <div class="titleCol">Name</div>
                    <div class="valueCol"><input id="Layout_name" type="text" name="Layout_name" value="<?php //echo $layout_name; ?>" required="required"/></div>
                </div>	  
                              
                <div class="row">
                    <div class="titleCol">Brief Description</div>
                    <div class="valueCol"><textarea id="Layout_brief_description" type="text" name="Layout_brief_description"><?php //echo $layout_brief_description; ?></textarea></div>
                </div>	  
                    
                <div class="row">
                 	<div class="titleCol">
                         Html for Layout:
                        </div>
                        <div class="valueCol">
                            <textarea id="layout_custom_html" name="layout_custom_html" class="HTML code"  required="required"><?php //echo $layout_html; ?></textarea>
                            <br/><b>Note*</b> Use full comments like: &lt;!-- Comment --&gt; as layout code is compressed<br/>
                          	<br/><b>Example layout:*</b> - Note this style layout is required ( page and column having an id, and using class column.<br/>
                            Column data must be in format: {column_<strong>x</strong>} where x is the column number)<br/<br/>
                            <code>
                           &lt;div class="page" id="page_one_column"><br/>
                           &lt;div id="column1" class="column" style="width: 100%">{column_1} &lt;/div><br/>
                           &lt;/div><br/>
                           </code>
                        </div>
                    </div>

                
                <div class="row">
                    <div class="titleCol">Num Containers:</div>
                    <div class="valueCol"><input type="number" name="Layout_number_of_containers" value="<?php //echo $layout_number_of_containers; ?>" required="required"/></div>
                </div>
                
                <div class="row">
                    <div class="titleCol">Default Container:</div>
                    <div class="valueCol"><input type="number" name="Layout_default_container" value="<?php //echo $layout_default_container; ?>" required="required"/></div>
                </div>
                
			<div class="row">
				<div class="titleCol">Order:</div>
				<div class="valueCol"><input type="number" name="layout_order" value="<?php //echo $layout_order ?>"/></div>
			</div>
			
			
			<div class="row center">
				<input name="new" type="submit" value="Save"/>
			</div>
			<!--<input type="hidden" name="loadLayout" value="<?php //echo $layoutId; ?>"/> -->
		</form>
	</div>
    <script type="text/javascript">
		$(function(){
			$("#new_Layout_item").validator();
		});

		var html_editor = CodeMirror.fromTextArea(document.getElementById("layout_custom_html"), {
		  mode: "text/html",
		  tabMode: "indent",
		  lineNumbers: true,
		  lineWrapping: false
		});
			
		</script>		
	<?php
	}
    ?>
    
<?php
	printFooter();
?>