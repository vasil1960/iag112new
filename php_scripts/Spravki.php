<?php require_once('../Connections/iag112new.php'); ?>
<?php

class Spravki 
{
	
	public $from_date;
	
	public $to_date;
	
	
//	public function __construct($from_date,$to_date)
//	{
//		$this->from_date = $from_date;
//		$this->to_date   = $to_date;
//	}
	
	public function rdg($from_date,$to_date) 
	{
		$query = "SELECT * FROM signali WHERE signaldate>=$from_date AND signaldate<=$to_date";
		
			return $query;
	}
	
	public function dgs() 
	{
		echo "hi";
	}
}

$my = new Spravki();
$text = $my->rdg($_GET['from_date'],$_GET['to_date']);
var_dump($text);
?>
$rdg = new 
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
