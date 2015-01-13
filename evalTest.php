<?php
	include("functions.php");
	include("admin/db.php");
	printPageHeader("Eval Test", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Eval Test");
	$id = 2;
	$query = "SELECT `code` FROM `eval_test` WHERE `id` = ".$id;
	
	$res = mysql_query($query);
	$num_rows = mysql_num_rows($res);
	
	
	if($num_rows > 0 ){
		while($info = mysql_fetch_assoc( $res ))
		{
			echo "<p>Contents in the <b>database</b> as text:<p>";
			echo highlight_string( $info['code'] , 1);
			
			echo "<br/><br/><b>This is evaluated to:</b><br/><br/>";
			eval(' ?>'.$info['code'].'<?php ');
			
		}
	}
	
	?>
		<p><br/><b>by using eval using the code:</b></p>
		<code>
			<div>$res = mysql_query("Query to grab `code` (text data) from a db");</div>
			<div>if($res && mysql_num_rows($res) != 0 ){</div>
			<div>while($info = mysql_fetch_assoc( $res ))</div>
			<div>{</div>
			<!--<div>echo highlight_string( $info['code'] , 1);</div>
			<div>echo "&lt;br/&gt;&lt;br/&gt;Becomes: &lt;br/&gt;&lt;br/&gt;";</div>-->
			<div><b>eval</b>(' ?&gt;'.$info['code'].'&lt;?php ');  /*Note! It is important to include the &lt;?php and ?&gt; as I did or it may give you issues....*/</div>
			<div>}</div>
			<div>}</div>
		</code>
		
		

	<?php
	
	
	
	printFooter();
?>
