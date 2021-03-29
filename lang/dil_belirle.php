<?php 

$dil_ayar['tr'] = array('turkce','T&uuml;rk&ccedil;e','tr.png','1');

define("DIL_KLASOR",'lang');

@ $gelen_dil = $_REQUEST['dil'];
@ $oturum_dil = $_SESSION['oturum_dil'];
@ $varsayilan_dil = 'tr';
@ $varsayilan_dil_sesion = '1';

$site_dil = $varsayilan_dil;
$_SESSION['lang_num'] = $varsayilan_dil_sesion = '1';

if (empty($gelen_dil))
{
	if (!empty($oturum_dil))
	{
		$site_dil = $oturum_dil;
		$_SESSION['lang_num'] = $dil_ayar["$site_dil"][3];
	}
} else {
	if (is_array($dil_ayar[$gelen_dil]))
	{
		$site_dil = $gelen_dil;
		$_SESSION['oturum_dil'] = $gelen_dil;
		$_SESSION['lang_num'] = $dil_ayar["$site_dil"][3];
	}
}

$dil_dosyasi = DIL_KLASOR."/".$dil_ayar["$site_dil"][0]."/genel.php";

if (file_exists($dil_dosyasi))
{
	include ($dil_dosyasi);
}else{
	include(DIL_KLASOR."/".$dil_ayar["$varsayilan_dil"][0]."/genel.php"); // Dil dosyasý bulunamaz ise bu dosyayý include edicek
}
?>