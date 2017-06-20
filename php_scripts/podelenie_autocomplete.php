<?php 

include('../vasil.class.php');

Vasil::autocompletePodelenia();


//include('../Connection.php');	
//	
//$pdo = Connection::makeconnection();
//
//$sth = $pdo->prepare("SELECT p.Pod_Id,p.Glav_Pod, p.Pod_NameBg as podelenie, p.ID, rdg.Pod_NameBg AS RDG, p.Pod_Grad AS grad 
//FROM nug.podelenia AS p INNER JOIN nug.podelenia as rdg ON p.Glav_Pod = rdg.Pod_Id WHERE p.Pod_NameBg LIKE CONCAT('%', :term, '%') AND p.pod_id < 25000");
//
//$sth->execute([':term' => $_GET['term']]);
//
//$result = $sth->fetchAll(PDO::FETCH_CLASS); 
//
//$my_array = array_map(function($data){
//	return [
//		'id'        => $data->ID,
//		'Pod_Id'    => $data->Pod_Id,
//		'Glav_Pod'  => $data->Glav_Pod,
//		'podelenie' => $data->podelenie,
//		'rdg'       => $data->RDG,
//		'grad'      => $data->grad
//	];
//}, $result);
//
//echo json_encode($my_array);


