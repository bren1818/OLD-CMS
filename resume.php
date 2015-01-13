<?php
	include("functions.php");
	printPageHeader("Brendon Irwin's Resume", "Brendon Irwin's personal website", "Brendon Irwin, Brendon, Bren1818" );
	printHeader("My Resume");
?>

<h2>Objective:</h2>
<div class="section">
	<p>To obtain a full time position in a field relating to: <strong>Software and/or Web Development</strong>.</p>
</div>

<h2>Education:</h2>
<div class="section">
	<p>
		<b>2009 &ndash; University of Guelph</b> &ndash; Bachelor of Computing Diploma<br/>
		<b>2006 &ndash; Aurora High School</b> &ndash; Honours Diploma
	</p>
</div>

<h2>Employment Experience</h2>
<div class="section">
	<p><strong>Sandbox Software Solutions</strong><br/>
	<span class="tab">&nbsp;</span>Project team lead &ndash; Software &amp; web development, Maintenance and Design, Sept 2009 &ndash; present<br/>
	<span class="tab">&nbsp;</span>Mobile team lead &ndash; Software &amp; mobile web development, July 2011 &ndash; present</p>
		
	<p><strong>University of Guelph</strong><br/>
	<span class="tab">&nbsp;</span>Lead developer &ndash; Carol Project, May 2010 &ndash; September 2010<br/>
	<span class="tab">&nbsp;</span>Teaching assistant &ndash; CIS*1200, Sept 2009 &ndash; December 2010 (3 semesters)</p>
	   
	<p><strong>Staples Business Depot</strong><br/>
	<span class="tab">&nbsp;</span>On site computer technician, sales and merchandising, June &ndash; August 2009</p>
	   
	<p><strong>The Source by Circuit City</strong><br/>
	<span class="tab">&nbsp;</span>On site computer technician, sales and merchandising, May 2007 &ndash; August 2007, Dec 2007</p>
	   
	<p><strong>Carl Zeiss Canada, Toronto, Ontario</strong><br/>
	<span class="tab">&nbsp;</span>Computer maintenance, Data entry, Software Development, December 2006</p>
</div>

<h2>Employment Experience</h2>
<div class="section">
	<div id="experience">
		<ul>
			<li><a href="#tabs-1">Web Based Technologies</a></li>
			<li><a href="#tabs-2">Programming</a></li>
			<li><a href="#tabs-3">Database</a></li>
			<li><a href="#tabs-4">CMS / E-Commerce</a></li>
			<li><a href="#tabs-5">Other Assets</a></li>
		</ul>
		<div id="tabs-1" class="subtab">
			<ul class="skillset">
				<li>HTML, CSS</li>
				<li>Javascript</li>
				<li>jQuery</li>
				<li>jQuery UI</li>
				<li>Json</li>
				<li>Ajax</li>
			</ul>
		</div>
		<div id="tabs-2" class="subtab">
			<ul class="skillset">
				<li>PHP</li>
				<li>Java (JNI, Swing)</li>
				<li>JSP</li>
				<li>Objective C (IOS)</li>
				<li>ASP.Net</li>
				<li>C</li>
				<li>Visual Basic 6</li>
			</ul>
		</div>
		<div id="tabs-3" class="subtab">
			<ul class="skillset">
				<li>My SQL</li>
				<li>Microsoft Access</li>
			</ul>
		</div>
		<div id="tabs-4" class="subtab">
		<ul class="skillset">
			<li>Intratuitive - Sandbox Software's in-house CMS</li>
			<li>Magento</li>
			<li>Shopify</li>
			<li>Hubspot</li>
			<li>Sitefinity</li>
			<li>WordPress</li>
		</ul>
		</div>
		<div id="tabs-5" class="subtab">
			<ul class="skillset">
				<li>Microsoft Office</li> 
				<li>Adobe Creative Suite</li>
				<li>Familiar with OSX </li>
				<li>Familiar with Windows 3.1 &ndash; 8</li>
				<li>SEO improvement techniques</li>
				<li>Strong customer service skills</li>
				<li>Cross browser website authoring (IE6 +)</li>
			</ul>
		</div>
	</div>	
</div>
<script type="text/javascript">
	$(function(){
		$('#experience').tabs();
	});
</script>

<h2>Awards and programs</h2>
<div class="section">
	<ul>
		<li>Leadership and Counsellor in training program (LIT/CIT Program)</li>
		<li>Safety program implementation (CPR &amp; First Aid)</li>
		<li>&lsquo;Top Sales Award&rsquo; three months in a row (The Source 2007)</li>
		<li>Highest rated customer Service skills (The Source 2007)</li>
	</ul>
</div>

<h2>Current responsibilities</h2>
<div class="section">
	<ul>
		<li>Website setup and production deploys</li>
		<li>Ongoing website maintenance</li>
		<li>Email setup and configuration</li>
		<li>Computer setup and network deploys</li>
		<li>Training and documentation</li>
		<li>Sales, customer service and client meetings</li>
	</ul>
</div> 
<?php
	printFooter();
?>
