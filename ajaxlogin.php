<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(0,@$_SESSION['status']);

if(isset($_POST)){

			
	if(empty($_POST['username'])){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITEAUSERNAMEOREMAIL."</div>"; }
	else if(empty($_POST['password'])){ $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRITEYOURPASSWORD."</div>";}
	else{
	
	$nick = guvenlik($_POST['username']);
	$pass = guvenlik($_POST['password']);
	$pass=md5($pass); 
	
	$uyesorgula = mysql_query("select id,email,username,confirmation,admin from users where (username='".$nick."' or email='".$nick."') and password='".$pass."'");
	$uyebaglan = mysql_fetch_array($uyesorgula);
	$uyesay = mysql_num_rows($uyesorgula);
	
	if($uyesay>0)
	{
	
		if($uyebaglan['confirmation']==1){
		
			$_SESSION['status']=1;
			$_SESSION['myid']=$uyebaglan['id'];
			$_SESSION['myadsphotouserid']=$uyebaglan['id'];
			$_SESSION['email']=$uyebaglan['email'];
			$_SESSION['mynick']=$uyebaglan['username'];
			$_SESSION['bigboss']=$uyebaglan['admin'];
			$_SESSION['confirmation']=1;
			
			$ip = $_SERVER['REMOTE_ADDR'];
			mysql_query("update users set ip='".$ip."' where email = '".$_SESSION['email']."' "); 

			$data['success'] = true;
			$data['redirect'] = $_SERVER['HTTP_REFERER'];

		} else { $data['success'] = false; $data['dogrulama'] = true; $data['message'] = "<div class=\"error\">".AJAX_EMAILCODE."</div>";}

	} else { $data['success'] = false; $data['message'] = "<div class=\"error\">".AJAX_WRONG_USERNAMEOREMAIL."</div>";}
	
	}
	
	echo json_encode($data);
}
?>