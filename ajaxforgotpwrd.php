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
	
	$uyesorgula = mysql_query("select email,fullname,username from users where username='$nick' or email='$nick'");
	$uyebaglan = mysql_fetch_array($uyesorgula);
	$uyesay = mysql_num_rows($uyesorgula);
	
	if($uyesay>0){
	
		$randoms = kod(6);
		$pass=md5($randoms); 
		
		$iptable = "update users set password='$pass' where email = '$uyebaglan[email]' "; 
		$ipkayit = mysql_query($iptable);
			
			if(isset($ipkayit))
			{
			$header = "Content-type: text/html; charset=".CHARSET."\n";
			$header .= "From: ".WEB_SITES." <".MAIL_MAIL.">\n";
			$header .= "Reply-To: ".WEB_SITES." <".MAIL_MAIL.">"; 
			$baslik = 'Yeni Sifreniz';
			
			$mesaj = $uyebaglan['username'].'<br><br>';
			$mesaj .= 'Yeni Sifreniz : '.$randoms.'<br><br>';
			$mesaj .= '<a href="'.WEB_SITES.'">WEB_SITES</a><br><br>';
		
			mail($uyebaglan['email'], $baslik, $mesaj, $header);
			}

		$data['success'] = true; $data['message'] = "<div class=\"note\">".AJAX_NEWPASSWORDSENDED."</div>";
	} else { $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRONG_USERNAMEOREMAIL."</div>";}

	}
	
	echo json_encode($data);
}
?>