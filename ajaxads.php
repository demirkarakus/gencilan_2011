<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

if(isset($_POST)){

	if($_POST['infosee']==1){
		$adsfullname = guvenlik($_POST['fullname']);
		$adsemail = guvenlik($_POST['adsemail']);
		$adshome = guvenlik($_POST['adshome']);
		$adsmobile = guvenlik($_POST['adsmobile']);
	}else{
		$adsfullname = "";
		$adsemail = "";
		$adshome = "";
		$adsmobile = "";
	}

	if(!isset($_SESSION['status']))
	{
		$t_email = @mysql_query("select count(*) from users where email = '".$_POST['email']."'");
		$t_email = @mysql_result($t_email, 0);
		$t_nick = @mysql_query("select count(*) from users where username = '".$_POST['username']."'");
		$t_nick = @mysql_result($t_nick, 0);
	
		if($_POST['kategori']==0){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SELECT_CATEGORY."</div>"; }
		else if(strlen($_POST['baslik'])<3 || strlen($_POST['baslik'])>100){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_TITLE."</div>"; }
		else if(strlen($_POST['aciklama'])<3){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_DESC."</div>"; }
		else if(strlen($_POST['ulke'])<3 || strlen($_POST['ulke'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_COUNTRY."</div>"; }
		else if(strlen($_POST['sehir'])<3 || strlen($_POST['sehir'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_CITY."</div>"; }
		else if(strlen($_POST['ilce'])<3 || strlen($_POST['ilce'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_DISTRICT."</div>"; }
		else if(strlen($_POST['fiyat'])<1 || strlen($_POST['fiyat'])>12){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_PRICE."</div>"; }
	
		else if($t_nick  != 0){ $data['success'] = false; $data['message'] ="<div class=\"error\">".AJAX_REGISTRED_NICK."</div>"; }
		else if($t_email != 0){ $data['success'] = false; $data['message'] ="<div class=\"error\">".AJAX_REGISTRED_EMAIL."</div>"; }
		else if(strlen($_POST['fullname'])<3 || strlen($_POST['fullname'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SMALL_FULLNAME."</div>"; }
		else if(strlen($_POST['username'])<3 || strlen($_POST['username'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SMALL_USERNAME."</div>"; }
		else if(ereg('[^A-Za-z0-9]',$_POST['username'])) { $data['success'] = false; $data['message'] ="<div class=\"error\">".AJAX_NONTR."</div>"; }
		else if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$_POST['email'])) {$data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_A_EMAIL."</div>";}	
		else if($_POST['password']==''){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITEYOURPASSWORD."</div>";}
		else if(strlen($_POST['password'])<6 || strlen($_POST['password'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SMALLPASS."</div>";}
		else{

		$baslik = guvenlik($_POST['baslik']);
		$aciklama = guvenlik($_POST['aciklama']);
		$ulke = guvenlik($_POST['ulke']);
		$sehir = guvenlik($_POST['sehir']);
		$ilce = guvenlik($_POST['ilce']);
		$fiyat = guvenlik($_POST['fiyat']);

		$namesurname = guvenlik($_POST['fullname']);
		$nickbig = guvenlik($_POST['username']);
		$nick = strtolower($nickbig);
		$eposta = guvenlik($_POST['email']);
		$pass = guvenlik($_POST['password']);
		$pass=md5($pass);
		
		$useradshome = guvenlik($_POST['adshome']);
		$useradsmobile = guvenlik($_POST['adsmobile']);

		$ip = $_SERVER['REMOTE_ADDR'];
		$dt = date("Y-m-d G:i:s");
		$randoms = kod(26);
		
		$table = "INSERT INTO users (id,username,fullname,email,password,home,mobile,tarih,confirmation,ip,admin) 
		VALUES ('','$nick','$namesurname','$eposta','$pass','$useradshome','$useradsmobile','$dt','$randoms','$ip','0')";
		$kayit = mysql_query($table);
		$sonuye_id=mysql_insert_id();		
		
		$tableads = "INSERT INTO ads (id,uid,kategori,baslik,aciklama,ulke,sehir,ilce,fiyat,kimden,durumu,garanti,tarih,adsfullname,adsemail,adshome,adsmobile,uyeonayi,adminonayi) 
		VALUES ('','$sonuye_id','$_POST[kategori]','$baslik','$aciklama','$ulke','$sehir','$ilce','$fiyat','$_POST[kimden]','$_POST[durumu]','$_POST[garanti]','$dt','$adsfullname','$adsemail','$adshome','$adsmobile','0','0')";
		$kayitads = mysql_query($tableads);

		if(isset($kayit))
		{
			$header = "Content-type: text/html; charset=".CHARSET."\n";
			$header .= "From: ".WEB_SITES." <".MAIL_MAIL.">\n";
			$header .= "Reply-To: ".WEB_SITES." <".MAIL_MAIL.">"; 
			$baslik = 'Tebrikler Uye Oldunuz.';
			
			$mesaj =  $namesurname.'<br><br>';
			$mesaj .= $nickbig.'<br><br>';
			$mesaj .= '<br><br>';
			$mesaj .= '<a href="'.WEB_SITES.'/ok.php?code='.$randoms.'">Onay Linki</a>'.'<br><br>';
			$mesaj .= $randoms.' Onay Kodu<br><br>';
			$mesaj .= 'Onay Kodunu Ana Sayfadaki Beni Onayla Bolumunden onaylayabilirsiniz.<br><br>';
		
			mail($eposta, $baslik, $mesaj, $header);
		}

		$data['success'] = true;
		$data['message'] = "<div class=\"note\">".AJAX_ADS_OK_YOURREGISTRATIONISOKAY."</div>";
		
		$_SESSION['myadsphotouserid']=$sonuye_id;
		}

	}else{
	
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
		
		$tableads = "INSERT INTO ads (id,uid,kategori,baslik,aciklama,ulke,sehir,ilce,fiyat,kimden,durumu,garanti,tarih,adsfullname,adsemail,adshome,adsmobile,uyeonayi,adminonayi) 
		VALUES ('','$_SESSION[myid]','$_POST[kategori]','$baslik','$aciklama','$ulke','$sehir','$ilce','$fiyat','$_POST[kimden]','$_POST[durumu]','$_POST[garanti]','$dt','$adsfullname','$adsemail','$adshome','$adsmobile','1','".$_SESSION['bigboss']."')";
		$kayitads = mysql_query($tableads);
		
		$data['success'] = true;
		$data['message'] = "<div class=\"note\">".AJAX_WRITE_SENDED_ADS."</div>";
		}
		
	}
	echo json_encode($data);
}


?>