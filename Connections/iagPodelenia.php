<?php
# FileName="WADYN_CONN.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iagPodelenia = "172.16.4.34";
$database_iagPodelenia = "regions";
$username_iagPodelenia = "cotaivo";
$password_iagPodelenia = "taniami";
@session_start();

$iagPodelenia = mysql_pconnect($hostname_iagPodelenia, $username_iagPodelenia, $password_iagPodelenia) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$iagPodelenia);
?>