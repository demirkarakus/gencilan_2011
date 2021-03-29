<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(1,$_SESSION['status']);

if(isset($_POST)){

	if($_POST['oldpass'] == ""){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_OLDPASS."</div>"; }
	else if($_POST['newpass'] == ""){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_NEWPASS."</div>"; }
	else if($_POST['repnewpass'] == ""){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_REPNEWPASS."</div>"; }
	else if($_POST['newpass'] != $_POST['repnewpass']){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_NEWNOTREP."</div>";}
	else if(strlen($_POST['newpass'])<6 || strlen($_POST['newpass'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SMALLPASS."</div>";}
	else{
	
	$sifrekimin_result = mysql_query("select password,username from users where id = '".$_SESSION['myid']."' and email='".$_SESSION['email']."' ");
	$sifrem_row = mysql_fetch_array($sifrekimin_result);
	
	$oldpass=md5($_POST['oldpass']);
	$pass=md5($_POST['newpass']);		
	
		if($oldpass == $sifrem_row['password']){
			$tablo = "update users set password = '$pass' where id = '".$_SESSION['myid']."' and email='".$_SESSION['email']."' ";
			$kayit = mysql_query($tablo);
			
			$data['success'] = true;
			$data['message'] = "<div class=\"note\">".AJAX_SAVED."</div>";
			
		}else{
			$data['success'] = false;
			$data['message'] = "<div class=\"error\">".AJAX_PASSWORDNOTEQUAL."</div>";
		}
	}
	
	echo json_encode($data);
}
?>