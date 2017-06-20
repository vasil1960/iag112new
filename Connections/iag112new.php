<?php
# FileName="WADYN_CONN.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_iag112new = "172.16.4.34";
$database_iag112new = "iag112new";
$username_iag112new = "cotaivo";
$password_iag112new = "taniami";
@session_start();

$iag112new = mysql_pconnect($hostname_iag112new, $username_iag112new, $password_iag112new) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_set_charset('utf8',$iag112new);
?>