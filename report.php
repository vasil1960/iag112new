<?php

include 'Connection.php';
include 'class/MyClass.php';

$pdo = Connection::makeconnection();

//-----------RDG----------------
$rdgobj = new MyClass($pdo);
$rdgobj->pod = "RDG";
$rdgsgnls = $rdgobj->gtSgnl();

//$rdgsignali = array_map(function($data){
//    return [
//        'RDG' => $data->RDG,
//        'cnt' => (int)$data->cnt,
//    ];
//},$rdgsgnls);

$sumcnt = array_map(function($data){
    return  $data->cnt;
},$rdgsgnls);

$rdgtotalcnt = array_sum($sumcnt);


//-----------DP----------------

$dpobj = new MyClass($pdo);
$dpobj->pod = "DP";
$dpsgnls = $dpobj->gtSgnl();

//$dpsignali = array_map(function($data){
//    return [
//        'DP' => $data->DP,
//        'cnt' => (int)$data->cnt,
//    ];
//},$dpsgnls);

$sumcnt = array_map(function($data){
    return  $data->cnt;
},$dpsgnls);

$dptotalcnt = array_sum($sumcnt);


session_start();
include 'report_view.php';