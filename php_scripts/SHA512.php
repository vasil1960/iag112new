<?php 
function SHA512_Encryption($uname,$upass) 
{
	$upass = "$uname|$upass|830518";	

	return hash('sha512',$upass."721010");
}
?>

