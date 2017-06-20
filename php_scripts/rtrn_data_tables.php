<?php

//--------- includes classes-------------
require_once('../Connection.php');
require_once('../Signal.php');

//--------- connect to Db----------
$pdo = Connection::makeconnection();

//------ make new object-----------
$signals = new Signal($pdo);
$s  = $signals->fetchAllSignals(); 
//$tr = $sgnl->totalRecords();

//var_dump($tr);
//die();
//------------------------------------

$draw = $_POST["draw"];

//$recordsTotal = $sgnl->totalRecords();

//----- prepare json for DataTables-----------
$response = [
		'drow'            => 1,
		'recordsTotal'    => 1000,
		'recordsFiltered' => 1000,
		'data'            => array_map('transform',$signals)
		]; 

function transform($clmn)
{
	return [
			$clmn->id,
			$clmn->phone,
			$clmn->DGS,
			$clmn->RDG,
			$clmn->signaldate,
			$clmn->name,
			$clmn->opisanie,
			$clmn->proveren,
		];
}
//var_dump($arr);
echo json_encode($response);
