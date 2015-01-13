<div id="adminHeader">
	<?php
		$hours = floor($activeFor / 3600);
		$mins = floor(($activeFor - ($hours*3600)) / 60);
		$secs = floor( $activeFor - ($hours*3600) - ($mins * 60) );
		echo "<p>Active for: ".$hours." hours ".$mins." minutes and ".$secs." seconds.<a class='adminLink' href='session.php?destroy'>Logout</a><a class='adminLink' href='/admin/clearCache.php'>Clear Cache</a><a class='adminLink' href='/admin/adminOptions.php'>Admin Home</a></p>";
	?>
</div>
<?php
	if( isset($sessionWarning) ){
		echo "<p>".$sessionWarning."</p>";
	}
?>