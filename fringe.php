<?php
	include("functions.php");
	printPageHeader("Brendon Irwin's WebPage", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("FRINGE!");
?>
		<h1>Yes, I'm a big Fringe Fan</h1>
		<div style="clear: both;">
            <table id="fringeControls" cellpadding="5" cellspacing="0" width="800">
                <tr>
                <td colspan="4" width="500">	
                    <p>Type a word into the box, and click <b>go</b> to see the word turned into a Fringe &ldquo;Glyph&rdquo;.</p>
                    <p>Scrolling the slider will adjust &ldquo;Glyph&rdquo; size.</p>
					<p>This is all done with CSS3 & a little jQuery.. and will only work in newer browsers (Chrome, Firefox, IE9)</p>
                </td>
                </tr>
                <tr>
                    <td width="150"><input width="150" type="text" id="FringeText"></td>
                    <td width="20" align="left"><button id="MakeCode">Go</button></td>
                    <td width="20" align="right">Size:</td>
                    <td> <div id="slider"></div></td>
                </tr>
            </table>  
        </div>
        <div id="FringSpacer" style="position:relative">
            <div id="FringeCode" class="toPrint">
            
            </div>
        </div>
<?php
	printFooter();
?>
