<?php
	$cachingOn = 0;
	include("functions.php");
	printPageHeader("Brendon Irwin's WebPage", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Sticky Note!");
	include("admin/db.php");
	
	$query = mysql_query("SELECT `Note_Text` FROM  `stickynote`");
	$num_rows = mysql_num_rows($query);
	if($num_rows > 0 ){
		while($info = mysql_fetch_assoc( $query ))
		{
			$note = $info['Note_Text'];
		}
	}
?>

<script type="text/javascript">
	$(function(){
		var change = 0;
		var checkSave;
		var url = "/admin/module_save_note.php";
		function stripslashes (str) {
			 return (str + '').replace(/\\(.?)/g, function (s, n1) {
				switch (n1) {
				case '\\':
					return '\\';
				case '\'':
					return "'";
				case '0':
					return '\u0000';
				case '':
					return '';
				default:
					return n1;
				}
			});
		}
		
		function saveNote(){
			if( change == 1){
				change = 0;
				var noteText = encodeURI( $('#sticky').val() );
				$.post( url, { note: noteText },function( data ) { });
			}else{
				$('#check').load(url + "?loadNote=1", function( data) {
					if( $('#check').html() != "" && $('#check').html() != $('#sticky').val() ){
						var note = $('#check').html();
						//console.log(note);
						
						note = decodeURI( note );
						//console.log("After Decode > " + note);
						note = unescape(   note  );
						//console.log("After un escape > " + note);
						
						note = stripslashes (   note  );
						//console.log("After un escape > " + note);
						
						$('#sticky').val( note );
					}
				});
			}
			clearInterval(checkSave);
			checkSave = window.setInterval(saveNote, 10000);
		}
		
		function checkSaveBeforeLeave(e){
			e = e || window.event;
			if( change == 1){
				return "Click Save before leaving to avoid loosing changes";
			}
		}
		$('#sticky').keyup(function() { change = 1; });
		$("#sticky").change( function() { change = 1; });
		
		$('#SaveSticky').click(function(){
			change = 1;
			saveNote();
		});
		
		saveNote(); // load the note
		
		checkSave = window.setInterval(saveNote, 10000);
		window.onbeforeunload = checkSaveBeforeLeave;
	});
</script>

<style type="text/css">
	#sticky{
		border: none;
		background-color: rgb(245,247,173);
		color: #000;
		font-size: 14px;
		line-height: 16px;
		margin-top: 10px;
	}
</style>

<div id="StickyNote">
	<div id="check" style="display: none"></div>
	<textarea id="sticky" rows="20" cols="120" style="width: 100%;"></textarea>
	<button id="SaveSticky">Save</button>
</div>

<?php
	printFooter();
?>
