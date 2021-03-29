<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(1,$_SESSION['status']);

if(isset($_POST)){

		if($_POST['kategori']==0){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SELECT_CATEGORY."</div>"; }
		else if(strlen($_POST['baslik'])<3 || strlen($_POST['baslik'])>100){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_TITLE."</div>"; }
		else if(strlen($_POST['aciklama'])<3){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_DESC."</div>"; }
		else if(strlen($_POST['ulke'])<3 || strlen($_POST['ulke'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_COUNTRY."</div>"; }
		else if(strlen($_POST['sehir'])<3 || strlen($_POST['sehir'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_CITY."</div>"; }
		else if(strlen($_POST['ilce'])<3 || strlen($_POST['ilce'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_DISTRICT."</div>"; }
		else if(strlen($_POST['fiyat'])<1 || strlen($_POST['fiyat'])>12){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_PRICE."</div>"; }
		
		else{
		$baslik = guvenlik($_POST['baslik']);
		$aciklama = guvenlik($_POST['aciklama']);
		$ulke = guvenlik($_POST['ulke']);
		$sehir = guvenlik($_POST['sehir']);
		$ilce = guvenlik($_POST['ilce']);
		$fiyat = guvenlik($_POST['fiyat']);
		
		$dt = date("Y-m-d G:i:s");

		if($_POST['infosee']==1){
			$adsfullname = guvenlik($_POST['adsfullname']);
			$adsemail = guvenlik($_POST['adsemail']);
			$adshome = guvenlik($_POST['adshome']);
			$adsmobile = guvenlik($_POST['adsmobile']);
		}else{
			$adsfullname = "";
			$adsemail = "";
			$adshome = "";
			$adsmobile = "";
		}
	
	
		$tablo = "update ads set kategori='$_POST[kategori]', baslik='$baslik', aciklama='$aciklama', ulke='$ulke', sehir='$sehir', ilce='$ilce', fiyat='$fiyat', kimden='$_POST[kimden]', durumu='$_POST[durumu]', garanti='$_POST[garanti]', tarih='$dt' , adsfullname='$adsfullname' , adsemail='$adsemail' , adshome='$adshome', adsmobile='$adsmobile', adminonayi='0' where uid = '".$_SESSION['myid']."' and id='".$_POST['whatsadsid']."' ";
		$kayit = mysql_query($tablo);
		
		$data['success'] = true;
		$data['message'] = "<div class=\"note\">".AJAX_SAVED."</div>";
		}
		
	echo json_encode($data);
}


?>