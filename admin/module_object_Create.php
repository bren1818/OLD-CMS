<?php
	include("session.php");
	include("db.php");
	include("../functions.php");
	error_reporting(0);
	$cachingOn = 0;
	printPageHeader("Admin Options", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("Admin Options");
?>
 <link rel="stylesheet" href="Admin_Includes/CodeMirror/lib/codemirror.css"/>
 <script type="text/javascript" src="Admin_Includes/CodeMirror/lib/codemirror.js"></script>
 <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/xml/xml.js"></script>
 <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/javascript/javascript.js"></script>
 <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/css/css.js"></script>
 <script type="text/javascript" src="Admin_Includes/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>    
 <style type="text/css">
 	.titleCol{ 
		width: 200px;
	}
 	.valueCol{
		width: 600px;	
	}
 </style>       
<?php
	include("adminHeader.php");
?>

<h2>Object Creator</h2>

<form name="object_create">
		<div class="row">
			<span id="message"><?php echo $err; ?></span>
		</div>
        
        <div class="row">
			<div class="titleCol">
				Object Name:
			</div>
			<div class="valueCol">
				<input type="text" name="object_name" value="<?php echo preg_replace('/[^a-zA-Z0-9 -]+/', '', $object_name); ?>" pattern="[a-zA-Z0-9 -]{5,}" maxlength="55" required="required"/>
			</div>
		</div>
  
          <div class="row">
			<div class="titleCol">
				Inherit Object Fields From (Other Object):<br/>
               
			</div>
			<div class="valueCol">
				<select name="object_inherit_fields">
                	<option value="-1">None</option>
                </select>
			</div>
		</div>
        
       <div class="row">
                <div class="titleCol">
                    Order Object Fields By:
                </div>
                <div class="valueCol">
                    <select name="object_sort_fields">
                        <option value="-1">Auto</option>
                    </select>
                </div>
        </div>
        <div class="row">
            <div class="titleCol">
               Owner:
            </div>
            <div class="valueCol">
                <input type="text" disabled="disabled" value="<?php echo $_SESSION['username']; ?>"/>
            </div>
        </div>
        <div class="row">
            <div class="titleCol">
               Number of Fields:
            </div>
            <div class="valueCol">
                <input type="text" disabled="disabled" value="<?php if(isset($object_num_fields) ){ echo $object_num_fields;  }else{ echo "0";   } ?>"/>
            </div>
        </div>
       <div class="row">
                <div class="titleCol">
                   Object HTML Template:
                </div>
                <div class="valueCol">
					<textarea id="object_html_template" name="module_content" class="CODE_Block code"><?php  ?></textarea>
					 <script type="text/javascript">
                        var html_editor = CodeMirror.fromTextArea(document.getElementById("object_html_template"), {
                          mode: "text/html",
                          tabMode: "indent",
                          lineNumbers: true,
                          lineWrapping: false
                        });
                    </script>  
                </div>
        </div>
</form>

<button>Add Fields</button>

<?php
	printFooter();
?>