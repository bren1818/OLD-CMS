<?php
	include("session.php");
	error_reporting(0);
	include("../functions.php");
	printPageHeader("Admin Options", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("adminHeader.php");
	include("db.php");
	
	function endswith($string, $test) {
		$strlen = strlen($string);
		$testlen = strlen($test);
		if ($testlen > $strlen) return false;
		return substr_compare(strtolower($string), strtolower($test), -$testlen) === 0;
	}
?>

	<h2>Menu</h2>
	<?php
		echo $_SERVER['HTTP_HOST']."<br/>";
		echo '<a target="_blank" href="backupDb.php">Backup database</a>';
	?>
	
	<br/>
	<br/>
	<h2>Menus</h2>
	<table class="tablesorter">
	<thead>
	<tr>
		<th>Menu Id</th>
		<th>Menu name</th>
		<th>Menu Description</th>
		<th>Menu Orientation</th>
		<th>Last Update</th>
		<th>Admin</th>
	</tr>
	</thead>
	<tbody>
	<?php	
		$query = mysql_query("SELECT * FROM  `module_menu` ORDER BY  `menu_name` ASC");
		$num_rows = mysql_num_rows($query);
		if($num_rows > 0 ){
			while($info = mysql_fetch_assoc( $query ))
			{
				echo "<tr>";
					echo "<td>".$info["id"]."</td>";
					echo "<td>".$info["menu_name"]."</td>";
					echo "<td>".$info["menu_description"]."</td>";
					echo "<td>".$info["menu_orientation"]."</td>";
					echo "<td>".$info["last_update"]."</td>";
					echo "<td><a href='module_menu.php?loadMenu=".$info["id"]."'>Edit</a> | Delete </td>";
				echo "</tr>";
			}
			mysql_free_result($query);
		}
		?>
	</tbody>
	</table>
	
	<h2>Pages</h2>
    <a href="Page_Create.php">Create Page</a><br/>
	<table class="tablesorter">
	<thead>
	<tr>
		<th>Page Title</th>
		<!--<th>Page Id</th>
		<th>Page Parent</th>-->
		<th>Page URL Index</th>
		<th>Last Update</th>
		<th>Page Description</th>
		<th>Page Keywords</th>
		<th>Admin</th>
	</tr>
	</thead>
	<tbody>
		<?php	
			$query = mysql_query("SELECT * FROM  `pages` ORDER BY  `pages`.`page_title` ASC");
			$num_rows = mysql_num_rows($query);
			if($num_rows > 0 ){
				while($info = mysql_fetch_assoc( $query ))
				{
					echo "<tr>";
						echo "<td>".$info["page_title"]."</td>";
						//echo "<td>".$info["page_id"]."</td>";
						//echo "<td>".$info["parent_id"]."</td>";
						echo "<td>/".$info["url_index"]."</td>";
						echo "<td>".$info["update_creation"]."</td>";
						echo "<td>".$info["page_description"]."</td>";
						echo "<td>".$info["page_keywords"]."</td>";
						echo "<td><a href='Page_Create.php?load=".$info["page_id"]."'>Edit</a> | <a href='Page_Delete.php?delete=".$info["page_id"]."'>Delete</a> | <a href='Page_layout_setup.php?pageId=".$info["page_id"]."'>Update Layout</a> | <a href='/".$info["url_index"]."'>View Page</a> </td>"; // | Add Sub Page
					echo "</tr>";
				}
				mysql_free_result($query);
			}
		?>
	</tbody>
	</table>
    
    <h2>Page Layouts</h2>
    <a href="module_layout.php?newLayout=1">Create New Layout</a>
    <table class="tablesorter">
	<thead>
	<tr>
		<th>Layout Title</th>
		<th>Layout Description</th>
		<th width="100">Layout Image</th>
		<th width="100">Admin</th>
	</tr>
	</thead>
	<tbody>
    <?php	
			$query = mysql_query("SELECT * FROM  `module_layouts` ORDER BY  `number_of_containers` ASC");
			$num_rows = mysql_num_rows($query);
			if($num_rows > 0 ){
				while($info = mysql_fetch_assoc( $query ))
				{
					echo "<tr>";
						echo "<td>".$info["name"]."</td>";
						echo "<td>".$info["brief_description"]."</td>";
						echo "<td><img src='".$info["image"]."' height='50' width='50' alt='".$info["image"]."'></td>";
						echo "<td><a href='module_layout.php?loadLayout=".$info["id"]."&edit=".$info["id"]."'>Edit</a> | Delete</td>";
					echo "</tr>";
				}
				mysql_free_result($query);
			}
		?>
	</tbody>
	</table>
    
	
	<h2>Page Modules</h2>
    <a href="module_view_modules.php">View Modules</a>
    <table>
    <tr>
    <td>Add Module of:</td>
    <td>
    	<select id="addType">
        	<?php
				$query = mysql_query("Select `type` from `page_content_types`");
				$num_rows = mysql_num_rows($query);
				if($num_rows > 0 ){
					while($info = mysql_fetch_assoc( $query ))
					{
						echo '<option value="'.$info['type'].'">'.$info['type'].'</option>';	
					}
				}else{
					echo '<option value="-1">Error no Content Types</option>';	
				}
			?>
        </select>
    </td>
    <td>
    	<button id="AddModule">Add Module</button>
    </td>
    </tr>
    </table>
    <script type="text/javascript">
		$(function(){
			$('#AddModule').click(function(event){
				//window.location = "/admin/module_manage_module.php?type=" + $('#addType').val() + "&modId=-1&action=new";
				event.preventDefault();
				if( !$('#module_editor').length ){
					$('#pageWrapper').append('<div id="module_editor"><iframe width="700" height="500"></iframe></div>');
				}
				$('#module_editor iframe').attr('src' , "/admin/module_manage_module.php?type=" + $('#addType').val() + "&modId=-1&action=new" );
				$('#module_editor').dialog({modal:false, title : "Add " + $('#addType').val() + " Module" , width: 800, height: 600, show: "blind", hide: "blind" }).bind('dialogclose', function(event){ closeIframe() }); 
			});
		});

		function closeIframe()
		{
			$('#module_editor').dialog('close').remove();
			return false;
		}
	</script>

	
	<h2>View Files</h2>
	<a id="fileUploader" href="../upload/upload.php">Upload Files - to db</a>
	<a id="fileUploaderhdd" href="../upload/uploadhdd.php">Upload Files - to hdd</a>
    <div id="viewFiles">
	<table id="Files" class="tablesorter">
	<thead>
	<tr>
		<th>File</th>
		<th>Size</th>
		<th>Location / Path</th>
		<th>Admin</th>
	</tr>
	</thead>
	<tbody>
	
	<?php
		function listFiles($dir){
			if (is_dir($dir)) 
			{
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) 
					{
						if( is_file($dir."/".$file) ){
						echo "<tr>";
							echo "<td><a target='_blank' href='../$dir/$file'>$file</a></td>";
							if( (filesize($dir."/".$file) / 1024/ 1024) > 1 ){
								echo "<td>". round((filesize($dir."/".$file) / 1024/ 1024),1)."MB</td><td>HDD | /uploads/".$file." </td><td><a class='deleteFile' href='".urlencode($file)."'>Delete</a></td>";
							}else{
								echo "<td>".round((filesize($dir."/".$file) / 1024),1)."KB</td><td>HDD | /uploads/".$file." </td><td><a class='deleteFile' href='".urlencode($file)."'>Delete</a></td>";
							}
							echo "</tr>";
						}
					}
					closedir($dh);
				}
			}
		}
		listFiles("../uploads");
	
		$query = mysql_query("SELECT `id`, `name`, `size` FROM  `uploaded_files` ORDER BY  `name` ASC");
		$num_rows = mysql_num_rows($query);
		if($num_rows > 0 ){
			while($info = mysql_fetch_assoc( $query ))
			{
				echo '<tr>';
					echo '<td><a href="/upload/getFile.php?id='.$info['id'].'&type=file&name='.$info['name'].'">'.$info['name'].'</a>';
						if(  endswith($info['name'], ".jpg") || endswith($info['name'], ".jpeg") || endswith($info['name'], ".png") || endswith($info['name'], ".gif") ){
							echo ' Thumb: <img src="/upload/getFile.php?id='.$info['id'].'&type=thumb&name='.$info['name'].'" />';
						}
					echo '</td><td>'.$info['size'].'</td><td>DB | /upload/getFile.php?id='.$info['id'].'&type=file&name='.$info['name'].' </td><td>Delete</td>';
				echo '</tr>';
			}
			mysql_free_result($query);
		}
	?>
	</tbody>
	</table>
    </div>
	
	
	<a class='modal_read' href="/userPaths.php">View Logs</a>
	
    <!--<div id="viewLogs">
	<table id="Logs" class="tablesorter">
	<thead>
	<tr>
		<th>File</th>
		<th>Type</th>
		<th>Last Update</th>
		<th>Admin</th>
	</tr>
	</thead>
	<tbody>
	<?php
		function listLogs($dir){
			if (is_dir($dir)) 
			{
				if ($dh = opendir($dir)) {
					while (($file = readdir($dh)) !== false) 
					{
						if( is_file($dir."/".$file) ){
						echo "<tr>";
							echo "<td><a class='modal_read' href='../$dir/$file'>$file</a></td>";
							if( strrpos($file, "Access") === false ){
								echo "<td>Update</td>";
							}else{
								echo "<td>Access</td>";
							}
							echo "<td>".date ("F d Y H:i:s a",filemtime($dir."/".$file))."</td><td><a class='deleteLog' href='$file'>Delete</a></td>";
							
							echo "</tr>";
						}
					}
					closedir($dh);
				}
			}
		}
		//listLogs("../logs");
	?>
	</tbody>
	</table>
    </div>
	-->
	
	<style type="text/css">
		#message{
			font-size: 12px;
			color: #fff;
		}
		
		#message *{
			color: #fff;
		}
	</style>
	
	<div id="message" title="" style="display:none"></div>
	<script type="text/javascript">
		$(function(){
			$('.tablesorter').tablesorter(  ); /*{sortList: [[0,0]]}*/
			$('#Logs').tablesorter({sortList: [[1,0],[0,0]]}); /*{sortList: [[0,0]]}*/
			
			$('a.deleteLog').click(function(event){
				event.preventDefault();
				var href = "Log_Delete.php?Delete=" +  $(this).attr('href') ;
				//console.log(href);
				$('#message').attr('title', 'Deleting ' + $(this).attr('href') );
				
				$('#message').load(href, function(){
					$( "#message" ).dialog({
						height: 100,
						width: 400,
						resizeable : false,
						modal: false
					});
					
				});
				$(this).parent().parent().remove();
			});
			
			$('a.deleteFile').click(function(event){
					event.preventDefault();
					var href = "File_Delete.php?Delete=" + $(this).attr('href');
					console.log(href);
					$('#message').attr('title', 'Deleting ' + $(this).attr('href') );
					
					$('#message').load(href, function(){
						$( "#message" ).dialog({
							height: 100,
							width: 400,
							resizeable : false,
							modal: false
						});
						
					});
					$(this).parent().parent().remove();
			});
				
			$('a#fileUploader, a#fileUploaderhdd').click(function(event){
				event.preventDefault();
				var href = $(this).attr('href');
				$('#message').attr('title', 'Upload Files');
				$('#message').load(href, function(){
					$("#message").dialog({
						height: 350,
						width: 400,
						resizeable : true,
						modal: true
					});
				});
			});
				
			$('a.modal_read').click(function(event){
				event.preventDefault();
				var href = $(this).attr('href');
				$('#message').attr('title', $(this).html());
				$('#message').load(href, function(){
					$( "#message" ).dialog({
						height: 800,
						width: 800,
						resizeable : true,
						modal: true
					});
				});
			});
				
		});
	</script>
<?php
	printFooter();
?>
