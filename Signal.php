<?php

class Signal 
{
	public $pdo;
	//protected $selectPod;
	
	//----------------------------------
	public function __construct($pdo)
	{
		$this->pdo = $pdo;	
	}
	
	//-------------------------------
	public function baseQuery()
	{
		$query  = "";
		$query = "SELECT  dgs.Pod_NameBg AS DGS, rdg.Pod_NameBg AS RDG, dp.Pod_NameBG AS DP,r.proveren , s.* FROM signali AS s ";
		$query .= "INNER JOIN nug.podelenia AS dgs ON dgs.Pod_Id = s.pod_id ";
		$query .= "INNER JOIN nug.podelenia AS rdg ON rdg.Pod_Id = dgs.Glav_Pod ";
		$query .= "INNER JOIN nug.podelenia AS dp ON dp.Pod_Id = dgs.DP_ID ";
		$query .= "LEFT JOIN report as r ON s.id = r.signal_id ";
		$query .= "WHERE 1=1 ";
		$query .= "ORDER BY s.id DESC LIMIT 100";
		
		return $query;
	}
	
	//----------------------------------------------------
	public function fetchAllSignals()
	{
		$sth = $this->pdo->prepare($this->baseQuery());
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	//----------------------------------------
	
	public function totalRecords()
	{
		$sth = $this->pdo->prepare($this->baseQuery());
		return $sth->rowCount();
	}
	
}
