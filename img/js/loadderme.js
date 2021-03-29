$(document).ready(function(){
	function loadderimg()
	{
		$('#loadder').html('<div><img src="img/ajax_load.gif" width="16" height="16" style="padding:12px" alt="loading" /><div>');
		$('#fade').fadeIn();
	}
   
	$('.close > a.loadder').click(function(){
		$('#facebox_loadder').toggle();
		$('#fade').fadeOut();
		return false;
	});
	
	//$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' ); 	
	//var parent  = $(this).parent();
	//var getID   = parent.attr('id').replace('postIdMain_','');
		
	$('.load_login > a').click(function(){
		loadderimg();
		
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadderNotUser.php?what=login').height(260);

		return false;
	});
		
	$('.load_register > a').click(function(){
		loadderimg();
		
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadderNotUser.php?what=register').height(360);
		
		return false;
	});
		
	$('.load_onayla > a').click(function(){
		loadderimg();
		
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadderNotUser.php?what=onayla').height(100);
		
		return false;
	});
		
	$('.load_plusads > a').click(function(){
		loadderimg();
		
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadder.php?what=plusads').height(460);
		
		return false;
	});
		
	$('.load_ads > a').click(function(){
		loadderimg();
		
		var parent  = $(this).parent();
		var getadsId   = parent.attr('id').replace('adsId_','');
	
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadder.php?what=ilan&adsId='+getadsId+'').height(460);
		
		return false;
	});
		
	$('.load_editprof > a').click(function(){
		loadderimg();
	
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadderUser.php?what=editprof').height(360);
		
		return false;
	});
		
	$('.load_myads > a').click(function(){
		loadderimg();
	
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();

		$('#loadder').slideDown().load('loadderUser.php?what=myads').height(460);
		
		return false;
	});
		
	$('.load_fullmyads > a').click(function(){
		loadderimg();

		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadderUser.php?what=fullmyads').height(460);
		
		return false;
	});

});
