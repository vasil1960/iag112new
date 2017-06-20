<?php
session_start();

//----------- Session AccesPodelenia------------
$sAccessPodelenia = $_SESSION['AccessPodelenia'];

//------------Session Access112 ------------------
$sAccess112 = $_SESSION['Access112'];

require_once('vasil.class.php');

$table = Vasil::joinTables( $sAccessPodelenia );



// SQL server connection information
$sql_details = array(
    'user' => 'cotaivo',
    'pass' => 'taniami',
    'db'   => 'iag112new',
    'host' => '172.16.4.34'
);


//$table ='signali';

// DB table to use
//$table = <<<EOT
// (
//	 (
//		 SELECT  s.*, dgs.Pod_NameBg AS DGS, rdg.Pod_NameBg AS RDG, dp.Pod_NameBG AS DP,dgs.DP_ID AS dp_id, r.proveren AS proveren FROM signali AS s 
//		 INNER JOIN nug.podelenia AS dgs ON dgs.Pod_Id = s.pod_id 
//		 INNER JOIN nug.podelenia AS rdg ON rdg.Pod_Id = dgs.Glav_Pod 
//		 INNER JOIN nug.podelenia AS dp ON dp.Pod_Id = dgs.DP_ID
//		 LEFT JOIN report as r ON s.id = r.signal_id 
//	 ) AS s
// ) 
//EOT;
 
// Table's primary key
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id',           'dt' => 0 ),
    array( 'db' => 'phone',        'dt' => 1 ),
    array( 'db' => 'DGS',          'dt' => 2 ),
    array( 'db' => 'RDG',          'dt' => 3 ),
    array( 'db' => 'signaldate',   'dt' => 4,
		   'formatter' => function( $d, $row ){
				return date('d.m.Y H:i:s',strtotime($d));
			}
		 ),
	array( 'db' => 'name',         'dt' => 5 ),
	array( 'db' => 'opisanie',     'dt' => 6 ),
	array( 'db' => 'proveren',     'dt' => 7 ),
	array( 'db' => 'pod_id',       'dt' => 8 ),
	array( 'db' => 'glav_pod',     'dt' => 9 ),
	array( 'db' => 'dp_id',        'dt' => 10 ),
	
);

//---------class SSP------------
require_once("SSP.php");

echo json_encode(
   SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

