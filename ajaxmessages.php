<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(1,$_SESSION['status']);

if(isset($_POST)){

	if(strlen($_POST['title'])<3 || strlen($_POST['title'])>100){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_MESSAGES_TITLE."</div>"; }
	else if(strlen($_POST['messages'])<3){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_MESSAGES."</div>"; }
	else{
	
	$title = guvenlik($_POST['title']);
	$messages = guvenlik($_POST['messages']);
	$dt = date("Y-m-d G:i:s");
	
	$topicUser_sor = mysql_query("select email,username,email from users where id='".$_POST['whom']."' ");
	$topicUserLine = mysql_fetch_array($topicUser_sor);
	$topicUserSay = mysql_num_rows($topicUser_sor);	
	
	$senderUser_sor = mysql_query("select id,username from users where id='".$_SESSION['myid']."' ");
	$senderLine = mysql_fetch_array($senderUser_sor);

	if($topicUserSay > 0 && $_POST['whom']!=$_SESSION['myid'])
	{
		$header = "Content-type: text/html; charset=".CHARSET."\n";
		$header .= "From: ".WEB_SITES." <".MAIL_MAIL.">\n";
		$header .= "Reply-To: ".WEB_SITES." <".MAIL_MAIL.">"; 
		$baslik = "Yeni Mesaj";
			
		$mesaj = AJAX_MESSAGES_WHO." : ".$topicUserLine['username'].'<br><br>';
		$mesaj .= AJAX_MESSAGES_WHO_EMAIL." : ".$topicUserLine['email'].'<br><br>';
		$mesaj .= AJAX_MESSAGES_WHO_TITLE." : ".$title."<br><br>";
		$mesaj .= AJAX_MESSAGES_WHO_MESSAGES." : ".$messages."<br><br>";
		
		mail($topicUserLine['email'], $baslik, $mesaj, $header);
		
		$data['success'] = true;
		$data['message'] = "<div class=\"note\">Mesaj&#305;n&#305;z e-posta olarak g&ouml;nderildi.</div>";	
	}
	/*
	$table = "INSERT INTO messages (id,who,whom,title,messages,yer,durum,dt) 
	VALUES ('','$_SESSION[myid]','$_POST[whom]','$title','$messages','1','1','$dt')";
	$saved = mysql_query($table);
	
	$tablo = "INSERT INTO messages (id,who,whom,title,messages,yer,durum,dt) 
	VALUES ('','$_SESSION[myid]','$_POST[whom]','$title','$messages','2','1','$dt')";
	$kayit = mysql_query($tablo);
	*/
	}
	echo json_encode($data);
}


?>