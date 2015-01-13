<?php
	error_reporting(0);
	include("userSession.php");
	function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle){
		$length = strlen($needle);
		$start  = $length * -1; //negative
		return (substr($haystack, $start) === $needle);
	}

	$loadPage ="";
	if( isset($_GET['page']) )
	{
		$loadPage = $_GET['page'];
		if($loadPage != "")
		{	
			if( !endsWith($loadPage,".php") )
			{
				$test = $loadPage.".php";
				include("admin/db.php");
				
				if(  file_exists ($test) ){
				
					include($test); //load the normal (existing) file	
				}else{
					//its from the db
					if (!$db){
						die('Could not connect: ' . mysql_error());
					}else{
						mysql_select_db("$dbDatabase", $db) or die ("Couldn't select the database.");
						$result = mysql_query("SELECT * FROM  `pages` WHERE `url_hash` = '".md5($loadPage)."'");
						if(mysql_num_rows($result)==0){
							?>
							<html>
							<head>
							<title>Not Found</title>
							<script type="text/javascript">
								window.location = "/notfound";
							</script>
							</head>
							<body>
								Re-directing...
							</body>
							</html>
							<?php
						}else{
							
							while($info = mysql_fetch_array( $result )){
								$pageTitle = $info['page_title'];
								$metaDescription = $info['page_description'];
								$metaKeywords = $info['page_keywords'];
								$pageId = $info['page_id'];
								$pageUpdateTime = $info['update_creation'];
							}
									
							$fileFromDb = 1;
							include("functions.php");
							include("admin/module_renderer.php");
							
							printPageHeader($pageTitle, $metaDescription, $metaKeywords, $pageId );
							printHeader($pageTitle);

							$nolayout = 0;
							$layout = 1;
															
							$qlayout = "SELECT `layout_id` FROM  `pages_layout` where `page_id` = ".$pageId;
							$qlayout = mysql_query($qlayout);
							if( $qlayout && mysql_num_rows($qlayout) != 0 ){
								while($linfo = mysql_fetch_array( $qlayout )){
									$layout = $linfo['layout_id'];
								}
							}else{
								$nolayout = 1;
							}
							
							if(isset($_SESSION['userId']) ) {
								echo '<div id="AdminTools">';
								?>
                                	<p><a href="/admin/Page_Create.php?load=<?php echo $pageId; ?>">Edit Page Properties</a> 
                                    <!--| <a href="#">Create sub Page</a>-->
                                     | <a href="/admin/Page_layout_setup.php?pageId=<?php echo $pageId; ?>">Change Page Layout</a>
									 | <a href="/admin/Page_Delete.php?delete=<?php echo $pageId; ?>">Delete Page</a>									 
                                     | <a href="/admin/module_view_modules.php">Create Module</a>
                                     | <a href="/admin/adminOptions.php">Admin Backend</a> 
									 | <a id="fileUploader" href="upload/upload.php">Upload Files</a>
                                     | <a href="/admin/session.php?destroy">Logout</a></p>
									 <div id="message" title="" style="display:none"></div>
									 <script type="text/javascript">
									 $(function(){
										 $('a#fileUploader').click(function(event){
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
										
									});
									</script>
                                <?php
								echo '</div>';	
							}
							
							$html = '<div class="page" id="page_one_column"><div id="column1" class="column" style="width: 100%">{column_1}</div></div>';
							$number_of_containers = 1;
							
							$qlayout = "Select `html`, `number_of_containers` from `module_layouts` where `id` = ".$layout;
							$qlayout =  mysql_query( $qlayout );
							if(mysql_num_rows($qlayout)!=0){
								while($linfo = mysql_fetch_array( $qlayout )) {
									$html = $linfo['html'];
									$number_of_containers = $linfo['number_of_containers'];
								}
							}							
							
							//create Arrays of content
							$columnData = array();
							$objData = array();
							for( $x = 0; $x < $number_of_containers; $x++)
							{
								$columnData[$x] = "{column_".($x + 1)."}";
								
								if( $nolayout == 1 ){
									$moduleQuery = 'mysql_query("SELECT * FROM  `page_content` WHERE `content_id` = '.$pageId;
								}else{	
								$moduleQuery = "SELECT t2.`page_content_id`, t2.`page_source`, t2.`content_Description` , t2.`content_type` , t1.`content_id` , t1.`page_id` , t1.`order` 
											FROM  `pages_content_layout` AS t1
											INNER JOIN  `page_content` AS t2 ON t1.`column_id` = t2.`page_content_id` 
											WHERE t1.`page_id` =".$pageId."
											AND t1.`content_id` =".($x + 1)."
											ORDER BY t1.`order`"; 		
								}		

								$moduleQuery = mysql_query($moduleQuery);
								if( $moduleQuery && mysql_num_rows($moduleQuery) != 0)
								{ //successful query
									while($md = mysql_fetch_assoc( $moduleQuery) )
									{
										$objData[$x] = $objData[$x].'<div class="container container_'.$md['content_type'].'" id="container_'.$md['page_content_id'].'">'.renderModule($md['content_type'],$md['page_source']).'</div>';
									}
								}
							}//End $number_of_containers
							
							/****************Do we have more than the number of columns*****/
							
							if( $nolayout != 1 ){
							
								$moduleExtrasQuery = "SELECT t2.`page_content_id`, t2.`page_source`, t2.`content_Description` , t2.`content_type` , t1.`content_id` , t1.`page_id` , t1.`order` 
												FROM  `pages_content_layout` AS t1
												INNER JOIN  `page_content` AS t2 ON t1.`column_id` = t2.`page_content_id` 
												WHERE t1.`page_id` =".$pageId."
												AND t1.`content_id` > ".$number_of_containers."
												ORDER BY t1.`order`"; 
								
								$moduleExtrasQuery = mysql_query($moduleExtrasQuery);
								if( $moduleExtrasQuery && mysql_num_rows($moduleExtrasQuery) != 0 )
								{ //successful query
										while($mEq = mysql_fetch_assoc( $moduleExtrasQuery) )
										{
											$objData[$x] = $objData[$x].'<div class="container container_'.$md['content_type'].'" id="container_'.$md['page_content_id'].'">'.renderModule($md['content_type'],$md['page_source']).'</div>';
										}
								}
							}
								
							/*Fill in the fields with the content!*/
							for( $x = 0; $x < $number_of_containers; $x++){
								$html = str_replace($columnData[$x] , $objData[$x], $html);
							}
							
							echo $html;
							
							printFooter();
						}
					}
					
				}
			}
		}
 	}else{
		$loadPage ="home.php"; //default home page
		include($loadPage);
 	}
?>
