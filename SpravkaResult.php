<?php

###################
#
class SpravkaResult
{
	protected $pdo;
	protected $from;
	protected $to;
	protected $param;
	protected $send_to;
	protected $type_narush;
	
	########################################################
	#
	public function __construct($pdo, $from, $to, $param, $send_to = NULL, $type_narush = NULL )
	{
		$this->pdo            = $pdo;	
		$this->from           = $from;
		$this->to             = $to;
		$this->param          = $param;
		$this->send_to        = $send_to;
		$this->type_narush    = $type_narush;
	}
	
	public function makeQuery()
	{
		
		if($this->param === 'signalfrom')
		{
			$sql = "
				SELECT s.id, COUNT(*) AS counts,sf.`from`,s.send_to FROM signali AS s
				INNER JOIN signalfrom as sf ON s.signalfrom = sf.id
				WHERE s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY signalfrom
				ORDER BY counts DESC
			";
		}
		
		if($this->param === 'rdg')
		{
			$sql = "
				SELECT rdi.pname AS pname, COUNT(*) AS counts,  rdi.glav_pod as glav_pod
				FROM signali AS s
				INNER JOIN rug_dp_iara AS rdi ON s.send_to = rdi.glav_pod
				WHERE send_to <> '' AND s.InsertDate >= ? AND s.InsertDate <= ? AND rdi.glav_pod >=101 AND rdi.glav_pod <= 116
				GROUP BY send_to
				ORDER BY counts DESC

			";
		}
		
		if($this->param === 'dp')
		{
			$sql = "
				SELECT rdi.pname AS pname, COUNT(*) AS counts, rdi.glav_pod
				FROM signali AS s
				INNER JOIN rug_dp_iara AS rdi ON s.send_to = rdi.glav_pod
				WHERE send_to <> '' AND s.InsertDate >= ? AND s.InsertDate <= ? AND rdi.glav_pod >=201 AND rdi.glav_pod <= 206
				GROUP BY send_to
				ORDER BY counts DESC

			";
		}
		
		if($this->param === 'iara')
		{
			$sql = "
				SELECT rdi.pname AS pname, COUNT(*) AS counts, rdi.glav_pod
				FROM signali AS s
				INNER JOIN rug_dp_iara AS rdi ON s.send_to = rdi.glav_pod
				WHERE send_to <> '' AND s.InsertDate >= ? AND s.InsertDate <= ? AND rdi.glav_pod = 8888 
				GROUP BY send_to
			";
		}		
		
		if($this->param === 'narushenia')
		{
			$sql = "
				SELECT n.naimenovanie AS naimenovanie, COUNT(*) AS counts, narushenia, s.pod_id, s.glav_pod
				FROM signali as s
				INNER JOIN narushenia AS n ON n.nid = s.narushenia
				WHERE narushenia <> 0 AND s.InsertDate >= ? AND s.InsertDate <= ? " . $this->send_to .  "
				GROUP BY narushenia
				ORDER BY counts DESC
			";
		}
		
		if($this->param === 'proveren_na_mesto')
		{
			$sql = "
				SELECT COUNT(*) AS counts, s.pod_id, s.glav_pod 
				FROM report AS r
				RIGHT JOIN signali AS s ON r.signal_id = s.id
				WHERE s.InsertDate >= ? 
				AND s.InsertDate <= ? 
				AND proveren_na_mesto = 1 " . $this->send_to .  "
			";
		}
		
		if($this->param === 'falshiv')
		{
			$sql = "
				SELECT COUNT(*) AS counts, s.pod_id, s.glav_pod 
				FROM report AS r
				RIGHT JOIN signali AS s ON r.signal_id = s.id
				WHERE s.InsertDate >= ? 
				AND s.InsertDate <= ? 
				AND falshiv = 1 " . $this->send_to .  "
			";
		}
		
		if($this->param === 'vanshni_pod')
		{
			$sql = "
				SELECT COUNT(*) AS counts, stex.vanshniPod AS vanshni, s.pod_id, s.glav_pod, s.send_to_extra 
				FROM report AS r
				RIGHT JOIN signali AS s ON r.signal_id = s.id
				INNER JOIN send_to_extra AS stex ON stex.vid = s.send_to_extra
				WHERE s.InsertDate >= ? 
				AND s.InsertDate <= ? 
				AND send_to_extra > 0 " . $this->send_to .  "
				GROUP BY send_to_extra
				ORDER BY counts DESC
			";
		}
		
		if($this->param === 'konstatirani')
		{
			$sql = "
				SELECT COUNT(*) as counts, n.naimenovanie as naimenovanie, s.pod_id, s.glav_pod 
				FROM report AS r
				RIGHT JOIN signali AS s ON r.signal_id = s.id
				INNER JOIN narushenia as n ON n.nid = r.r_narushenia
				WHERE s.InsertDate >= ? 
				AND s.InsertDate <= ? 
				AND r_narushenia <> '' " . $this->send_to .  "
				GROUP BY r_narushenia
				ORDER BY counts DESC
			";
		}
		
	    if($this->param === 'policia_after_22')
		{
			$sql = "
				SELECT COUNT(*) AS counts, s.pod_id, s.glav_pod 
				FROM signali AS s
				WHERE policia <> '' 
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ? " . $this->send_to .  "
				GROUP BY s.policia
			";
		}
		
		if($this->param === 'otgovoreno')
		{
			$sql = "
				SELECT COUNT(*) AS counts, s.* FROM signali AS s
				INNER JOIN report AS r ON r.signal_id = s.id
				WHERE r.proveren = 1
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY proveren
			";
		}
		
		if($this->param === 'by_type_narushenia')
		{
			$sql = "
				SELECT rdi.pname, COUNT(*) as counts, n.naimenovanie  FROM signali AS s
				INNER JOIN narushenia as n ON n.nid = s.narushenia
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				WHERE s.narushenia = " . $this->type_narush . "
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				AND send_to <> ''
				GROUP BY send_to 
				ORDER BY counts DESC
			";
		}
		
		
		if($this->param === 'by_otgovoreno')
		{
			$sql = "
				SELECT COUNT(*) AS counts, rdi.pname, s.* FROM signali AS s
				INNER JOIN report AS r ON r.signal_id = s.id
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				WHERE r.proveren = 1
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY send_to
				ORDER BY counts DESC
			";
		}
		
		if($this->param === 'by_proveren_na_mesto')
		{
			$sql = "
				SELECT COUNT(*) AS counts, rdi.pname, r.proveren_na_mesto, s.* FROM signali AS s
				INNER JOIN report AS r ON r.signal_id = s.id
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				WHERE r.proveren_na_mesto = 1
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY send_to
				ORDER BY counts DESC
			";
		}
		
		if($this->param === 'by_falshiv')
		{
			$sql = "
				SELECT COUNT(*) AS counts, rdi.pname, r.falshiv, s.* FROM signali AS s
				INNER JOIN report AS r ON r.signal_id = s.id
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				WHERE r.falshiv = 1
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY send_to
				ORDER BY counts DESC
			";
		}
		
		if($this->param === 'by_pojarna')
		{
			$sql = "
				SELECT COUNT(*) AS counts, ste.vanshniPod, rdi.pname FROM signali AS s
				LEFT JOIN report AS r ON r.signal_id = s.id
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				INNER JOIN send_to_extra AS ste ON ste.id = s.send_to_extra
				WHERE s.send_to_extra = 2
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY send_to
				ORDER BY counts DESC
			";
		}
		
				if($this->param === 'by_policia')
		{
			$sql = "
				SELECT COUNT(*) AS counts, ste.vanshniPod, rdi.pname FROM signali AS s
				LEFT JOIN report AS r ON r.signal_id = s.id
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				INNER JOIN send_to_extra AS ste ON ste.id = s.send_to_extra
				WHERE s.send_to_extra = 1
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY send_to
				ORDER BY counts DESC
			";
		}
		
				if($this->param === 'by_babh')
		{
			$sql = "
				SELECT COUNT(*) AS counts, ste.vanshniPod, rdi.pname FROM signali AS s
				LEFT JOIN report AS r ON r.signal_id = s.id
				INNER JOIN rug_dp_iara as rdi ON rdi.glav_pod = s.send_to
				INNER JOIN send_to_extra AS ste ON ste.id = s.send_to_extra
				WHERE s.send_to_extra = 3
				AND s.InsertDate >= ? 
				AND s.InsertDate <= ?
				GROUP BY send_to
				ORDER BY counts DESC
			";
		}
	
		return $sql;
	}
	
	public function fetchCounts()
	{	
		$sth = $this->pdo->prepare($this->makeQuery());
		$sth->execute([$this->from, $this->to]);	
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	
	public function sumcount($pod)
	{
		$map = array_map(function($data){
			return (int) $data->counts;
		}, $pod);
		
		return array_sum($map);
	}
	
}
