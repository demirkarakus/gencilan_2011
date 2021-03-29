<?php
session_start();
ob_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

$uye_kim = mysql_query("select * from users where id='".$_SESSION['myid']."'");
$uye_baglan = mysql_fetch_array($uye_kim);
$uye_say = mysql_num_rows($uye_kim);

kontrolet(1,$_SESSION['status']);

if($what=='editprof')
{
?>
<p id="editprofileConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#editprofileConsole').hide();
			$("#editprofileForm").click(function(){
				$('#editprofileConsole').slideUp();
				$.post('ajaxeditprofile.php',{
					fullname: $('[name=editprofile_fullname]').val(),
					username: $('[name=editprofile_username]').val(),
					email:    $('[name=editprofile_email]').val(),
					adshome: $('[name=ads_adshome]').val(),
					adsmobile: $('[name=ads_adsmobile]').val()
					},
					function(data){
						if(data.success)
						{
							$('#editprofileConsole').html(data.message).slideDown();
						}else{
							$('#editprofileConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
			
			$('.load_editpass > a').click(function(){
				$('#facebox_loadder').toggle();
				$('#facebox_loadder').slideDown();
				$('#loadder').slideDown().load('loadderUser.php?what=editpass').height(142);
				return false;
			});
		});
	</script>
	<form method="post" name="editprofileForm" class="oneForm">
	<h1><?php echo FORM_EDIT_PROFILE;?></h1>
		<label><?php echo FORM_FULLNAME;?></label><input type="text" name="editprofile_fullname" value="<?php echo $uye_baglan['fullname'];?>" ><br>
		<label><?php echo FORM_USERNAME;?></label><input type="text" name="editprofile_username" value="<?php echo $uye_baglan['username'];?>" ><br>
		<label><?php echo FORM_EMAIL;?></label><input type="text" name="editprofile_email" value="<?php echo $uye_baglan['email'];?>" disabled><br>
		<label><?php echo FORM_HOME_TEL;?></label><input name="ads_adshome" type="text" value="<?php echo $uye_baglan[home];?>"><br>
		<label><?php echo FORM_MOBILE_TEL;?></label><input name="ads_adsmobile" type="text" value="<?php echo $uye_baglan[mobile];?>"><br>
		<label>&nbsp;</label><p class="load_editpass"><a href="javascript: void(0)"><?php echo FORM_CHANGE_PASSWORD;?></a></p><br>
		<label>&nbsp;</label><button id="editprofileForm" class="button"><span><?php echo FORM_SAVED;?></span></button>
	</form>
<?php
}
if($what=='myads')
{
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.load_fullmyads > a').click(function(){
		
				var parent  = $(this).parent();
				var getmyAdsId   = parent.attr('id').replace('myAdsId_','');
		
				$('#facebox_loadder').toggle();
				$('#facebox_loadder').slideDown();
				$('#loadder').slideDown().load('loadderUser.php?what=fullmyads&myadsid='+getmyAdsId+'').height(460);
				return false;
			});
			
			$('.load_myadsListEdit > a').click(function(){
		
				var parent  = $(this).parent();
				var getmydel   = parent.attr('id').replace('adsIdDel_','');
				
				var answer = confirm ("<?php echo FORM_DO_YOU_WANT_DELETE;?>")
				if (answer){

				$.post('ajaxadsdel.php',{
					what: "adsdelete",
					adsId: getmydel
					},
					function(data){
						if(data.success)
						{
							$('#myAdsId_'+getmydel).slideUp();
						}
					}, 'json');
				}
				return false;
			});
			
		});
	</script>
			<?php 
				$query = "SELECT * FROM ads where uid='".$_SESSION['myid']."' ORDER BY id desc";
				$result = mysql_query ($query) or die ("hata");
				while ($line = mysql_fetch_array($result)) 
				{
			?>
			<div class="load_fullmyads" id="myAdsId_<?php echo $line[id];?>">
				<div id="adsDeleteConsole_<?php echo $line[id];?>"></div>
				<a href="javascript: void(0)" >
				<div class="myadsListImg">
				<p>
				<?php if(empty($line[resim])){?>
					<img src="img/ads.jpg" alt="">
				<?php }else{?>
					<img src="ads/small_<?php echo $line[resim];?>" alt="">
				<?php }?>
				</p>
				</div>
				
				<div class="myadsListInfo">
					<?php echo $line[baslik];?><br>
					<?php echo $line[fiyat];?><br>
					<?php echo $line[ulke];?> / <?php echo $line[sehir];?> / <?php echo $line[ilce];?>
				</div>
				</a>
				<div class="load_myadsListEdit"  id="adsIdDel_<?php echo $line[id];?>">
					<a href="javascript: void(0)" ><?php echo FORM_DELETE;?></a>
				</div>
				<div class="clear"></div>
			</div>
			<?php }?>
			<br><div class="clear"></div>
<?php
} if($what=='fullmyads')
{
?>
<p id="myAdsEditFormConsole"></p>
			<?php 
				$query = "SELECT * FROM ads where id='".$_GET['myadsid']."' ORDER BY id desc";
				$result = mysql_query ($query) or die ("hata");
				$line = mysql_fetch_array($result); 
			?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#myAdsEditFormConsole').hide();
			$("#myAdsEditForm").click(function(){
				$('#myAdsEditFormConsole').slideUp();
				$.post('ajaxeditmyads.php',{
				
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
					whatsadsid: $('[name=ads_whatsadsid]').val(),

					adsfullname: $('[name=ads_adsfullname]').val(),
					adsemail: $('[name=ads_adsemail]').val(),
					adshome: $('[name=ads_adshome]').val(),
					adsmobile: $('[name=ads_adsmobile]').val(),
					infosee: $('[name=ads_infosee]:checkbox:checked').val()

					},
					function(data){
						if(data.success)
						{
							$('#myAdsEditFormConsole').html(data.message).slideDown();
						}else{
							$('#myAdsEditFormConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
			
			$('.buttons > a').click(function(){
				var parent  = $(this).parent();
				var getmyImgDel   =  parent.attr('id').replace('button_','');
						
				var answer = confirm ("<?php echo FORM_DO_YOU_WANT_DELETE;?>")
				if (answer){

				$.post('ajaxadsdel.php',{
					what: "imgdelete",
					adsId: getmyImgDel
					},
					function(data){
						if(data.success)
						{
							$('#button_'+getmyImgDel).slideUp();
						}
					}, 'json');
				}
				return false;
			});
		});
	</script>
			
			<form method="post" name="myAdsEditForm" class="oneForm editadsform">
			<h1><?php echo FORM_EDIT_ADS;?></h1>
				<?php echo $line[tarih];?><br>
				<label><?php echo LOAD_CATEGORIES;?></label>
				<select name="ads_kategori">
					<option value="0"><?php echo LOAD_SELECT_CATEGORIES;?></option>
					<?php 
						$querycat = "SELECT * FROM category where lang='1' ORDER BY id";
						$resultcat = mysql_query ($querycat) or die ("hata");
							echo '<li><a href="">Tum kategoriler</a></li>';
						while ($linecat = mysql_fetch_array($resultcat)) 
						{
							if($linecat[id]==$line[kategori]){$selected= "selected";}else{$selected= "";}
							echo '<option value="'.$linecat[id].'" '.$selected.'>'.$linecat[category].'</option>';
						}
					?>
				</select><br>
				<div class="clear"></div>
				<label><?php echo LOAD_TITLE;?></label><input name="ads_baslik" type="text" value="<?php echo $line[baslik];?>"><br>
				<label><?php echo LOAD_DESC;?></label><textarea name="ads_aciklama" cols="" rows=""><?php echo $line[aciklama];?></textarea><br>
				<label><?php echo LOAD_COUNTRY;?></label><input name="ads_ulke" type="text" value="<?php echo $line[ulke];?>"><br>
				<label><?php echo LOAD_CITY;?></label><input name="ads_sehir" type="text" value="<?php echo $line[sehir];?>"><br>
				<label><?php echo LOAD_DISTRICT;?></label><input name="ads_ilce" type="text" value="<?php echo $line[ilce];?>"><br>
				<label><?php echo LOAD_PRICE;?></label><input name="ads_fiyat" type="text" value="<?php echo $line[fiyat];?>"><br>
				
				<label><?php echo LOAD_WHOME;?></label><?php echo LOAD_OWNER;?><input name="ads_kimden" type="radio" value="0" <?php if($line[kimden]==0){echo "checked";}?>> <?php echo LOAD_DEALER;?><input name="ads_kimden" type="radio" value="1"<?php if($line[kimden]==1){echo "checked";}?>><br>
				<div class="clear"></div>
				<label><?php echo LOAD_STATUS;?></label><?php echo LOAD_NEW;?><input name="ads_durumu" type="radio" value="0" <?php if($line[durumu]==0){echo "checked";}?>> <?php echo LOAD_OLD;?><input name="ads_durumu" type="radio" value="1"<?php if($line[durumu]==1){echo "checked";}?>><br>
				<div class="clear"></div>
				<label><?php echo LOAD_WARRANTY;?></label><?php echo LOAD_WARRANTY_YES;?><input name="ads_garanti" type="radio" value="0" <?php if($line[garanti]==0){echo "checked";}?>> <?php echo LOAD_WARRANTY_NO;?><input name="ads_garanti" type="radio" value="1"<?php if($line[garanti]==1){echo "checked";}?>><br>
				<div class="clear"></div>

				<label><?php echo FORM_FULLNAME;?></label><input name="ads_adsfullname" type="text" value="<?php echo $uye_baglan[fullname];?>"><br>
				<label><?php echo FORM_EMAIL;?></label><input name="ads_adsemail" type="text" value="<?php echo $uye_baglan[email];?>"><br>
				<label><?php echo FORM_HOME_TEL;?></label><input name="ads_adshome" type="text" value="<?php echo $uye_baglan[home];?>"><br>
				<label><?php echo FORM_MOBILE_TEL;?></label><input name="ads_adsmobile" type="text" value="<?php echo $uye_baglan[mobile];?>"><br>
				<label>&nbsp;</label><input name="ads_infosee" type="checkbox" value="1" <?php if($line[adsfullname]!=""){echo "checked";}?>> <?php echo FORM_SEE_INFO;?><br>
				
				<div class="clear"></div>
				<input name="ads_whatsadsid" type="hidden" value="<?php echo $line[id];?>">
				<label>&nbsp;</label><button id="myAdsEditForm" class="button"><span><?php echo FORM_SEVED_CHANGES;?></span></button>
			</form>
				<div class="clear"></div>
				
				<div class="imgUpload">
					<iframe height="100" src="pic.php?adsids=<?php echo $_GET['myadsid'];?>" width="80%" style=" padding:0; border:0; "></iframe>
	
					<div class="buttons" id="button_<?php echo $_GET['myadsid'];?>">
						<?php if(!empty($line[resim])){?>
							<a href="javascript: void(0)">sil</a>
						<div class="clear"></div>
							<img src="ads/<?php echo $line[resim];?>" alt="">
						<?php }?>
					</div>
				</div>

<?php
} if($what=='editpass')
{
?>
		<p id="changepassConsole"></p>
	<script>
		$(document).ready(function(){
			$('#changepassConsole').hide();
			$("#changepassForm").click(function(){
				$('#changepassConsole').slideUp();
				$.post('ajaxchangepass.php',{
					oldpass: $('[name=changepass_oldpass]').val(),
					newpass: $('[name=changepass_newpass]').val(),
					repnewpass: $('[name=changepass_repnewpass]').val()
					},
					function(data){
						if(data.success)
						{
							$('#changepassConsole').html(data.message).slideDown();
							$('[name=changepass_oldpass]').val('');
							$('[name=changepass_newpass]').val('');
							$('[name=changepass_repnewpass]').val('');
						}else{
							$('#changepassConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
		});
	</script>
		<form method="post" name="changepassForm" class="oneForm">
		<h1><?php echo FORM_CHANGES_PASS;?></h1>
			<label><?php echo FORM_OLD_PASSWORD;?></label><input name="changepass_oldpass" type="password"/><br>
			<label><?php echo FORM_NEWPASSWORD;?></label><input name="changepass_newpass" type="password"/><br>
			<label><?php echo FORM_REPNEWPASSWORD;?></label><input name="changepass_repnewpass" type="password"/><br>
			<label>&nbsp;</label><button id="changepassForm" class="button"><span><?php echo FORM_NOW_CHANGES_PASS;?></span></button>
		</form>


<?php
} if($what=='messages')
{
?>
<?php if($where=='write'){?>
<p id="messagesFormConsole"></p>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#messagesFormConsole').hide();
			$('#messagesForm').click(function(){
				$('#messagesFormConsole').slideUp();
				$.post('ajaxmessages.php',{
					title: $('input[name=message_title]').val(),
					messages: $('[name=message_messages]').val(),
					whom: $('input[name=message_whom]').val()
					},
					function(data){
						if(data.success)
						{
							$('#messagesFormConsole').html(data.message).slideDown();
						}else{
							$('#messagesFormConsole').html(data.message).slideDown();
						}

					}, 'json');
				return false;
			});
		});
	</script>
		<form method="post" name="messagesForm" class="oneForm">
		<h1>Mesaj yaz</h1>
		<?php
		$senderwho = mysql_query("select username from users where id='".$_GET['whoId']."' ");
		$whoLine = mysql_fetch_array($senderwho);
		?>
			<label><?php echo AJAX_MESSAGES_WHOM;?></label><input name="" type="text" value="<?php echo $whoLine['username'];?>" disabled><br>
			<label><?php echo AJAX_MESSAGES_WHO_TITLE;?></label><input name="message_title" type="text"><br>
			<label><?php echo AJAX_MESSAGES_WHO_MESSAGES;?></label><textarea name="message_messages" cols="" rows=""></textarea><br>
			<input name="message_whom" type="hidden" value="<?php echo $_GET['whoId'];?>">
			<label>&nbsp;</label><button id="messagesForm" class="button"><span><?php echo AJAX_MESSAGES_SEND;?></span></button>   
		</form>
<?php }else if($where=='read'){?>

<?php }?>


<?php
}
?>

<?php ob_end_flush(); ?>
