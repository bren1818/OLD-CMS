<?php
function recurseDelete($id){
	$query = "SELECT  `id` FROM  `module_menu_links` WHERE `parent_id` = ".$id;
	
	$res = mysql_query($query);
	while($info = mysql_fetch_assoc( $res ) )
	{
		$delete =  $info['id'];
		 recurseDelete( $delete ); 
	}
	
	$query = "DELETE FROM `module_menu_links` WHERE `parent_id` = ".$id;
	$query = mysql_query($query);
	//mysql_free_result($query);	
}

function renderAddItem($depth, $menuParent, $node, $name, $rootMenu){
	if(isset($_SESSION['userId']) && isset($_REQUEST['loadMenu']) ) {
		
		if( $depth == 0){
			$menuType = "menu_item";
		}else{
			$menuType = "menu_submenu_item";
		}
		echo '<li class="'.$menuType.' tier_'.$depth.' menu_Add"><a class="adminAdd '.$menuType.'" href="javascript:addMenuItem('.$rootMenu.','.$node.')">Add Item ('.$name.')</a></li>';
		if( $depth != 0){
			echo '<li class="'.$menuType.' tier_'.$depth.' menu_Add"><a class="adminEdit '.$menuType.'" href="javascript:editMenuItem('.$rootMenu.','.$node.')">Edit ('.$name.')</a></li>';
			echo '<li class="'.$menuType.' tier_'.$depth.' menu_Add"><a class="adminDelete '.$menuType.'" href="javascript:delMenuItem('.$rootMenu.','.$node.',\''.$name.'\')">Delete ('.$name.')</a></li>';
		}
	}
}

function renderUl( $parent_id, $depth, $name, $rootMenu){
	$query = mysql_query("SELECT * FROM `module_menu_links` WHERE `menu_id` =".$rootMenu." and `parent_id` =".$parent_id." order by `order`");
	$num_rows = mysql_num_rows($query);
	if($num_rows > 0 ){
		echo '<ul class="menu_submenu tier'.$depth.'">';
		while($info = mysql_fetch_assoc( $query ))
		{
			renderLi($info["id"], $info["parent_id"], $info["link_name"], $info["link_url"], $info["new_window"], $depth, $rootMenu);
		}
		if(isset($_SESSION['userId']) && isset($_REQUEST['loadMenu']) ) {
			renderAddItem($depth, $menu_id, $parent_id, $name , $rootMenu );
		}
		echo '</ul>';
	}else{
		if(isset($_SESSION['userId']) && isset($_REQUEST['loadMenu']) ) {
			echo '<ul class="menu_submenu tier'.$depth.'">';
			renderAddItem($depth, $menu_id, $parent_id, $name, $rootMenu);
			echo '</ul>';
		}
	}
	mysql_free_result($query);
}

function renderLi($id, $parent, $link_name, $url, $target, $depth, $rootMenu){
	$menuType = "";
	if( $depth == 0){
		$menuType = "menu_item";
	}else{
		$menuType = "menu_submenu_item";
	}
	
	if( $target == 0 ){
		$li = '<li class="'.$menuType.' tier_'.$depth.' menu_'.$id.'"><a class="'.$menuType.'" href="'.$url.'">'.$link_name.'</a>';
	}else{
		$li = '<li class="'.$menuType.' tier_'.$depth.' menu_'.$id.'"><a target="_blank" class="'.$menuType.'" href="'.$url.'">'.$link_name.'</a>';
	}
	echo $li;
	
	if( $depth == 0 && isset($_SESSION['userId'])  && isset($_REQUEST['loadMenu']) ){
		echo '<ul class="menu_submenu tier'.$depth.'">';
		$depth++;
		renderAddItem($depth, $parent, $id, $link_name, $rootMenu);
		echo '</ul>';
	}
	
	if( $parent != $id){ //prevent infinite recursion!
		$depth++;
		renderUl( $id, $depth, $link_name, $rootMenu);
	}
	
	echo '</li>';
}

function renderMenu( $menuId ){
	$query = mysql_query("SELECT * FROM `module_menu` WHERE `id` =".$menuId);
	$num_rows = mysql_num_rows($query);
	if($num_rows > 0 ){
		$info = mysql_fetch_assoc( $query );
		if( $info["menu_orientation"] == 1){
			echo '<ul class="menu_parent menu_horizontal menu_submenu_top">';
		}else{
			echo '<ul class="menu_parent menu_vertical menu_submenu_top">';
		}
			$query = mysql_query("SELECT * FROM `module_menu_links` WHERE `menu_id` =".$menuId." and `parent_id` =".$menuId." order by `order`");
			$num_rows = mysql_num_rows($query);
			if($num_rows > 0 ){
				while($info = mysql_fetch_assoc( $query ))
				{
					renderLi($info["id"], $info["parent_id"], $info["link_name"], $info["link_url"], $info["new_window"], 0, $menuId);
				}
			}
			if(isset($_SESSION['userId']) && isset($_REQUEST['loadMenu']) ) {
				renderAddItem(0, $menuId, $menuId, " ", $menuId);
			}
		echo '</ul>';
		mysql_free_result($query);
	}
}
?>