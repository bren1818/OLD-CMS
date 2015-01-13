/*
	Bren Library, - assorted Scripts and methods for mobile friendly and responsive design
	by: Brendon Irwin
	Last Update: Tuesday January 23rd 2012

*/

var minSiteWidth = 480; /*Anything Less than or Equal to this will be in 'phone' view*/
var maxSiteWidth = 1024; /*Anything between this and min width will be tablet, anything greater will be Desktop*/

/*

Layout should be structured like such:

<div id="someIDforSection" class="siteSection">
	<div class="siteContent">
	
	</div>
</div>

<style type="text/CSS">
	.siteSection{
		width: 100%;
		clear: both;
	}
	
	.siteContent{
		margin: 0 auto;
		position: relative;
		display: block;
		width: 1024px;
		max-width: 1024px;
		min-width: 480px;
	}
	
	.desktopDevice .siteContent{ width: 1024px; max-width: 1024px; }
	.tablet .siteContent{ width: 80%; }
	.phone .siteContent{ width: 480px; max-width: 480px;}
	
	.mobileDevice .siteContent{
		Generic to all Mobile
	}
	
	
</style>

*/


/*function to reverse collection in jQuery*/
jQuery.fn.reverse = [].reverse;

var previousOrientation = 0;
var checkOrientation = function(){
	if(window.orientation !== previousOrientation && window.orentation != undefined){
	   previousOrientation = window.orientation;
		$(function(){
			//get proper width
			var ww = ( $(window).width() < window.screen.width ) ? $(window).width() : window.screen.width; 
			//get proper width
			var wh = ( $(window).height() < window.screen.height ) ? $(window).height() : window.screen.height;
			var o = ( ww > wh) ? "Landscape" : "Portait";
			$('body').removeClass('Landscape');
			$('body').removeClass('Portait');
			$('body').addClass(o);
		});
  	}
};

function isMobile(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		return true;
	}else{
		return false;
	}
}

/*Add on the resize and orientation events for Mobile*/
if( isMobile() ) {
	window.addEventListener("resize", checkOrientation, false);
	window.addEventListener("orientationchange", checkOrientation, false);
}

function setViewPort(mw){
	if( isMobile() ) { //Only care about setting the view ports on mobile devices
		$('body').addClass('mobileDevice');	
		if( mw == undefined ){
			mw = minSiteWidth;
		}
		
		var ww = ( $(window).width() < window.screen.width ) ? $(window).width() : window.screen.width; //get proper width
		var ratio =  ww / mw; //calculate ratio
		if( ww <= mw){ /*Phone Layout*/
			
			$('body').addClass('phone');
			$('body').removeClass('tablet');
			
			$('.siteSection').width( mw );
			$('#Viewport').attr('content', 'initial-scale=' + ratio + ', maximum-scale=' + ratio + ', minimum-scale=' + ratio + ', user-scalable=no, width=' + ww);
			
		}else{ /*Tablet / Desktop Layout */
			$('body').addClass('tablet');
			$('body').removeClass('phone');
			
			$('.siteSection').width( ww );
			
			$('#Viewport').attr('content', 'initial-scale=1.0, maximum-scale=2, minimum-scale=1.0, user-scalable=no, width=' + ww);
			
			if( ww >= maxSiteWidth ){
				$('body').addClass('desktopDevice'); /*Optional */
			}
		}
	}else{
		$('body').addClass('desktopDevice');
	}
}

/*Function to allow a delayed re-size trigger event*/
var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();

/*to use instead of console.log so one line can be commented out on deploy*/	
function log( message ){
	$(function(){
		if ( !$.browser.msie ) {
			console.log(message);
		}
	});
}
	
//scroll to an object on the page	
function scrollTo( objectId, offsetHeight ){
	offsetHeight = typeof offsetHeight !== 'undefined' ? offsetHeight : 0;
	$('html,body').animate({scrollTop: $('#' + objectId ).offset().top + offsetHeight },'slow');
}

/*In View Plugin : Source https://github.com/protonet/jquery.inview */
(function(d){var p={},e,a,h=document,i=window,f=h.documentElement,j=d.expando;d.event.special.inview={add:function(a){p[a.guid+"-"+this[j]]={data:a,$element:d(this)}},remove:function(a){try{delete p[a.guid+"-"+this[j]]}catch(d){}}};d(i).bind("scroll resize",function(){e=a=null});!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){a=null});setInterval(function(){var k=d(),j,n=0;d.each(p,function(a,b){var c=b.data.selector,d=b.$element;k=k.add(c?d.find(c):d)});if(j=k.length){var b;
if(!(b=e)){var g={height:i.innerHeight,width:i.innerWidth};if(!g.height&&((b=h.compatMode)||!d.support.boxModel))b="CSS1Compat"===b?f:h.body,g={height:b.clientHeight,width:b.clientWidth};b=g}e=b;for(a=a||{top:i.pageYOffset||f.scrollTop||h.body.scrollTop,left:i.pageXOffset||f.scrollLeft||h.body.scrollLeft};n<j;n++)if(d.contains(f,k[n])){b=d(k[n]);var l=b.height(),m=b.width(),c=b.offset(),g=b.data("inview");if(!a||!e)break;c.top+l>a.top&&c.top<a.top+e.height&&c.left+m>a.left&&c.left<a.left+e.width?
(m=a.left>c.left?"right":a.left+e.width<c.left+m?"left":"both",l=a.top>c.top?"bottom":a.top+e.height<c.top+l?"top":"both",c=m+"-"+l,(!g||g!==c)&&b.data("inview",c).trigger("inview",[!0,m,l])):g&&b.data("inview",!1).trigger("inview",[!1])}}},250)})(jQuery);

/*jQuery Functions I have prototyped*/
(function( $ ) {
	//same as above but binds the click event
	//also supports a decimal target
	$.fn.clickScrollTo = function(target, offsetHeight){
		$(this).each(function(){
			$(this).click(function(event){
				event.preventDefault();
				if( isNaN( offsetHeight ) || offsetHeight == "" ){
					offsetHeight = 0;
				}
				if( isNaN( target ) ){
					$('html,body').animate({scrollTop: $('#' + target ).offset().top + offsetHeight },'slow');
				}else{
					$('html,body').animate({scrollTop: target + offsetHeight },2500);
				}
			});
		});
	};
	
	/*Fades an object in when it is scrolled into view*/
	$.fn.fadeInWhenInView = function(duration){
		$(this).each(function(){
			var obj = $(this);
			$(this).css('opacity', 0);
			$(obj).bind('inview', function (event, visible) {
				if( duration != undefined ){
					$(obj).animate({
							opacity: 1
						}, duration, function() {
							// Animation complete.
					 });
				}else{
					$(obj).animate({
							opacity: 1
						}, 3000, function() {
							// Animation complete.
					 });
				}
			});
		});
	};
	
	$.fn.fadeInAndLoadWhenInView = function(duration){
		$(this).each(function(){
			var obj = $(this);	
			$(obj).wrap('<span class="loadingImg" style="' + $(obj).attr('style') +'"/>');		
			$(obj).css('opacity', 0);
			$(obj).bind('inview', function (event, visible) {
				$(obj).attr('src', $(obj).attr('data-src') );
				
				$(obj).load(function(){
					//should just show the wrapped object
				},function(){
					$(obj).parent().removeClass('loadingImg');
					if( duration != undefined ){
						$(obj).animate({
								opacity: 1
							}, duration, function() {
								// Animation complete.
						 });
					}else{
						$(obj).animate({
								opacity: 1
							}, 3000, function() {
								// Animation complete.
						 });
					}
				});
				$(this).error(function() {
					$(obj).animate({
							opacity: 1
						}, 3000, function() {
							// Animation complete.
					 });
					//issue, the image could not be loaded
				});
				
				$(obj).unbind('inview');
			});
		});
	};
	
	
	$.fn.brenSlide = function(){
		$(this).each(function(){
			 var methods = {
			 
			 };
			 
			 
			 
		});
	};
	
	/*Max height of an object/collection*/
	 $.fn.maxHeight = function() {
		var max = 0;
		this.each(function() {
		  max = Math.max( max, $(this).height() );
		});
		return max;
	};
	
	
})( jQuery );

$(function(){
	//selector for external links
	$.expr[':'].external = function(obj){ return !obj.href.match(/^mailto\:/) && (obj.hostname != location.hostname) && (obj.hostname != ''); };
	
	$('a:external').attr('target','_blank');	
	
	/*Simple Tooltip Script*/
	if( $('.toolTip').length != 0 ){
		if( !$('body > #toolTipText').length ){
			$('body').append('<div id="toolTipText"/>');
		}
		
		$('img.toolTip').mouseenter(function(event) {
			if( !$(this).attr('title') === undefined || !$(this).attr('title') == "" ){
				$('#toolTipText').css({'position' : 'absolute', 'top' : event.pageY + 'px', 'left' : event.pageX + 'px', 'display': 'block'});
				$('#toolTipText').html( $(this).attr('title') );
				$(this).attr('_title', $(this).attr('title') );
				$(this).removeAttr('title');
			}
		}).mouseleave(function() { $('#toolTipText').html(''); $('#toolTipText').hide(); $(this).attr('title', $(this).attr('_title') ); });
	}	
	
	if( !isMobile() ) { /*This is for desktops, don't need it done on both*/
		$(window).resize(function () { /*so that we don't have to coninuously call functions on a resize*/
			waitForFinalEvent(function(){
				var w = ( $(window).width() < window.screen.width ) ? $(window).width() : window.screen.width;
				if(  w <= minSiteWidth ){
					$('body').addClass('phone');
					$('body').removeClass('desktopDevice');
					$('body').removeClass('tablet');
					//log( "Gone to phone View");
				}else if( w > minSiteWidth && w < maxSiteWidth ){
					$('body').addClass('tablet');
					$('body').removeClass('phone');
					$('body').removeClass('desktopDevice');
					//log("Gone to Tablet View");
				}else{
					$('body').removeClass('phone');
					$('body').removeClass('tablet');
					$('body').addClass('desktopDevice');
					//log("Gone to Desktop View");
			}
		}, 500, "WindowResize");
	});
	}
});


function genericFader( parent, items, uniqueName ){
	$(parent).each(function(index){
		var cnt = $(this).find( items ).length;
		var minH = 0;
		if( cnt != 0 ){
			$(this).prepend('<div class="' + uniqueName  + '_controls genericControl"></div>');
			$(this).find( items ).each(function(ind){
				$(this).addClass(uniqueName + '_dataItem_' + ind);
				$(this).addClass('genericControlDataItem');
				
				
				if( $(this).height() > minH ){ minH = $(this).height(); }
				
				$('.' + uniqueName   + '_controls').append('<div class="genericControlToggle ' + uniqueName + '_control_' + ind + '"></div>');
				if( ind != 0 ){ $(this).hide(); };
			});
			
			$(this).find('.' + uniqueName + '_dataItem_0, ' + '.' +  uniqueName + '_control_0').addClass('active');
			$(this).find( items ).css('min-height', minH  + 'px');
			$(this).css('min-height', minH  + 'px');
			
			$(this).find('.genericControlToggle').click(function( event ){
				event.preventDefault();
				if( ! $(this).hasClass('active') ){
					$(this).parent().find('.active').removeClass('active');
					$(this).addClass('active');
					
					
					$(this).parent().parent().find('.genericControlDataItem.active').removeClass('active').fadeOut();
					$(this).parent().parent().find('.genericControlDataItem:eq(' + $(this).index() + ')').addClass('active').fadeIn();
					
				}
			});  
			
		}
		
	});
}


function notify(message, messageClass){


}