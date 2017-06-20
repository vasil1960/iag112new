<?php
# FileName="WADYN_CONN.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_nug = "172.16.4.34";
$database_nug = "nug";
$username_nug = "cotaivo";
$password_nug = "taniami";
@session_start();

$nug = mysql_pconnect($hostname_nug, $username_nug, $password_nug) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$nug);
?>