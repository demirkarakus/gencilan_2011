<div class="container">
<div class="header">
	<div class="header_top">
	<p class="logo"><a href="index.php"><img src="img/logo.png" border="0"></a></p>
	<ul class="menu_top">
		<?php if(!isset($_SESSION['status'])){ ?>
			<?php echo HEADER_YOU_DO;?>
			<?php echo HEADER_REGISTER;?>
			<?php echo HEADER_DO_OR;?>
			<?php echo HEADER_LOGIN;?>
		<?php } else {?>
			<?php echo HEADER_LOGOUT;?>
			<?php echo HEADER_EDITPROFILE;?>
			<?php echo HEADER_MYADS;?>
			<?php echo HEADER_WELCOME;?>
			<?php if($_SESSION['bigboss']==1){
				$toplamyeniilan = @mysql_query("select count(*) from ads where uyeonayi = '0' ");
				$toplamyeniilan = @mysql_result($toplamyeniilan, 0);
			?>
				<li><?php echo $toplamyeniilan;?> Yeni ilan var | </li>
			<?php }?>
		<?php }?>
	</ul>
	<div class="menu_bottom">
		<ul>
		<?php if(!isset($_SESSION['status'])){ ?>
			<li class="load_onayla"><a class="button" href="#"><span><?php echo HEADER_VERIFY_ME;?></span></a></li>
		<?php }?>
			<li class="load_plusads"><a class="button" href="#"><span><?php echo HEADER_ADD_ADS;?></span></a></li>
		</ul>
	</div>
	
	</div>
	
	<div class="menu">
		<ul>
			<?php 
					$query = "SELECT * FROM category where lang='1' ORDER BY id";
					$result = mysql_query ($query) or die ("hata");
						echo '<li><a href="index.php">Tum kategoriler</a></li>';
					while ($line = mysql_fetch_array($result)) 
					{
						echo '<li><a href="index.php?cat='.$line[id].'">'.$line[category].'</a></li>';
					}
			?>
		</ul>
	</div>
</div>
</div>