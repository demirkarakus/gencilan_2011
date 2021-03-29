<script>

jQuery(document).ready(function($) {

	function dikeyOrtalama() {
		var yatay_uzunluk = document.documentElement.clientWidth
		var yanbosluk = (((yatay_uzunluk) / 2)-470) + "px"
		
		var dikey_uzunluk = document.documentElement.clientHeight
		var dikeyde = ((dikey_uzunluk) / 2) + "px"
		
		$(".facebox").css("left",yanbosluk)
		$(".facebox").css("max-height",dikeyde)		
		$(".popup").css("max-height",dikeyde)		

	}
	$(window).bind("load",dikeyOrtalama)
	$(window).bind("resize",dikeyOrtalama)
})

</script>
<div id="facebox_loadder" class="facebox" style="display:none; ">
	<div class="close"><a class="loadder" href="javascript: void(0)"><img src="img/closelabel.png" title="<?php echo CLOSE;?>" class="close_image" /></a></div>
	<div class="popup generalBorder">
		<div id="loadder"></div>
	</div>
</div>
<div id="fade" class="black_overlay"></div> 


