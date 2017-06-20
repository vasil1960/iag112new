<?php @session_start();

#########################################
#  filter IAG, DGS, RDG or DP for signali
function filterSignali($spodelenie)
{
	# IAG
	if(strlen($spodelenie == 1) && $spodelenie = 1)
	{
		$where = "1 = 1";
	}
	
	# RDG Sofia i raboteshtite v center 112
	//if($spodelenie = 115 && $iag112 = 3)
//	{
//		$where = "1 = 1";
//	}
	
	# DGS
	if(strlen($spodelenie) == 5)
	{
		$where = "s.pod_id = ".$spodelenie;
	}

	# RDG
	if(strlen($spodelenie) == 3 && $spodelenie > 100 && $spodelenie < 117)	
	{
		$where = "s.glav_pod = ".$spodelenie;
	}
	
	# DP
	if(strlen($spodelenie) == 3 && $spodelenie > 200 && $spodelenie < 207)	
	{
		$where = "dgs.DP_ID = ".$spodelenie;
	}
		
	return $where;
}

##############################################################
#  filter IAG, DGS, RDG or DP for provereni signali for counts
#  r.proveren = 1 

function filterProvereniSignali($spodelenie)
{
	# IAG
	if(strlen($spodelenie == 1) && $spodelenie = 1)
	{
		$where = "1 = 1 AND r.proveren = 1";
	}
	
	# DGS
	if(strlen($spodelenie) == 5)
	{
		$where = "s.pod_id = ".$spodelenie." AND r.proveren = 1";
	}

	# RDG
	if(strlen($spodelenie) == 3 && $spodelenie > 100 && $spodelenie < 117)	
	{
		$where = "s.glav_pod = ".$spodelenie." AND r.proveren = 1";
	}
	
	# DP
	if(strlen($spodelenie) == 3 && $spodelenie > 200 && $spodelenie < 207)	
	{
		$where = "dgs.DP_ID = ".$spodelenie." AND r.proveren = 1";
	}
		
	return $where;
}

#########################################
#  show IAG, DGS, RDG or DP title
function ShowTitle($spodelenie, $DGS, $RDG, $DP)
{
	# IAG
	if(strlen($spodelenie == 1) && $spodelenie = 1)
	{
		$where = "Изпълнителна агенция по горите";
	}
	
	# DGS
	if(strlen($spodelenie) == 5)
	{
		$where = $DGS;
	}

	# RDG
	if(strlen($spodelenie) == 3 && $spodelenie > 100 && $spodelenie < 117)	
	{
		$where = $RDG;
	}
	
	# DP
	if(strlen($spodelenie) == 3 && $spodelenie > 200 && $spodelenie < 207)	
	{
		$where = $DP;
	}
		
	return $where;
}


#############################################################
#  Take pod_id and return glav_pod to insert in signal table.

function GetGlavPodId($pod_id)
{
	# if $pod_id have 3 numbers
	if(strlen($pod_id) == 3)
	{
		# glav_pod is IAG
		return 1;
	}
	
	# if $pod_id have 5 numbers
	if(strlen($pod_id) == 5)
	{
		# returns first 3 numbers
		return substr($pod_id,0,3);
	}
}
###########################
# dump and die
function dd($data)
{
	echo "<pre>";
	die(var_dump($data));	
	echo "<pre>";
}

?>

 