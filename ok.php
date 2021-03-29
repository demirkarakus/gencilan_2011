<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";

kontrolet(0,$_SESSION['status']);

$codeGet=$_GET['code'];

$uye_sor = mysql_query("SELECT confirmation FROM users where confirmation='".$codePost."' or confirmation='".$codeGet."' ");
$uye_sor_say = mysql_num_rows($uye_sor);
$uye_sor_baglan = mysql_fetch_array($uye_sor);

if($uye_sor_say==0 || $uye_sor_baglan['confirmation']==1){header("Location: index.php"); break;

}else{
	$whosayuser = @mysql_query("select count(*) from users where confirmation='".$codePost."' or confirmation='".$codeGet."' ");
	$whosayuser = @mysql_result($whosayuser, 0);
	
	if($whosayuser>0){
		$codetable = "update users set confirmation=1 where confirmation='".$codePost."' or confirmation='".$codeGet."' "; 
		$codekayit = mysql_query($codetable);

		$uyesorgula = mysql_query("select id,email,username from users where confirmation='".$codePost."' or confirmation='".$codeGet."' ");
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

		header("Location: index.php"); break;
	}
}
?>