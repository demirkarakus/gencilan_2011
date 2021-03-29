<?php
// POSTING GUVENLIK
function guvenlik($yolda) //sayýlarda kullanýmýyoruz(integer)
{

	$posting = $yolda;
	$simdiki = mysql_escape_string($posting);

	return($simdiki);
}
// POSTING GUVENLIK END

// RASGELE KOD
function kod($uzunluk) {
  $karakterler = array();
  $karakterler = array_merge(range(0,9),range('a','z'),range('A','Z'));
  srand((float)microtime()*100000);
  shuffle($karakterler);
  $sonuc = '';
  for($i=0;$i<$uzunluk;$i++)
  {
    $sonuc .= $karakterler[$i];
  }
  unset($karakterler);
  return ($sonuc);
}  
// RASGELE KOD END

// ÜYE GÝRÝÞ YAPTIMI BAKIYORUZ
function kontrolet($derece,$status)
{
	if($derece==0) //derece 1 olursa kullanýcý giriþ yapmýþ demektir, 0 olursa giriþ yapýlmamýþ demektir.
	{
		if(isset($status)){
			header("Location: index.php"); break;
		}
	} else if($derece==1) {
		if(!isset($status)) {
			header("Location: index.php"); break;
		}
	}
}
// ÜYE GÝRÝÞ YAPTIMI BAKIYORUZ END

// SMALL TEXT
function strLonger($subject,$start,$end)
{
if(strlen($subject) > $end) $subject = substr($subject, $start, $end) . "...";
return($subject);
}
// SMALL TEXT END

function clickable_link($text = '')
{
	$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
	$ret = ' ' . $text;
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
		
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
	$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
	$ret = substr($ret, 1);

	include "editstr.php";

	return $ret;
}
?>