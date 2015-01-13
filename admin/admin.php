<?php
	include("db.php");
	include("session.php");
	$err = "";
	if( isset($_POST['submit']) )
	{
		if( $_POST['password'] == "" || $_POST['username'] == ""){
			$err ="Please ensure all fields are filled in.";
		}else{ //attempt validation
			$password = md5($_POST['password']);
			$username = preg_replace('/[^a-z0-9]+/', '', strtolower($_POST['username']));
		
			$query = mysql_query("SELECT * FROM `users` WHERE `user_name` = \"$username\" and `user_pass` = \"$password\" LIMIT 1");
			$num_rows = mysql_num_rows($query);
			if($num_rows > 0 ){
				session_start();
				while($info = mysql_fetch_assoc( $query ))
				{
				 $_SESSION['userId'] = $info["user_id"];
				 $_SESSION['username'] = $info["user_name"];
				 $_SESSION['start_time'] = time();
				 $_SESSION['time'] = time();
				 $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				}
				mysql_free_result($query);
				header('Location: adminOptions.php');
				//logged in and now re-direct
			}
		}
	}
	if( isset($_REQUEST['timeOut']) ){
		$err = "Your Session has expired and you have been logged out. Please log back in...";
	}
	
	if( isset($_REQUEST['logout']) ){
		$err = "You have successfully been logged out.";
	}
	
	if( isset($_REQUEST['login']) ){
		$err = "Please login to access administration section.";
	}
?>

<?php
	error_reporting(0);
	include("../functions.php");
	$cachingOn = 0;
	printPageHeader("Admin Login", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Login");
?>
	<script type="text/javascript">
		$(function(){
			$("#login").validator();
		});
	</script>
	
	<form id="login" class="inputForm" method="post" name="loginForm" action="/admin/admin.php" style="width:300px; height:200px; margin: 60px auto;" novalidate> <!--onsubmit="return validateForm()"-->
		<div class="row center">
			<span id="message"><?php echo $err; ?></span>
		</div>
		<div class="row">
			<div class="titleCol">
				Username:
			</div>
			<div class="valueCol">
				<input type="text" name="username" value="<?php echo preg_replace('/[^a-z0-9]+/', '', strtolower($_POST['username'])); ?>" pattern="[a-zA-Z0-9]{5,}" maxlength="30" required="required"/>
			</div>
		</div>
		
		<div class="row">
			<div class="titleCol">
				Password:
			</div>
			<div class="valueCol">
				<input type="password" name="password" value="" required="required"/>
			</div>
		</div>

		<div class="row center">
			<input name="submit" type="submit" value="Login"/>
		</div>
	</form>

<?php
	printFooter();
?>
