<?php
# FileName="WADYN_CONN.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iagRegions = "172.16.4.34";
$database_iagRegions = "regions";
$username_iagRegions = "cotaivo";
$password_iagRegions = "taniami";
@session_start();

$iagRegions = mysql_pconnect($hostname_iagRegions, $username_iagRegions, $password_iagRegions) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$iagRegions);
?>