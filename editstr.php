<?php
$aranan   = array("", "\n", "\r");
$yerine_koy = '<br>';
$ret = str_replace($aranan , $yerine_koy, $ret);

$aranan   = array("\'", "\\", "\\");
$yerine_koy = '\'';
$ret = str_replace($aranan , $yerine_koy, $ret); 

$ret = str_replace("[BR]", "<br>", $ret);

$ret = str_replace("[B]", "<b>", $ret);
$ret = str_replace("[/B]", "</b>", $ret);

$ret = str_replace("[U]", "<u>", $ret);
$ret = str_replace("[/U]", "</u>", $ret);

$ret = str_replace("[I]", "<i>", $ret);
$ret = str_replace("[/I]", "</i>", $ret);

$ret = str_replace("[FONT=Arial]", "<font face=\"Arial\">", $ret);
$ret = str_replace("[FONT=Times]", "<font face=\"Times\">", $ret);
$ret = str_replace("[FONT=Courier]", "<font face=\"Courier\">", $ret);
$ret = str_replace("[FONT=Impact]", "<font face=\"Impact\">", $ret);
$ret = str_replace("[FONT=Geneva]", "<font face=\"Geneva\">", $ret);
$ret = str_replace("[FONT=Optima]", "<font face=\"Optima\">", $ret);
$ret = str_replace("[/FONT]", "</font>", $ret);

$ret = str_replace("[COLOR=blue]", "<font color=\"blue\">", $ret);
$ret = str_replace("[COLOR=red]", "<font color=\"red\">", $ret);
$ret = str_replace("[COLOR=purple]", "<font color=\"purple\">", $ret);
$ret = str_replace("[COLOR=orange]", "<font color=\"orange\">", $ret);
$ret = str_replace("[COLOR=yellow]", "<font color=\"yellow\">", $ret);
$ret = str_replace("[COLOR=gray]", "<font color=\"gray\">", $ret);
$ret = str_replace("[COLOR=green]", "<font color=\"green\">", $ret);
$ret = str_replace("[/COLOR]", "</font>", $ret);

$ret = str_replace("[SIZE=1]", "<font size=\"1\">", $ret);
$ret = str_replace("[SIZE=7]", "<font size=\"7\">", $ret);
$ret = str_replace("[SIZE=14]", "<font size=\"14\">", $ret);
$ret = str_replace("[/SIZE]", "</font>", $ret);

$ret = str_replace("[IMG]", "<img src=\"", $ret);
$ret = str_replace("[/IMG]", "\" align=left>", $ret);

$ret = str_replace("[EMAIL=", "<a href=\"mailto:", $ret);
$ret = str_replace("//]", "\">", $ret);
$ret = str_replace("[/EMAIL]", "</a>", $ret);
?>