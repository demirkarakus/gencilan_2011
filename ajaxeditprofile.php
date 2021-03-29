<?php
session_start();

include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(1,$_SESSION['status']);

if(isset($_POST)){

	
	$t_nick = @mysql_query("select count(*) from users where username = '".$_POST['username']."' and id != '".$_SESSION['myid']."' ");
	$t_nick = @mysql_result($t_nick, 0);
	$t_email = @mysql_query("select count(*) from users where email = '".$_POST['email']."' and id != '".$_SESSION['myid']."' ");
	$t_email = @mysql_result($t_email, 0);
	
	if($t_nick != 0){ $data['success'] = false; $data['message'] ="<div class=\"error\">".AJAX_REGISTRED_NICK."</div>"; }
	else if($t_email != 0){ $data['success'] = false; $data['message'] ="<div class=\"error\">".AJAX_REGISTRED_EMAIL."</div>"; }
	else if(strlen($_POST['fullname'])<3 || strlen($_POST['fullname'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SMALL_FULLNAME."</div>"; }
	else if(strlen($_POST['username'])<3 || strlen($_POST['username'])>26){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_SMALL_USERNAME."</div>"; }
	else if(ereg('[^A-Za-z0-9]',$_POST['username'])) { $data['success'] = false; $data['message'] ="<div class=\"error\">".AJAX_NONTR."</div>"; }
	else if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$_POST['email'])) {$data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITE_A_EMAIL."</div>";}
	else{
	
	$namesurname = guvenlik($_POST['fullname']);
	$nickbig = guvenlik($_POST['username']);
	$nick = strtolower($nickbig);
	$_SESSION['mynick']=$nick;
	$eposta = guvenlik($_POST['email']);
	
	$useradshome = guvenlik($_POST['adshome']);
	$useradsmobile = guvenlik($_POST['adsmobile']);
		
	$ip = $_SERVER['REMOTE_ADDR'];

	$tablo = "update users set username='$nick', fullname='$namesurname', home='$useradshome',mobile='$useradsmobile', confirmation='1', ip='$ip' where id = '".$_SESSION['myid']."' ";
	$kayit = mysql_query($tablo);
			
	$data['success'] = true;
	$data['message'] = "<div class=\"note\">".AJAX_SAVED."</div>";

	}


	echo json_encode($data);
}
?>