<?php

include('Connection.php');

class Vasil {
	
	//--------------------------------------------------------------
	public static function joinTables( $sAccessPodelenia )
	{
		$table = "
		 (
			 (
				 SELECT  s.*, dgs.Pod_NameBg AS DGS, rdg.Pod_NameBg AS RDG, dp.Pod_NameBG AS DP,dgs.DP_ID AS dp_id, r.proveren AS proveren FROM signali AS s 
				 INNER JOIN nug.podelenia AS dgs ON dgs.Pod_Id = s.pod_id 
				 INNER JOIN nug.podelenia AS rdg ON rdg.Pod_Id = dgs.Glav_Pod 
				 LEFT JOIN nug.podelenia AS dp ON dp.Pod_Id = dgs.DP_ID
				 LEFT JOIN report as r ON s.id = r.signal_id WHERE 1 = 1  
				 " . self::selectPodelenie( $sAccessPodelenia ) . "
			 ) AS s
		 ) 
	   ";
		return $table;
	}
	
	//---------------------------------------------------------------------
	public static function selectPodelenie( $sAccessPodelenia )
	{
		
		//------IAG i RDG Sofia slujiteli v center 112 na Antim I-------
		if( $sAccessPodelenia == 1)
			{	
				$where = "";					
			}

		//----------RDG---------------------------------------------
		if( $sAccessPodelenia > 100 && $sAccessPodelenia < 117)
		{
			$where = "AND s.glav_pod = $sAccessPodelenia";
		}

		//-----------DP-------------------------------------------------------
		if( $sAccessPodelenia > 200 && $sAccessPodelenia < 207)
		{
			$where = "AND dgs.DP_ID = $sAccessPodelenia";
		}
		
			
			//------------DGS------------------------------------
		if(strlen($sAccessPodelenia) == 5)
		{
			$where = "AND s.pod_id = $sAccessPodelenia";
		}
		
		return $where;
	}
	
	public static function autocompletePodelenia()
	{
		$pdo = Connection::makeconnection();
		
		$sth = $pdo->prepare("SELECT p.Pod_Id,p.Glav_Pod, p.Pod_NameBg as podelenie, p.ID, rdg.Pod_NameBg AS RDG, p.Pod_Grad AS grad 
		FROM nug.podelenia AS p INNER JOIN nug.podelenia as rdg ON p.Glav_Pod = rdg.Pod_Id WHERE p.Pod_NameBg LIKE CONCAT('%', :term, '%') AND p.pod_id < 25000");

		$sth->execute([':term' => $_POST['term']]);

		$result = $sth->fetchAll(PDO::FETCH_CLASS); 

		$my_array = array_map(function($data){
			return [
				'id'        => $data->ID,
				'Pod_Id'    => $data->Pod_Id,
				'Glav_Pod'  => $data->Glav_Pod,
				'podelenie' => $data->podelenie,
				'rdg'       => $data->RDG,
				'grad'      => $data->grad
			];
		}, $result);

		echo json_encode($my_array);
	}
}