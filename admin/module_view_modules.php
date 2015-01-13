<?php
	include("../admin/session.php");
	include("../functions.php");
	error_reporting(0);
	$cachingOn = 0;
	printPageHeader("Page Layout Setup", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("View Modules");
	include("../admin/adminHeader.php");

	echo '<div id="AvailableModules_Page">';
		echo "<h2 style='text-align: center'>Available Modules</h2>";
		//available modules by type
		$moduleTypes = 'SELECT DISTINCT `content_type` FROM  `page_content` ORDER BY `content_type`';
		$moduleTypes = mysql_query($moduleTypes);
		$contentTypes = array();
		if( $moduleTypes && mysql_num_rows($moduleTypes) != 0 )
		{
			echo '<div id="Module_tabs">';
			echo '<ul>';
				$cnt =1;
				while($info = mysql_fetch_assoc( $moduleTypes  ))
				{
					echo '<li><a href="#tabs-'.$cnt.'">'.$info['content_type'].'</a></li>';
					$contentTypes[$cnt -1] = $info['content_type'];
					$cnt++;
				}
			echo '</ul>';
		
			for( $x = 1; $x < $cnt; $x++){ //create each tab
				echo '<div id="tabs-'.$x.'"><ul class="connectedSortable">';
				//existing modules from db, just need to store their id					
				$modules = "";
				
				$modulequery = 'SELECT *  FROM  `page_content` where `content_type` = "'.$contentTypes[$x -1].'" ORDER BY  `last_update`';
				$modulequery = mysql_query($modulequery);
				if( $modulequery && mysql_num_rows($modulequery) != 0 )
				{
					$moduleType = preg_replace( '/\s/', '', $contentTypes[$x -1] );
					$m = 0;
					while($moduleBlock = mysql_fetch_assoc( $modulequery  ))
					{
						
						$modules = $modules.'<li class="ui-state-default module_'.$moduleType.'" id="'.$moduleType."_".$m.'"><div class="container"><div class="icon icon_'.$moduleBlock['content_type'].'"></div><span>'.$moduleBlock['content_Description'].'  | <a href="module_manage_module.php?action=edit&modId='.$moduleBlock['page_content_id'].'">Edit</a> | <a href="module_manage_module.php?action=del&modId='.$moduleBlock['page_content_id'].'">Delete</a></span><div class="moduleId">'.$moduleBlock['page_content_id'].'</div></div></li>';
						$m++;
					}
					
					$modules = $modules.'<li class="ui-state-default module_'.$moduleType.'" id="'.$moduleType."_".$m.'"><div class="container"><div class="icon icon_'.$moduleType.'"></div><span> > <a href="/admin/module_manage_module.php?type='.$moduleType.'&modId=-1&action=new">Add a '.$moduleType.' item</a></span><div class="moduleId">-1</div></div></li>';
					
				}
				echo $modules;
				echo '</div>';
			}
		}
	echo '</div></div>'; //end Module tabs
	?>
     <script type="text/javascript">
		 function closeIframe()
		{
			$('#module_editor').dialog('close');
			$('#module_editor').remove();
			return false;
		}
	 
		$(function() {
			$( "#Module_tabs" ).tabs();
			$('.container a').click(function(event){
				event.preventDefault();
				if( !$('#module_editor').length ){
					$('#pageWrapper').append('<div id="module_editor"><iframe width="700" height="500"></iframe></div>');
				}
				$('#module_editor iframe').attr('src' , $(this).attr('href') );
				$('#module_editor').dialog({modal:false, title : "Edit Module", width: 800, height: 600, show: "blind", hide: "blind" }).bind('dialogclose', function(event){ closeIframe() }); 
			});
			
		});
	</script>
    <style type="text/css">
		#AvailableModules_Page .ui-state-default{
			cursor: default;	
		}
		
		.container span{
			margin: 0px;
			height: 30px;
			line-height: 30px;	
		}
	</style>
    <?php
	printFooter();
?>