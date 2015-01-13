<?php
include("../admin/session.php");
if(isset($_SESSION['userId']) ) {
	$path = "/upload/";
?>
<div id="custom-demo" class="demo">
	<h2>Select the files to upload</h2>
	
	<script type="text/javascript" src="<?php echo $path; ?>swfobject.js"></script>
	<script type="text/javascript" src="<?php echo $path; ?>jquery.uploadify.v2.1.4.min.js"></script>
	<script type="text/javascript">
	// <![CDATA[
	$(function() {
	  $('#file_upload').uploadify({
			'uploader'  : '<?php echo $path; ?>uploadify.swf',
			'script'    : '<?php echo $path; ?>uploadify.php',
			'cancelImg' : '<?php echo $path; ?>cancel.png',
			'folder'    : '/uploads',
			'auto'      : true,
			'queueID'        : 'custom-queue',
			'multi'          : true,
			'auto'           : true,
			'queueSizeLimit' : 100,
			'simUploadLimit' : 1,
			'sizeLimit'   : 160777216,
			'removeCompleted': false,
			'onDialogClose'   : function(queue) {
				$('#status-message').text(queue.filesQueued + ' files have been added to the queue.');	
			},
			'onQueueComplete'  : function(stats) {
				$('#status-message').text(stats.successful_uploads + ' files uploaded, ' + stats.upload_errors + ' errors.');
			}
	  });
	});
	// ]]>
	</script>

	<style type="text/css">
		#custom-queue {
			border: 1px solid #E5E5E5;
			height: 213px;
			margin-bottom: 10px;
			width: 370px;
			overflow-y: auto;
			overflow-x: hidden;
		}

		#custom-queue .uploadifyQueueItem {
			border-radius: 0;
			border: none;
			border-bottom: 1px dotted #E5E5E5;
			margin-top: 0;
		}
		
		.cancel{
			float: left;
			width: 16px;
		}
		
		.percentage,
		.fileName{
			color: #fff;
		}
	</style>

	<div class="demo-box">
		<!--<div id="status-message">Select some files to upload:</div>-->
		<div id="custom-queue"></div>
		<input id="file_upload" type="file" name="Filedata" />
		<input type="hidden" name="MAX_FILE_SIZE" value="50000000">
	</div>
</div>
<?php }else{
	echo "<p>Sorry, you must be logged in to upload files</p>";
}
 ?>


