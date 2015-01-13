<?php
	include("../admin/session.php");
	include("../functions.php");
	error_reporting(0);
	$cachingOn = 0;
	printPageHeader("Page Layout Setup", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
	include("../admin/adminHeader.php");
?>
<?php 
	if( isset($_POST['chooseLayout']) && $_POST['chooseLayout'] ==1  ){
		//echo "Is Post!";
		if( isset($_POST['layout']) && isset($_POST['pageId']) ){
		
			//echo "<p>Updating Page id: (".$_POST['pageId'].") to use layout: (".$_POST['layout'].")</p>";
			
			//remove exsting layout
			$query = "DELETE FROM `pages_layout` WHERE `page_id` = ".$_POST['pageId'];
			$query = mysql_query($query);
			
			//set new one
			$query = "INSERT INTO `pages_layout` (`page_id` ,`layout_id`) VALUES ('".$_POST['pageId']."',  '".$_POST['layout']."');";
			$query = mysql_query($query);
			if( $query ){
				$num_rows = mysql_num_rows($query);
				if($num_rows != 0 ){
					echo "<p>Page Layout setup ok!</p>";
				}
				
				$delPage = "Select `url_index` from `pages` where `page_id` = ".$_POST['pageId'];
				$delPage = mysql_query($delPage);
				if( $delPage && mysql_num_rows($delPage) != 0){
					 while($del = mysql_fetch_assoc( $delPage ))
					{
						$cachedfile = "../cache/".$del['url_index']."_fromDb.php.html";
						//echo $cachedfile;
						deleteFile($cachedfile);
					}
				}
			}
		}else{
			echo "<p>No Layout / page was chosen...</p>";	
		}
	}
	
	
	if( isset( $_REQUEST['pageId']) )
	{
		//do check!
		
		$pageId =  $_REQUEST['pageId'];
		$query = "SELECT `layout_id` FROM  `pages_layout` where `page_id` = ".$pageId;
		$query = mysql_query($query);
		$num_rows = mysql_num_rows($query);
		//$num_rows = 0;
		if($num_rows != 0 ){
			if( $num_rows > 1 ){
				echo "<p>Warning, more than one layout for this page exist in the database. Please contact an administrator...</p>";	
			}
			$theLayout = -1;
			while($info = mysql_fetch_assoc( $query ))
			{
				//echo "This pages uses Layout : ".$info['layout_id'];
				$theLayout = $info['layout_id'];
			}
			
			if( $theLayout != -1){
				//get Layout information
				$query = "SELECT * FROM  `module_layouts` where `id` = ".$theLayout;
				$query = mysql_query($query);
				if( $query && mysql_num_rows($query) != 0 ){
					$layoutid = -1; $name = ""; $number_of_containers = 0; $default_container = 0; $brief_description = ""; $html = "";
					 while($info = mysql_fetch_assoc( $query ))
					{
						$layoutid = $info['id']; 
						$name = $info['name']; 
						$number_of_containers = $info['number_of_containers']; 
						$default_container = $info['default_container'];  
						$brief_description = $info['brief_description']; 
						$html = $info['html']; 
					}

					
					echo "<h2>Current Page Layout</h2>";
					
					echo '<div id="LayoutManager">';
						echo '<div id="pageLayoutArea">';
						
							//create Arrays of content
							$columnData = array();
							$objData = array();
							for( $x = 0; $x < $number_of_containers; $x++)
							{
								$columnData[$x] = "{column_".($x + 1)."}";
								$objData[$x] = '<ul class="connectedSortable">';
							//	$moduleQuery = "SELECT * FROM  `pages_content_layout` WHERE  `page_id` =".$pageId." AND  `content_id` =".($x + 1)." ORDER BY  `order` ";
								$moduleQuery = "SELECT t2.`page_content_id`, t2.`content_Description` , t2.`content_type` , t1.`content_id` , t1.`page_id` , t1.`order` 
											FROM  `pages_content_layout` AS t1
											INNER JOIN  `page_content` AS t2 ON t1.`column_id` = t2.`page_content_id` 
											WHERE t1.`page_id` =".$pageId."
											AND t1.`content_id` =".($x + 1)."
											ORDER BY t1.`order`"; 			

								$moduleQuery = mysql_query($moduleQuery);
								if( $moduleQuery )
								{ //successful query
									while($md = mysql_fetch_assoc( $moduleQuery) )
									{
										$objData[$x] = $objData[$x].'<li class="ui-state-default"><div class="container"><div class="icon icon_'.$md['content_type'].'"></div><span>'.$md['content_Description'].'</span><div class="removeMe">X</div><div class="moduleId">'.$md['page_content_id'].'</div></div></li>';
									}
								}
								$objData[$x] = $objData[$x]."</ul>";
							}//End $number_of_containers
							
							
							
							
							/****************Do we have more than the number of columns*****/
							
							$moduleExtrasQuery = "SELECT t2.`page_content_id`, t2.`content_Description` , t2.`content_type` , t1.`content_id` , t1.`page_id` , t1.`order` 
											FROM  `pages_content_layout` AS t1
											INNER JOIN  `page_content` AS t2 ON t1.`column_id` = t2.`page_content_id` 
											WHERE t1.`page_id` =".$pageId."
											AND t1.`content_id` > ".$number_of_containers."
											ORDER BY t1.`order`"; 
							$moduleExtrasQuery = mysql_query($moduleExtrasQuery);
							if( $moduleExtrasQuery && mysql_num_rows($moduleExtrasQuery) )
							{ //successful query
								$objData[$default_container -1] = substr($objData[$default_container -1],0 , -5);
									while($mEq = mysql_fetch_assoc( $moduleExtrasQuery) )
									{
										$objData[$default_container -1] = $objData[$x -1].'<li class="ui-state-default"><div class="container"><div class="icon icon_'.$mEq['content_type'].'"></div><span>'.$mEq['content_Description'].' - (Moved from Column: '.$mEq['content_id'].')</span><div class="removeMe">X</div><div class="moduleId">'.$mEq['page_content_id'].'</div></div></li>';
									}
								$objData[$default_container -1] = $objData[$default_container -1]."</ul>";
							}
							
							/***************************************************************/
							
							/*Fill in the fields with the content!*/
							for( $x = 0; $x < $number_of_containers; $x++){
								$html = str_replace($columnData[$x] , $objData[$x], $html);
							}
							echo $html;
						
						echo '</div>';
						
						
						echo '<div id="AvailableModules">';
							echo "<h2 style='text-align: center'>Available Modules</h2>";
							//available modules by type
								$moduleTypes = 'SELECT DISTINCT  `content_type` FROM  `page_content` ORDER BY  `content_type`';
								$moduleTypes = mysql_query($moduleTypes);
								$contentTypes = array();
								if( $moduleTypes && mysql_num_rows($moduleTypes) != 0 ){
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
													 if( $modulequery && mysql_num_rows($modulequery) != 0 ){
														 $m = 0;
														while($moduleBlock = mysql_fetch_assoc( $modulequery  ))
														{
															$modules = $modules.'<li class="ui-state-default module_'.preg_replace( '/\s/', '', $contentTypes[$x -1] ).'" id="'.preg_replace( '/\s/', '', $contentTypes[$x -1] )."_".$m.'"><div class="container"><div class="icon icon_'.$moduleBlock['content_type'].'"></div><span>'.$moduleBlock['content_Description'].'</span><div class="removeMe">X</div><div class="tabparent">tabs-'.$x.'</div><div class="moduleId">'.$moduleBlock['page_content_id'].'</div></div></li>';
															$m++;
														}
													 }
													echo $modules;
											echo '</ul></div>';
										}
									echo '</div>'; //end Module tabs
							}
							echo '<div id="layoutTrash">';
								echo '<h4>Deleted modules</h4>';
								echo '<ul class="connectedSortable"></ul>';
							echo '</div>';
							
							
							?>
                            <script type="text/javascript">
							$(function() {
								$( "#Module_tabs" ).tabs();
							});
							</script>
							<?php
						echo '</div>';
						
					echo '</div>';/*End Layout Manager*/
					
					
					$q = mysql_query("Select `url_index` from `pages` where `page_id` = ".$pageId);
					$purl = mysql_result($q,0,"url_index");
					
					
					echo '<div style="clear: both; height: 40px;">
						<div id="saveLayout">Save Layout</div>
					 	<div style="height: 40px; line-height:40px; margin-left: 10px; float: left;">| <a href="/admin/Page_Create.php?load='.$pageId.'">Page properties</a> | <a href="/'.$purl.'">View Page</a></div>
						</div>';
					?>
                    	<script type="text/javascript">
							$(function(){
								/*jQuery has attr function*/
								(function( jQuery ) {
								  jQuery.fn.hasAttr = function( name ) {
									  for ( var i = 0, l = this.length; i < l; i++ ) {
										  if ( !!( this.attr( name ) !== undefined ) ) {
											  return true;
										  }
									  }
									  return false;
								  };
								})( jQuery );
								
								$( ".connectedSortable" ).sortable({
									connectWith: ".connectedSortable",
									placeholder: "ui-state-highlight",
									receive: function(event, ui) { 
									/*
										this refers to where the item is dropped
										ui.item refers to the dropped item
									*/
										if(  $(this).parent().parent().attr('id') == "Module_tabs"){
											if( $(ui.item).hasAttr('id') ){
												/* This is a block from the modules - lets make sure it gets back to the proper spot */
												$(ui.item).detach().appendTo( '#' + $(ui.item).find('.tabparent').html() + ' ul.connectedSortable');
											}else{
												/* this is a pre-existing block! Lets remove this mofo */
												/* $(ui.item).remove();                                */
												$('#layoutTrash').css('visibility', 'visible');
												$(ui.item).detach().appendTo( $('#layoutTrash ul') );
											}
										}
									},
									update: function(event, ui) {
										/*When item is dropped / moved, make sure the close button re-sizes correctly*/
										$(ui.item).find('.removeMe').css({ 'height' : $(ui.item).height() + 'px', 'line-height' : $(ui.item).height() + 'px'  }); /*Fix height of close*/
									}
								}).disableSelection();
								
								$('.removeMe').each(function(){
									$(this).css({ 'height' : $(this).parent().parent().height() + 'px', 'line-height' : $(this).parent().parent().height() + 'px'  });
									$(this).click(function(){
										if( $(this).parent().find('.tabparent').length != 0 ){
											/*find the proper place in the module block list to go back to*/
											var sel = $(this).parent().find('.tabparent').html();
											$(this).parent().parent().detach().appendTo( $('#' + sel).find('ul') );
										}else{
											/* if existing module block, just remove it*/
											/* $(this).parent().parent().remove();     */
											$('#layoutTrash').css('visibility', 'visible');
											$(this).parent().parent().detach().appendTo( $('#layoutTrash ul') );
										}
									});
								});
								
								$('#saveLayout').click(function(){
									var numColumns = <?php echo $number_of_containers; ?>;
									var page = <?php echo $pageId ?>;
									var postString = "";	
									
									$('.column').each(function(index){
										 if( $(this).hasAttr('id') ){
											 if( $(this).find('.connectedSortable li .moduleId').length != 0 )
											 {
												 var columnId = $(this).attr('id').substring( 6, $(this).attr('id').length);
												 var fullId = $(this).attr('id');	 
												 postString = postString + "{";
												 /*Get list of objects in this valid column*/
												 $(this).find( '.connectedSortable li .moduleId').each(function(ind){
													 var moduleId = $(this).html();
													 /*make proper list*/
													 if( ind == $('#' + fullId + ' .connectedSortable li .moduleId').length -1 ){
														 postString = postString + page + " : " + columnId + " : " + moduleId + " : " + ind  ;
													 }else{
														  postString = postString + page + " : " + columnId + " : " + moduleId + " : " + ind + "}{" ; 
													 }
												 });
												 postString = postString + "}";
											 }
										 }else{
											 /*Not valid form of layout*/
										 }
									});
									
									if( postString != ""){
										console.log( "Update layout for page :" + page + ", max columns: " + numColumns + ", Post: " + postString );
										var url = "Page_layout_save.php?page=" + page + "&data=" + postString;
										$.post( url, postString,
										  function( data ) {
											  window.alert(data);
										  });
									}
								});

							});
						</script>
                    <div class="clear" style="clear: both; width: 100%; height: 10px; margin: 10px 0px;"></div>
                    <div style="padding: 10px; border: 1px solid #000; overflow: visible;">
                    <h2>Change Layout</h2>
					<?php
					/***************************************************/
						$layouts = "SELECT `id`, `name`, `image` FROM  `module_layouts` order by `order`";
						$layouts = mysql_query($layouts);
						$num_rows = mysql_num_rows($layouts);
						if($num_rows != 0 ){
					?>
						<form name="setLayout" id="setLayout" method="post" style="margin-top: 10px;">
                        	<table>
                            <tr>
                            <td>
							<?php
                                echo '<dl id="LayoutSelector" class="dropdown">';
                                echo '<dt><a href="#"><span>Please select a layout</span></a></dt>';
                                echo '<dd><ul>';
                                while($linfo = mysql_fetch_assoc( $layouts ))
                                {
									if( $linfo['id'] == $theLayout ){
										echo  '<li><a href="#"><img height="50" width="50" class="layoutImage" src="'.$linfo['image'].'" alt="'.$linfo['name'].'" />'.$linfo['name'].' - (Current Layout)<span class="value">'.$linfo['id'].'</span></a></li>';	
									}else{
                                    	echo  '<li><a href="#"><img height="50" width="50" class="layoutImage" src="'.$linfo['image'].'" alt="'.$linfo['name'].'" />'.$linfo['name'].'<span class="value">'.$linfo['id'].'</span></a></li>';	
									}
                                }
                                echo '</ul></dd>';
                                echo '</dl>';
                            
                            }
                            ?>
                            </td><td>
                            <input type="hidden" name="pageId" value="<?php echo $pageId; ?>"/>
							<input type="hidden" id="result" name="layout" value=""/>
							<input type="hidden" name="chooseLayout" value="1"/>
							<input id="saveNewLayout" type="submit" value="Change Layout" />
                            </td>
                            </tr>
                            </table>
                            </form>
                            <script type="text/javascript">
                            $(function() {
                                $(".dropdown dt a").click(function() {
                                    $(".dropdown dd ul").toggle();
                                });
                                
                                $(".dropdown dd ul li a").click(function() {
                                    var text = $(this).html();
                                    $(".dropdown dt a span").html(text);
                                    $(".dropdown dd ul").hide();
                                    $("#result").html("Selected value is: " + getSelectedValue("LayoutSelector"));
                                });
                                
                                function getSelectedValue(id) {
                                    $('#saveLayout').css({'visibility' : 'visible'});
                                    $('#result').attr('value', $("#" + id).find("dt a span.value").html() );
                                    return $("#" + id).find("dt a span.value").html();
                                    
                                }
                                
                                $(document).bind('click', function(e) {
                                    var $clicked = $(e.target);
                                    if (! $clicked.parents().hasClass("dropdown"))
                                        $(".dropdown dd ul").hide();
                                });
                            });
                            </script>
                        </div>
					<?php
				/***********************************************************/
				}else{
					echo "<p>Error! The Desired Layout could not be found! Update the layout to an existing layout</p>";
				}	
			}
		}else{
			echo "<p><b>This page does not have a layout!</b><br/><br/></p>";
			$query = "SELECT `id`, `name`, `image` FROM  `module_layouts` order by `order`";
			$query = mysql_query($query);
			$num_rows = mysql_num_rows($query);
			if($num_rows != 0 ){
			?>
			<form name="setLayout" id="setLayout" method="post">
			<?php
				echo '<dl id="LayoutSelector" class="dropdown">';
				echo '<dt><a href="#"><span>Please select a layout</span></a></dt>';
				echo '<dd><ul>';
				while($info = mysql_fetch_assoc( $query ))
				{
					echo  '<li><a href="#"><img height="50" width="50" class="layoutImage" src="'.$info['image'].'" alt="'.$info['name'].'" />'.$info['name'].'<span class="value">'.$info['id'].'</span></a></li>';	
				}
				echo '</ul></dd>';
				echo '</dl>';
			}
			?>
			<script type="text/javascript">
			$(function() {
				$(".dropdown dt a").click(function() {
					$(".dropdown dd ul").toggle();
				});
				
				$(".dropdown dd ul li a").click(function() {
					var text = $(this).html();
					$(".dropdown dt a span").html(text);
					$(".dropdown dd ul").hide();
					$("#result").html("Selected value is: " + getSelectedValue("LayoutSelector"));
				});
				
				function getSelectedValue(id) {
					$('#saveLayout').css({'visibility' : 'visible'});
					$('#result').attr('value', $("#" + id).find("dt a span.value").html() );
					return $("#" + id).find("dt a span.value").html();
					
				}
				
				$(document).bind('click', function(e) {
					var $clicked = $(e.target);
					if (! $clicked.parents().hasClass("dropdown"))
						$(".dropdown dd ul").hide();
				});
			});
		</script>
		<input type="hidden" name="pageId" value="<?php echo $pageId; ?>"/>
		<input type="hidden" id="result" name="layout" value=""/>
		<input type="hidden" name="chooseLayout" value="1"/>
		<input style="visibility:hidden;" id="saveLayout" type="submit" value="Save Layout" />
		</form>
		<?php
		}
	}else{
		//page is not set
		echo "</h2>Select Page to Configure</h2>";
		?>
    <table class="tablesorter">
	<thead>
	<tr>
		<th>Page Title</th>
		<th>Page URL Index</th>
		<th>Page Description</th>
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
						echo "<td>/".$info["url_index"]."</td>";
						echo "<td>".$info["page_description"]."</td>";
						echo "<td><a href='Page_layout_setup.php?pageId=".$info["page_id"]."'>Update Layout</a></td>";
					echo "</tr>";
				}
				mysql_free_result($query);
			}
		?>
	</tbody>
	</table>
    <script type="text/javascript">
		$(function(){
			$('.tablesorter').tablesorter(  ); /*{sortList: [[0,0]]}*/    
		});
	</script>
		<?php
	}
?>
<?php
	printFooter();
?>