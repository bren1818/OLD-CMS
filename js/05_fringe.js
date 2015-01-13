
var imgSize = 200;
var scaler = 0;
$(function(){
	
	$('#FringeText').keypress(function(e){
		if(e.which == 13){
      		 $('#MakeCode').click(); 
       }
     });
	
	$( "#slider" ).slider({
		value:100,
		min: 100,
		max: 1000,
		step: 50,
		slide: function( event, ui ) {
			imgSize = $( "#slider" ).slider( "value" );
			$('#MakeCode').click();
		}
	});
	
	$('#MakeCode').click(function(){
		
		var theText =  $('#FringeText').val();
		$('#FringeCode').html('');
		var cnt = parseInt(theText.length) + 1;
		
		for( var x=1; x < cnt; x++){
				$('#FringeCode').append('<div class="letter letter' + theText.substring(x-1, x).toUpperCase() + '"><div class="dot"></div></div>');	
		}
		
		$('.letter').each(function(index) {
			$(this).css({'height' : imgSize + 'px', 'width' : imgSize + 'px'});
		});
		
		$('.dot').each(function(index) {
				scaler = ( 102 * ( imgSize / 1000) );
				$(this).css('height' ,  scaler + 'px');
				$(this).css('width' ,  scaler + 'px');
				
		 });
		 
		 var textWidth = ((scaler *10) * cnt) + 'px';
		 $('#FringSpacer').css('height' ,  (scaler *10) + 'px');
		 $('#FringeCode').css({'position' : 'absolute', 'width' :  textWidth  });
	});
	
});

