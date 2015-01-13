<?php
	include("session.php");
	include("db.php");
	include("../functions.php");
	error_reporting(0);
	$cachingOn = 0;
	printPageHeader("Admin Options", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("adminHeader.php");
	
	if( isset($_POST['delete']) && $_POST['delete'] == 1 || isset($_REQUEST['delete']) && $_REQUEST['delete'] != "")
	{
		$page_id = -1;
		if( isset($_POST['page_id']) ){
			$page_id = (int)$_POST['page_id'];
		}else{
			$page_id = (int)$_REQUEST['delete'];
		}
		
		if( isset($_POST['confirm']) && $_POST['confirm'] == 1){
			$q = mysql_query("Select `page_title` from `pages` where `page_id` = ".$page_id);
			$ptitle = mysql_result($q,0,"page_title");
			
			$dpage =  mysql_query("Delete from `pages` where `page_id` = ".$page_id);
			$lpage =  mysql_query("Delete from `pages_layout` where `page_id` = ".$page_id);
			$lpagec = mysql_query("Delete from `pages_content_layout`  where `page_id` = ".$page_id);
			
			$query = mysql_query("SELECT `content_Description`, `content_type`,	`page_content_id` FROM  `page_content` WHERE `content_id` = ".$page_id);
			$num_rows = mysql_num_rows($query);
			if($num_rows > 0 ){
				while($info = mysql_fetch_assoc( $query ))
				{
					$content_Description = $info['content_Description'];
					$content_type = $info['content_type'];
					$page_content_id = $info['page_content_id'];
					if( isset($_POST['Delete_'.$page_content_id]) && $_POST['Delete_'.$page_content_id] == 1){
						if(  mysql_query("DELETE FROM `page_content` WHERE `page_content`.`page_content_id` = ".$page_content_id) ){
						?>
							<p>Deleted id: <?php echo $page_content_id; ?> (Type: <?php echo $content_type; ?> ) - <?php echo $content_Description; ?></p>
						<?php
						}
					}
				}
			}
			mysql_free_result($query);
			
			if( $dpage && $lpage && $lpagec ){
			?>
            	Deleted: "<?php echo $ptitle; ?>"<br/>
            	<a href="/admin/adminOptions.php">Go Back to admin screen</a>
            <?php
			}
			else{
				echo "<p>An error occured, could not delete: '".$ptitle."'</p>";
				echo '<p><a href="/admin/adminOptions.php">Go Back to admin screen</a></p>';
			}
		}else{
		
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
		?>
		<form name="DeletePage" id="DeletePage_<?php echo $page_id; ?>" method="POST" action="Page_Delete.php">
		<div class="row">
			<span id="message">Are you sure you wish to Delete: "<?php echo preg_replace('/[^a-zA-Z0-9 -]+/', '', $page_title); ?>"?</span>
		</div>
		<input type="hidden" name="page_id" value="<?php echo  $page_id; ?>" disabled="disabled">
		<div class="row">
			<div class="titleCol">
				Page Title:
			</div>
			<div class="valueCol">
				<input type="text" name="page_title" value="<?php echo preg_replace('/[^a-zA-Z0-9 -]+/', '', $page_title); ?>" pattern="[a-zA-Z0-9 -]{5,}" maxlength="55" required="required" disabled="disabled"/>
			</div>
		</div>
		
		<div class="row">
			<div class="titleCol">
				URL Index:
			</div>
			<div class="valueCol">
				<input type="text" name="page_index" value="<?php echo preg_replace('/[^a-z0-9-]+/', '', strtolower($page_index)); ?>" pattern="[a-zA-Z0-9-]{4,}" maxlength="55" required="required" disabled="disabled"/>
			</div>
		</div>
		<div class="row">
			<div class="titleCol">
				Brief Description:
			</div>
			<div class="valueCol">
				<textarea name="page_description" class="" maxlength="255" disabled="disabled"><?php echo  preg_replace('/[^a-zA-Z0-9-, .]+/', '',$page_description); ?></textarea>
			</div>
		</div>

		<div class="row">
			<div class="titleCol">
				Keywords:
			</div>
			<div class="valueCol">
				<textarea name="page_keywords" class="" maxlength="255" disabled="disabled"><?php echo preg_replace('/[^a-zA-Z0-9-, ]+/', '',$page_keywords); ?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="titleCol">
				Also Delete Associated Items?:
			</div>
			<div class="valueCol">
			<table>
			<tr><td>Delete?</td><td>ID</td><td>Type</td><td>Description</td></tr>
				
				<?php
					$query = mysql_query("SELECT `content_Description`, `content_type`,	`page_content_id` FROM  `page_content` WHERE `content_id` = ".$page_id);
					$num_rows = mysql_num_rows($query);
					if($num_rows > 0 ){
						while($info = mysql_fetch_assoc( $query ))
						{
							$content_Description = $info['content_Description'];
							$content_type = $info['content_type'];
							$page_content_id = $info['page_content_id'];
							?>
								<tr><td><input type="checkbox" value="1" name="Delete_<?php echo $page_content_id; ?>" checked="checked"/></td><td><?php echo $page_content_id; ?></td><td><?php echo $content_type; ?></td><td><?php echo $content_Description; ?></td></tr>
							<?php
						}
					}
					mysql_free_result($query);
				?>
			</table>
			</div>
		</div>
		
        <div class="row">
			<input type="submit" value="Yes I am Sure"/>
			<input type="hidden" value="<?php echo $page_id; ?>" name="page_id"/>
			<input type="hidden" value="1" name="confirm"/>
			<input type="hidden" value="1" name="delete"/>
            <a href="/admin/adminOptions.php">Cancel</a>
            <a href="/<?php echo $page_index; ?>">View Page</a>
        </div>
        </form>
<?php
		}
	}
	printFooter();
?>