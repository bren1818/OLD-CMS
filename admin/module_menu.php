<?php
	include("../admin/session.php");
	include("../functions.php");
	error_reporting(0);
	$cachingOn = 0;
	printPageHeader("Manage Menu", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("../admin/adminHeader.php");
?>
	<script type="text/javascript">
		function editMenuItem(menuId, nodeId){
			window.location ="?edit=1&loadMenu=" + menuId + "&nodeId=" + nodeId;
		}
		
		function delMenuItem(menuId, nodeId, name){
			if (confirm("Are you sure you want to Delete: '" + name +"'?")) { 
					window.location ="?delete=1&loadMenu=" + menuId + "&nodeId=" + nodeId;
			}
		}
		
		function addMenuItem(menuId, nodeId){
			$('#AddMenuItem').fadeIn();
			if( $('#UpdateMenuItem').length !=0){
				$('#UpdateMenuItem').fadeOut();
			}
			$('#menu_id').attr('value', menuId);
			$('#node_id').attr('value', nodeId);
		}
	</script>

	<?php
	if( isset($_REQUEST['loadMenu']) && is_int((int)$_REQUEST['loadMenu']) || isset($_POST['loadMenu']) && is_int((int)$_POST['loadMenu'])){
		if( isset($_REQUEST['loadMenu']) ){
			$menuId = $_REQUEST['loadMenu'];
		}else{
			$menuId = $_POST['loadMenu'];
		}
	}else{
		$menuId = ""; //menu not set;
	}
	
	if( $menuId != "" &&  isset($_REQUEST['delete']) && $_REQUEST['delete'] == 1 ){
		if( isset($_REQUEST['nodeId']) && is_int((int)$_REQUEST['nodeId']) ){
			$nodeId = $_REQUEST['nodeId'];
			if( $nodeId != -1 ){	
			recurseDelete($nodeId);
			$query = "DELETE FROM `module_menu_links` WHERE `id` = ".$nodeId;
			$query = mysql_query($query);
			mysql_free_result($query);
				?>
                <script type="text/javascript">
					window.alert("Deletion Successful!");
					window.location = "/admin/module_menu.php?loadMenu=<?php echo $menuId; ?>";
                </script>
                <?php
			}
		}
	}	
	
	if( isset($_POST["submit"]) ){
		foreach($_POST as $key=>$value) {
			$clean[$key]=mysql_real_escape_string($value);
		}
		
		if( $_POST["node_Id"] == -1){
			$_POST["node_Id"] = $menuId;
		}
		
		if( $_POST["link_URL"] == "" ){
			echo "No Link entered";

		}else{
			$query = "INSERT INTO `module_menu_links` (`id`, `menu_id`, `parent_id`, `link_name`, `link_url`, `new_window`, `order`) VALUES (NULL, '".$_POST["menu_Id"]."', '".$_POST["node_Id"]."', '".$_POST["link_name"]."', '".$_POST["link_URL"]."', '".$_POST["link_target"]."', '".$_POST["link_order"]."');";
		}
		$query = mysql_query($query);
		mysql_free_result($query);
	}

if( isset($_POST["update"]) ){
	
	//do checks and insert
	foreach($_POST as $key=>$value) {
			$clean[$key]=mysql_real_escape_string($value);
	}
	
	if( $_POST["node_Id"] == -1){
			$_POST["node_Id"] = $menuId;
		}
		
		if( $_POST["link_URL"] == "" ){
			echo "No Link entered";
		}else{
			$query = "UPDATE `module_menu_links` SET `link_name` = '".$_POST["link_name"]."', `link_url` = '".$_POST["link_URL"]."', `new_window` = '".$_POST["link_target"]."', `order` = '".$_POST["link_order"]."' where `id` =".$_POST["node_Id"];
			$query = mysql_query($query);
			mysql_free_result($query);
		}
}


	//IF NOT ONE
	renderMenu( $menuId );	
	?>
	
	<div class="clear" style="float:left; clear: both; height: 10px"></div>
	<div id="AddMenuItem" style="display: none;">
    <h2>Add Menu Option</h2>
		<form id="add_menu_item" name="add_menu_item" method="POST" style="width:300px;" novalidate>
		
			<div class="row hidden">
				<div class="titleCol">Menu ID:</div>
				<div class="valueCol"><input id="menu_id" type="text" name="menu_Id" value=""/></div>
			</div>	
				
			<div class="row hidden">
				<div class="titleCol">Node ID:</div>
				<div class="valueCol"><input id="node_id" type="text" name="node_Id" value=""/></div>
			</div>

<!--
			<div class="row hidden">
				<div class="titleCol">Resource (optional)</div>
				<div class="valueCol">
					<select name="resourceID">
						<?php/*
							$query = mysql_query("SELECT `page_id`, `page_title` FROM `pages`");
							$num_rows = mysql_num_rows($query);
							if($num_rows > 0 ){
								while($info = mysql_fetch_assoc( $query )){
									echo '<option value="'.$info["page_id"].'">'.$info["page_title"].'</option>';
								}
							}else{
								echo '<option value="-1">No Pages Available</option>';
							}
							mysql_free_result($query);*/
						?>
					</select>
				</div>
			</div>
-->			
			<div class="row">
				<div class="titleCol">URL:</div>
				<div class="valueCol"><input type="text" name="link_URL" value=""/></div>
			</div>
			
			<div class="row">
				<div class="titleCol">Link Name:</div>
				<div class="valueCol"><input type="text" name="link_name" value="" pattern="[a-zA-Z0-9\_ \-\)\(]{3,}"/></div>
			</div>
			
			<div class="row">
				<div class="titleCol">Order:</div>
				<div class="valueCol"><input type="number" name="link_order" value=""/></div>
			</div>
			
			<div class="row">
				<div class="titleCol">Open in:</div>
				<div class="valueCol">
					<select name="link_target">
						<option value="0">Same Window</option>
						<option value="1">New Window</option>
					</select>
				</div>
			</div>
			
			<div class="row center">
				<input name="submit" type="submit" value="Save"/>
			</div>
			<input type="hidden" name="loadMenu" value="<?php echo $menuId; ?>"/>
		</form>
	</div>
	<script type="text/javascript">
		$(function(){
			$("#add_menu_item").validator();
		});
	</script>
    
    <?php
		if( $menuId != "" &&  isset($_REQUEST['edit']) ){
		if( isset($_REQUEST['nodeId']) && is_int((int)$_REQUEST['nodeId']) ){
			$nodeId = $_REQUEST['nodeId'];
			if( $nodeId != -1 ){
				$query = "Select `id`, `link_name`,`parent_id`, `link_url`, `order`, `new_window` from `module_menu_links` where `id` = ".$nodeId;
				$query = mysql_query($query);
				$num_rows = mysql_num_rows($query);
				if($num_rows > 0 ){
					
					while($info = mysql_fetch_assoc( $query ))
					{
						$id = $nodeId;
						$linkName = $info['link_name'];
						$linkUrl = $info['link_url'];
						$order =$info['order'];
						$target =$info['new_window'];
						
					}
				}
				
	?>
    
    <!--------------Update Validator---------->
    <div id="UpdateMenuItem">
    <h2>Update Menu Option</h2>
		<form id="update_menu_item" name="add_menu_item" method="POST" style="width:300px;" novalidate>
		
			<div class="row hidden">
				<div class="titleCol">Menu ID:</div>
				<div class="valueCol"><input id="menu_id" type="text" name="menu_Id" value="<?php echo $menuId; ?>"/></div>
			</div>	
				
			<div class="row hidden">
				<div class="titleCol">Node ID:</div>
				<div class="valueCol"><input id="node_id" type="text" name="node_Id" value="<?php echo $nodeId ?>"/></div>
			</div>

<!--
			<div class="row hidden">
				<div class="titleCol">Resource (optional)</div>
				<div class="valueCol">
					<select name="resourceID">
						<?php/*
							$query = mysql_query("SELECT `page_id`, `page_title` FROM `pages`");
							$num_rows = mysql_num_rows($query);
							if($num_rows > 0 ){
								while($info = mysql_fetch_assoc( $query )){
									echo '<option value="'.$info["page_id"].'">'.$info["page_title"].'</option>';
								}
							}else{
								echo '<option value="-1">No Pages Available</option>';
							}
							mysql_free_result($query);*/
						?>
					</select>
				</div>
			</div>
-->			
			<div class="row">
				<div class="titleCol">URL:</div>
				<div class="valueCol"><input type="text" name="link_URL" value="<?php echo $linkUrl; ?>"/></div>
			</div>
			
			<div class="row">
				<div class="titleCol">Link Name:</div>
				<div class="valueCol"><input type="text" name="link_name" value="<?php echo $linkName; ?>" pattern="[a-zA-Z0-9\_ \-\)\(]{3,}"/></div>
			</div>
			
			<div class="row">
				<div class="titleCol">Order:</div>
				<div class="valueCol"><input type="number" name="link_order" value="<?php echo $order ?>"/></div>
			</div>
			
			<div class="row">
				<div class="titleCol">Open in:</div>
				<div class="valueCol">
					<select name="link_target">
						<option value="0" <?php if($target == 0){ echo 'SELECTED="SELECTED"'; } ?>>Same Window</option>
						<option value="1" <?php if($target == 1){ echo 'SELECTED="SELECTED"'; } ?>>New Window</option>
					</select>
				</div>
			</div>
			
			<div class="row center">
				<input name="update" type="submit" value="update"/>
			</div>
			<input type="hidden" name="loadMenu" value="<?php echo $menuId; ?>"/>
		</form>
	</div>
    <script type="text/javascript">
		$(function(){
			$("#update_menu_item").validator();
		});
	</script>
    <?php
			}
		}
	}
	?>
    

<?php
	printFooter();
?>