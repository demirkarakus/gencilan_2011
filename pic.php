<?php
session_start();
include "lang/dil_belirle.php";
include"mainfunctions.php";
include"setting.php";


$change="";
$abc="";

define ("MAX_SIZE","4000");

function resample($resim,$max_en,$max_boy)
     {

     # Icerik icin kesi baslat ...
     ob_start();

     # Ilk boyutlar
     $boyut = getimagesize($resim);
     $en    = $boyut[0];
     $boy   = $boyut[1];

     # Yeni boyutlar
     $x_oran = $max_en  / $en;
     $y_oran = $max_boy / $boy;

     if (($en <= $max_en) and ($boy <= $max_boy)){
        $son_en  = $en;
        $son_boy = $boy;
        }
     else if (($x_oran * $boy) < $max_boy){
        $son_en  = $max_en;
        $son_boy = ceil($x_oran * $boy);
        }
     else {
        $son_en  = ceil($y_oran * $en);
        $son_boy = $max_boy;
        }

     # Eski ve yeni resimler
     $eski = imagecreatefromjpeg($resim);
     $yeni = imagecreatetruecolor($son_en,$son_boy);

     # Eski resmi yeniden orneklendir
     @imagecopyresampled(
        $yeni,$eski,0,0,0,0,
        $son_en,$son_boy,$en,$boy);

     # Yeni resmi bas ve icerigi cek
     @imagejpeg($yeni,null,-1);
     $icerik = ob_get_contents();

     # Resimleri yoket ve icerigi cikart
     ob_end_clean();
     @imagedestroy($eski);
     @imagedestroy($yeni);

     return $icerik;

}

function getExtension($str) {
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
return $ext;
}

$errors=0;

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['adsids']))
{
	$image =$_FILES["file"]["name"];
	$uploadedfile = $_FILES['file']['tmp_name'];
	
	if(!empty($image) && !empty($uploadedfile)){
	
	if ($image) 
 	{
	
		$filename = stripslashes($_FILES['file']['name']);
		
		$extension = getExtension($filename);
		$extension = strtolower($extension);
		
		if (($extension != "jpg") && ($extension != "jpeg")) 
 		{
 			$change='<div class="msgdiv">'.PIC_ONLY_JPG.'</div> ';
 			$errors=1;
 		}
 		else
 		{
			$size=filesize($_FILES['file']['tmp_name']);


			if ($size > MAX_SIZE*1024)
			{
				$change= PIC_VERY_BIG_SIZE;
				$errors=1;
			}


			if($extension=="jpg" || $extension=="jpeg" )
			{
			$uploadedfile = $_FILES['file']['tmp_name'];
			$src = imagecreatefromjpeg($uploadedfile);
			
			}
			else if($extension=="png")
			{
			$uploadedfile = $_FILES['file']['tmp_name'];
			$src = imagecreatefrompng($uploadedfile);
			
			}
			else 
			{
			$src = imagecreatefromgif($uploadedfile);
			}

			echo $scr;

			list($width,$height)=getimagesize($uploadedfile);
			
			$newwidth=460;
			$newheight=($height/$width)*$newwidth;
			$tmp=imagecreatetruecolor($newwidth,$newheight);
			
			
			 # Yeni boyutlar
			 $en=$width;
			 $boy=$height;
			 $max_en=136;
 			 $max_boy=80;
			 
			 $x_oran = $max_en  / $en;
			 $y_oran = $max_boy / $boy;
		
			 if (($en <= $max_en) and ($boy <= $max_boy)){
				$son_en  = $en;
				$son_boy = $boy;
			}
			 else if (($x_oran * $boy) < $max_boy){
				$son_en  = $max_en;
				$son_boy = ceil($x_oran * $boy);
			}
			 else {
				$son_en  = ceil($y_oran * $en);
				$son_boy = $max_boy;
			}
			$tmp1=imagecreatetruecolor($son_en,$son_boy);
			imagecopyresampled($tmp1,$src,0,0,0,0,$son_en,$son_boy,$width,$height);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
			
			$filename = "ads/".$_SESSION['myadsphotouserid']."_".$_GET['adsids'].".jpg";
			$filename1 = "ads/small_".$_SESSION['myadsphotouserid']."_".$_GET['adsids'].".jpg";
			$big = $_SESSION['myadsphotouserid']."_".$_GET['adsids'].".jpg";



			imagejpeg($tmp,$filename,100);
			imagejpeg($tmp1,$filename1,100);
			
			imagedestroy($src);
			imagedestroy($tmp);
			imagedestroy($tmp1);
			}
		}
		}else{ $errors=1; $change=PIC_PLEASE_SELECT_IMAGE;}
}

// If no errors registred, print the success message
if(isset($_POST['Submit']) && $errors!=1) 
{	

		mysql_query("update ads set resim='".$big."', adminonayi='".$_SESSION['bigboss']."' where uid='".$_SESSION['myadsphotouserid']."' and id='".$_GET['adsids']."' ");
		$change='<div class=\"note\">'.PIC_IMGAGE_SAVED.'</div>';
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<meta content="en-us" http-equiv="Content-Language">

<title></title>
	
</head><body>
<p><?php echo $change;?></p>
<form method="post" action="" enctype="multipart/form-data" name="form1">
	<input name="file" type="file" /> 
	<input type="submit" value="Yukle" name="Submit"/>
</form>
</body></html>


