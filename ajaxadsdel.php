<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(1,$_SESSION['status']);

if($_POST['what']=="adsdelete"){

	$resimsec = "SELECT * FROM ads where uid = '".$_SESSION['myid']."' and id = '".$_POST['adsId']."' ";
	$resimsecsonuc = mysql_query ($resimsec) or die ("hata");
	$resimsecbaglan = mysql_fetch_array($resimsecsonuc);
	$img = $resimsecbaglan[resim];
	
	@unlink("ads/".$img);
	@unlink("ads/small_".$img);
	
	mysql_query("delete from ads where uid = '".$_SESSION['myid']."' and id = '".$_POST['adsId']."' ");

	$data['success'] = true;
	
	echo json_encode($data);
}

if($_POST['what']=="imgdelete"){

	$resimsec = "SELECT * FROM ads where uid = '".$_SESSION['myid']."' and id = '".$_POST['adsId']."' ";
	$resimsecsonuc = mysql_query ($resimsec) or die ("hata");
	$resimsecbaglan = mysql_fetch_array($resimsecsonuc);
	$img = $resimsecbaglan[resim];
	
	@unlink("ads/".$img);
	@unlink("ads/small_".$img);
	
	$tablo = "update ads set resim='' where uid = '".$_SESSION['myid']."' and id = '".$_POST['adsId']."' ";
	$kayit = mysql_query($tablo);
	
	$data['success'] = true;
	
	echo json_encode($data);
}

?>