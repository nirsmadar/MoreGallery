<?php
$link = mysql_connect('localhost', 'root', ''); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
}
mysql_select_db ("moregallery");  
mysql_query("SET NAMES utf8");
?>