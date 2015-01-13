<?php
	function renderModule($type, $data){
		switch($type){
			case "text":
				return $data;
				break;
			case "css":
				return compress('<style type="text/css">'.$data.'</style>');
				break;
			case "js":
				return compress('<script type="text/javascript">'.$data.'</script>');
				break;
			case "code":
				$id = md5( $data );
				return '<textarea id="'.$id.'" class="codeblock">'.$data.'</textarea>
				 <script type="text/javascript">
				  var html_editor = CodeMirror.fromTextArea(document.getElementById("'.$id.'"), {
				  mode: "text/html",
				  tabMode: "indent",
				  lineNumbers: true,
				  lineWrapping: false
				});
    		</script>';
				break;
			case "html":
				return $data;
				break;
		}
	}
?>