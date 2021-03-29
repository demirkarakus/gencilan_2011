<?php
if(!empty($_GET['cat'])){ $category= "and kategori='".$_GET['cat']."'"; }else{$category="";}

$last_msg_id=$_GET['last_msg_id'];
$sql=mysql_query("SELECT * FROM ads WHERE id < '$last_msg_id' and adminonayi='1' $category ORDER BY id DESC LIMIT 24");
$last_msg_id="";

while($row=mysql_fetch_array($sql))
{
?>
<script type="text/javascript">
$(document).ready(function(){
	function loadderimg()
	{
		$('#loadder').html('<div><img src="img/ajax_load.gif" width="16" height="16" style="padding:12px" alt="loading" /><div>');
		$('#fade').fadeIn();
	}
	
	$('.load_ads > a').click(function(){
		loadderimg();
		
		var parent  = $(this).parent();
		var getadsId   = parent.attr('id').replace('adsId_','');
	
		$('#facebox_loadder').toggle();
		$('#facebox_loadder').slideDown();
		$('#loadder').slideDown().load('loadder.php?what=ilan&adsId='+getadsId+'').height(460);
		
		return false;
	});
});

</script>
<div id="<?php echo $row['id']; ?>" class="message_box" >
			<div class="load_ads ALboxes" id="adsId_<?php echo $row['id'];?>">
				<a href="javascript: void(0)" title="<?php echo $row[baslik];?>">
				<div class="ALBimg">
					<div class="imgBox">
					<?php if(empty($row[resim])){?>
						<img src="img/ads.jpg" alt="<?php echo $row[baslik];?>">
					<?php }else{?>
						<img src="ads/small_<?php echo $row[resim];?>" alt="<?php echo $row[baslik];?>">
					<?php }?>
					</div>
				</div>
				<h2 class="price"><?php echo strLonger($row[fiyat],0,18);?></h2>
				<h4 class="title"><?php echo strLonger($row[baslik],0,18);?></h4>
				</a>
			</div>
</div>
<?php }?>

