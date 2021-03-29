<?php
session_start();
ob_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

if($what=='plusads')
{
?>
<p id="adsFormConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#adsFormConsole').hide();
			$("#adsForm").click(function(){
				$('#adsFormConsole').slideUp();
				$.post('ajaxads.php',{
				
					fullname: $('[name=ads_fullname]').val(),
					username: $('[name=ads_username]').val(),
					email:    $('[name=ads_email]').val(),
					password: $('[name=ads_password]').val(),
				
					kategori: $('[name=ads_kategori]').val(),
					baslik: $('[name=ads_baslik]').val(),
					aciklama: $('[name=ads_aciklama]').val(),
					ulke: $('[name=ads_ulke]').val(),
					sehir: $('[name=ads_sehir]').val(),
					ilce: $('[name=ads_ilce]').val(),
					fiyat: $('[name=ads_fiyat]').val(),
					kimden: $('input:radio[name=ads_kimden]:checked').val(),
					durumu: $('input:radio[name=ads_durumu]:checked').val(),
					garanti: $('input:radio[name=ads_garanti]:checked').val(),
					
					adsfullname: $('[name=ads_adsfullname]').val(),
					adsemail: $('[name=ads_adsemail]').val(),
					adshome: $('[name=ads_adshome]').val(),
					adsmobile: $('[name=ads_adsmobile]').val(),
					infosee: $('[name=ads_infosee]:checkbox:checked').val()
					},
					function(data){
						if(data.success)
						{
							$('#adsFormConsole').html(data.message).slideDown();
							
							$('[name=ads_fullname]').val('');
							$('[name=ads_username]').val('');
							$('[name=ads_email]').val('');
							$('[name=ads_password]').val('');							
							
							$('[name=ads_baslik]').val('');							
							$('[name=ads_aciklama]').val('');							
							$('[name=ads_ulke]').val('');							
							$('[name=ads_sehir]').val('');							
							$('[name=ads_ilce]').val('');							
							$('[name=ads_fiyat]').val('');

							$('[name=ads_adsfullname]').val('');
							$('[name=ads_adsemail]').val('');
							$('[name=ads_adshome]').val('');
							$('[name=ads_adsmobile]').val('');
							
							$('#facebox_loadder').toggle();
							$('#facebox_loadder').slideDown();
		
							$('#loadder').slideDown().load('loadder.php?what=ilanResim').height(460);
						}else{
							$('#adsFormConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
		});
	</script>
	<form method="post" name="adsForm" class="oneForm">
	<h1><?php echo LOAD_ADD_ADS; ?></h1>
		<label><?php echo LOAD_CATEGORIES; ?></label>
		<select name="ads_kategori">
			<option value="0"><?php echo LOAD_SELECT_CATEGORIES; ?></option>
			<?php 
				$query = "SELECT * FROM category where lang='1' ORDER BY id";
				$result = mysql_query ($query) or die ("hata");
					echo '<li><a href="">--- Seciniz ---</a></li>';
				while ($line = mysql_fetch_array($result)) 
				{
					echo '<option value="'.$line[id].'">'.$line[category].'</option>';
				}
			?>
		</select><br>
		<div class="clear"></div>
		<label><?php echo LOAD_TITLE; ?></label><input type="text" name="ads_baslik"><br>
		<label><?php echo LOAD_DESC; ?></label><textarea name="ads_aciklama" cols="" rows=""></textarea><br>
		<label><?php echo LOAD_COUNTRY; ?></label><input type="text" name="ads_ulke"><br>
		<label><?php echo LOAD_CITY; ?></label><input type="text" name="ads_sehir"><br>
		<label><?php echo LOAD_DISTRICT; ?></label><input type="text" name="ads_ilce"><br>
		<label><?php echo LOAD_PRICE; ?></label><input type="text" name="ads_fiyat"><br>
		
		<label><?php echo LOAD_WHOME; ?></label><?php echo LOAD_OWNER; ?><input name="ads_kimden" type="radio" value="0" checked> <?php echo LOAD_DEALER; ?><input name="ads_kimden" type="radio" value="1"><br>
		<div class="clear"></div>
		<label><?php echo LOAD_STATUS; ?></label><?php echo LOAD_NEW; ?><input name="ads_durumu" type="radio" value="0" checked> <?php echo LOAD_OLD; ?><input name="ads_durumu" type="radio" value="1"><br>
		<div class="clear"></div>
		<label><?php echo LOAD_WARRANTY; ?></label><?php echo LOAD_WARRANTY_YES; ?><input name="ads_garanti" type="radio" value="0" checked> <?php echo LOAD_WARRANTY_NO; ?><input name="ads_garanti" type="radio" value="1"><br>
		<div class="clear"></div>
		
		<?php if(!isset($_SESSION['status'])){?>
			<label><?php echo FORM_FULLNAME;?></label><input type="text" name="ads_fullname"><br>
			<label><?php echo FORM_USERNAME;?></label><input type="text" name="ads_username"><br>
			<label><?php echo FORM_HOME_TEL;?></label><input name="ads_adshome" type="text"><br>
			<label><?php echo FORM_MOBILE_TEL;?></label><input name="ads_adsmobile" type="text"><br>
			<label><?php echo FORM_EMAIL;?></label><input type="text" name="ads_adsemail"><br>
			<label><?php echo FORM_PASSWORD;?></label><input type="password" name="ads_password"></label><br>
		<?php }else{
			$uyeyimkim = mysql_query("select * from users where id='".$_SESSION['myid']."'");
			$uyeyime_baglan = mysql_fetch_array($uyeyimkim);
		?>
			<label><?php echo FORM_FULLNAME;?></label><input name="ads_fullname" type="text" value="<?php echo $uyeyime_baglan[fullname];?>"><br>
			<label><?php echo FORM_EMAIL;?></label><input name="ads_adsemail" type="text" value="<?php echo $uyeyime_baglan[email];?>"><br>
			<label><?php echo FORM_HOME_TEL;?></label><input name="ads_adshome" type="text" value="<?php echo $uyeyime_baglan[home];?>"><br>
			<label><?php echo FORM_MOBILE_TEL;?></label><input name="ads_adsmobile" type="text" value="<?php echo $uyeyime_baglan[mobile];?>"><br>
		<?php }?>
		<label>&nbsp;</label><input name="ads_infosee" type="checkbox" value="1" checked> <?php echo FORM_SEE_INFO;?><br><br>
		
		<label>&nbsp;</label><iframe height="100" src="kullanimvegizlilik.php" width="300" style=" padding:0; border:1px #ccc solid; "></iframe><br><br>

		<div class="clear"></div>
		<label>&nbsp;</label><button id="adsForm" class="button" ><span><?php echo FORM_SEND_ADS;?></span></button>
	</form>

<?php }

if($what=='ilan')
{
?>
			<?php 
				$query = "SELECT * FROM ads where id='".$_GET['adsId']."' ORDER BY id desc";
				$result = mysql_query ($query) or die ("hata");
				$line = mysql_fetch_array($result); 
			?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.wmLink > a').click(function(){
			
				var parent  = $(this).parent();
				var getwhoId   = parent.attr('id').replace('whoId_','');
				
				$('#facebox_loadder').slideDown();
				$('#loadder').slideDown().load('loadderUser.php?what=messages&where=write&whoId='+getwhoId).height(460);
				return false;
			});
			
			$('.load_login > a').click(function(){
				
				$('#facebox_loadder').slideDown();
				$('#loadder').slideDown().load('loadderNotUser.php?what=login').height(260);
		
				
			});
		});
	</script>
			<div class="ads_box">
				<h1><?php echo $line[baslik];?></h1>
				<div class="ads_left_info">
					<div class="ads_img">
						<a href="#">
							<?php if(empty($line[resim])){?>
								<img src="img/ads.jpg" alt="">
							<?php }else{?>
								<img src="ads/small_<?php echo $line[resim];?>" alt="">
							<?php }?>
						</a>
					</div>
					<?php if(!empty($_SESSION['status']) && $_SESSION['myid']!=$line['uid']){?>
						<div class="wmLink" id="whoId_<?php echo $line['uid'];?>"><a class="button" href="#">Mesaj G&ouml;nder</a></div>
					<?php }else{?>
						<div class="lmLink load_login"><a href="#">Mesaj G&ouml;nder</a></div>
					<?php }?>
				</div>
				<div class="ads_info">
					<ul>
						<li class="price"><?php echo $line[fiyat];?></li>
						<li class="categories">
						<?php 
							$querycat = "SELECT * FROM category where lang='1' and id='".$line[kategori]."' ORDER BY id";
							$resultcat = mysql_query ($querycat) or die ("hata");
							while ($linecat = mysql_fetch_array($resultcat)) 
							{
								if($linecat[id]==$line[kategori]){echo $linecat[category];}
							}
						?>
						</li>
						<li><span><?php echo ULKE;?> / <?php echo SEHIR;?>  / <?php echo ILCE;?> </span><?php echo $line[ulke];?> / <?php echo $line[sehir];?> /  <?php echo $line[ilce];?></li>
						
						<li><span><?php echo KIMDEN;?></span><?php if($line[kimden]==0){echo "sahibinden";}?><?php if($line[kimden]==1){echo "aracidan";}?></li>
						<li><span><?php echo DURUMU;?></span><?php if($line[durumu]==0){echo "sifir";}?><?php if($line[durumu]==1){echo "kullanilmis";}?></li>
						<li><span><?php echo GARANTI;?></span><?php if($line[garanti]==0){echo "garantili";}?><?php if($line[garanti]==1){echo "garantisiz";}?></li>
						
						<?php if(!empty($line[adsfullname])){?>
						<li><span><?php echo ADI;?></span><?php echo $line[adsfullname];?></li>
						<?php } if(!empty($line[adsemail])){?>
						<li><span><?php echo EMAIL;?></span><?php echo $line[adsemail];?></li>
						<?php } if(!empty($line[adshome])){?>
						<li><span><?php echo EV_TELEFONU;?></span><?php echo $line[adshome];?></li>
						<?php } if(!empty($line[adsmobile])){?>
						<li><span><?php echo CEP_TELEFONU;?></span><?php echo $line[adsmobile];?></li>
						<?php }?>
						<!--<li><span><?php echo EKLEME_TARIHI;?></span><?php echo $line[tarih];?></li>-->
					</ul>
				</div>
				<div class="clear"></div>

				<div class="clear"></div>
				<div class="explaination">
					<h1><?php echo ACIKLAMA;?></h1>
					<?php echo clickable_link($line[aciklama]);?>
				</div>
				
				<?php if(!empty($line[resim])){?>
				<div class="big_img">
					<img src="ads/<?php echo $line[resim];?>" alt="">
				</div>
				<?php }?><br>
				<div class="clear"></div>
			</div>
<?php }
if($what=='ilanResim')
{
$sonquery = "SELECT * FROM ads where uid='".$_SESSION['myadsphotouserid']."' order by id desc";
$sonresult = mysql_query ($sonquery) or die ("hata");
$sonline = mysql_fetch_array($sonresult); 
?>
	<iframe height="100" src="pic.php?adsids=<?php echo $sonline['id'];?>" width="80%" style=" padding:0; border:0; "></iframe>
<?php } 
ob_end_flush(); ?>
