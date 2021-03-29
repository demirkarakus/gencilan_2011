<?php
$dbhost = "localhost";
$dbuname = "gencilan_demir";
$dbpass = "%gUJk4H]?ZoP";
$dbname = "gencilan_merverbil";

/*$dbhost = "localhost";
$dbuname = "root";
$dbpass = "";
$dbname = "gencilan";
*/
mysql_connect("$dbhost", "$dbuname", "$dbpass") || die ("mysql hatasi");
mysql_select_db("$dbname") || die ("mysql baglanamadi");

mysql_query('SET NAMES UTF8');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
?>