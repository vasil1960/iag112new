<?php

session_start();

$table = 'logos';

// SQL server connection information
$sql_details = array(
    'user' => 'cotaivo',
    'pass' => 'taniami',
    'db'   => 'iag112new',
    'host' => '172.16.4.34'
);

$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id',            'dt' => 0 ),
    array( 'db' => 'action',        'dt' => 1 ),
    array( 'db' => 'ip',            'dt' => 2 ),
    array( 'db' => 'username',          'dt' => 3 ),
    array( 'db' => 'date',   'dt' => 4,
		   'formatter' => function( $d, $row ){
				return date('d.m.Y H:i:s',strtotime($d));
			}
		 ),
	array( 'db' => 'name',          'dt' => 5 ),
	array( 'db' => 'podelenie',     'dt' => 6 )
);

//---------class SSP------------
require_once("../SSP.php");

echo json_encode(
   SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

