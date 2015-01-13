$(function(){
	function endsWith(str, suffix) {
		return str.indexOf(suffix, str.length - suffix.length) !== -1;
	}
	/*Determine which menu page we're on*/
	var wl = window.location.pathname;
	$('#pageMenu a').each(function(index){
		if(index == 0){
			$(this).addClass('menuItemFirst');
		}
		if(index == ($('#pageMenu a').length -1) ){
			$(this).addClass('menuItemLast');
		}
		if( endsWith( $(this).attr('href') , wl) || endsWith("/" + $(this).attr('href'), wl) ) /*chek the a tags link*/
		{
			$(this).addClass('active');
			return; /*break loop*/
		}
	});
	
	var curPage = window.location;
	var pageEntryTime = new Date().getTime();
	var pageLeaveTime = new Date().getTime();
	var trackerid = -1;
	var internalclick = 0;
	var comingFrom = "DIRECT";
	var goingTo = "EXTERNAL";
	var updId = 0;
	var okLeave = 0;	
		
	if( !window.location.toString().indexOf("/admin/") ){
	
	if( document.referrer != undefined && document.referrer != ""){
		comingFrom = document.referrer;
	}
	
	$.post( "/pageTracking.php", { pageId : pageId.toString(), curPage : curPage.toString(), pageEntryTime : pageEntryTime.toString(), pageLeaveTime : pageLeaveTime.toString(), comingFrom : comingFrom.toString(), goingTo : goingTo.toString()  },function(data){ updId = parseInt(data); });		


	$('#pageWrapper a').click(function(event){
		event.preventDefault();
		if( $(this).attr('href') != undefined && $(this).attr('href') != "" ){
			goingTo = $(this).attr('href');
			pageLeaveTime = new Date().getTime();
			okLeave = 1;
			$.post( "/pageTracking.php", { update : "1", curPage : curPage.toString(), pageEntryTime : pageEntryTime.toString(), pageLeaveTime : pageLeaveTime.toString(), comingFrom : comingFrom.toString(), goingTo : goingTo.toString()  },function(){ window.location = goingTo; });
		}
	});
	
	function confirmExit(){
		if( !okLeave ){/*Tracking for External pages*/
		pageLeaveTime = new Date().getTime();
		$.post( "/pageTracking.php", { update : "1", curPage : curPage.toString(), pageEntryTime : pageEntryTime.toString(), pageLeaveTime : pageLeaveTime.toString(), comingFrom : comingFrom.toString(), goingTo : goingTo.toString()  },function(){ });
		}
	}
	
	window.onbeforeunload = confirmExit;
	}
});

/*Google Plus One Button*/
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();

/*Google Analytics*/
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-29114899-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

/*Twitter*/
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");