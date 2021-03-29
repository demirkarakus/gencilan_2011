<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(0,@$_SESSION['status']);

if(isset($_POST)){

	if($_POST['usernameoremail'] == ""){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITEAUSERNAMEOREMAIL."</div>"; }
	else{
	// üye mail adresini giricek ve o mail adresi kiminse o kiþiye random ile yeni bir sifre gönderilecek.	
	$nick = guvenlik($_POST['usernameoremail']);
	
	$uyesorgula = mysql_query("select email,fullname,username,confirmation from users where username='".$nick."' or email='".$nick."'");
	$uyebaglan = mysql_fetch_array($uyesorgula);
	$uyesay = mysql_num_rows($uyesorgula);
	
	if($uyesay>0){
	
		$randoms = kod(26);
		
		$codetable = "update users set confirmation='".$randoms."' where email = '".$uyebaglan['email']."' "; 
		$codekayit = mysql_query($codetable);

		if(isset($codekayit))
		{
			$header = "Content-type: text/html; charset=".CHARSET."\n";
			$header .= "From: ".WEB_SITES." <".MAIL_MAIL.">\n";
			$header .= "Reply-To: ".WEB_SITES." <".MAIL_MAIL.">"; 
			$baslik = 'E-Posta Onay Kodu';
			
			$mesaj = $uyebaglan['username'].'<br><br>';
			$mesaj .= '<br><br>';
			$mesaj .= '<a href="'.WEB_SITES.'/ok.php?code='.$randoms.'">Onay Linki</a>'.'<br><br>';
			$mesaj .= $randoms.' Onay Kodu<br><br>';
			$mesaj .= 'Onay Kodunu Ana Sayfadaki Beni Onayla Bolumunden onaylayabilirsiniz.<br><br>';
		
			mail($uyebaglan['email'], $baslik, $mesaj, $header);
		}

		$data['success'] = true; $data['message'] = "<div class=\"note\">".AJAX_VERIFY_CODE_SENDED."</div>";
	} else { $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRONG_USERNAMEOREMAIL."</div>";}

	}
	
	echo json_encode($data);
}
?>