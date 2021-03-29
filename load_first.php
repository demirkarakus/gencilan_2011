<?php
if(!empty($_GET['cat'])){ $category= "and kategori='". $_GET['cat']."'"; }else{$category="";}

$sql=mysql_query("SELECT * FROM ads where adminonayi='1' $category ORDER BY id DESC LIMIT 44");
while($row=mysql_fetch_array($sql))
		{
?>

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

<?php
}
?>
