<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(0,$_SESSION['status']);

if(isset($_POST)){
	$codePost = guvenlik($_POST['code']);

	$uye_sor = mysql_query("SELECT confirmation FROM users where confirmation='".$codePost."' ");
	$uye_sor_say = mysql_num_rows($uye_sor);
	$uye_sor_baglan = mysql_fetch_array($uye_sor);

	if($uye_sor_say==0 || $uye_sor_baglan['confirmation']==1){
		$data['success'] = true;
		$data['message'] = "<div class=\"error\">".AJAX_WRITE_YOUR_WRONG_CODE."</div>";
	}

	$whosayuser = @mysql_query("select count(*) from users where confirmation='".$codePost."' ");
	$whosayuser = @mysql_result($whosayuser, 0);

	if($whosayuser>0){

		$uyesorgula = mysql_query("select id,email,username from users where confirmation='".$codePost."' ");
		$uyebaglan = mysql_fetch_array($uyesorgula);
		$uyesay = mysql_num_rows($uyesorgula);

		$_SESSION['status']=1;
		$_SESSION['myid']=$uyebaglan['id'];
		$_SESSION['myadsphotouserid']=$uyebaglan['id'];
		$_SESSION['email']=$uyebaglan['email'];
		$_SESSION['mynick']=$uyebaglan['username'];
		$_SESSION['confirmation']=1;
		
		$ip = $_SERVER['REMOTE_ADDR'];
		mysql_query("update users set ip='".$ip."' where email = '".$_SESSION['email']."' "); 

		$codetable = "update users set confirmation=1 where confirmation='".$codePost."' "; 
		$codekayit = mysql_query($codetable);

		$ilaninionayla = "update ads set uyeonayi=1 where uid='".$_SESSION['myid']."' "; 
		$ilanitamamladik = mysql_query($ilaninionayla);
		
		$data['success'] = false;
		$data['redirect'] = "index.php";
		
	}
}
echo json_encode($data);
?>