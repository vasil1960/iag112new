<?php
// version 1.14
class WA_MySQLi_Auth  {
	public function __construct($conn=false) {
	  $this->CurrentPage = $_SERVER['PHP_SELF'];
	  $this->Name = "";
	  $this->Connection = $conn;
	  $this->Action = "";
	  $this->Table = "";
	  $this->ParamTypes = "";
	  $this->ParamValues= array();
	  $this->FilterValues= array();
	  $this->Statement = "";
	  $this->Result = false;
	  $this->StoreValues= array();
	  $this->SuccessRedirect = "";
	  $this->FailRedirect = "";
	  $this->Redirect = "";
	  $this->AutoReturn = "";
	}
	public function addFilter($filterColumn, $filterComparison, $filterType, $filterValue) {
      $this->FilterValues[] = array($filterColumn, $filterComparison, $filterType, $filterValue);
	}
	public function setFilter() {
	  if (sizeof($this->FilterValues) > 0) {
        $this->Statement .= " WHERE ";
        for ($x=0; $x<sizeof($this->FilterValues); $x++) {
          if ($x>0) $this->Statement .= " AND ";
          $this->Statement .= $this->FilterValues[$x][0] . " " . $this->FilterValues[$x][1] . " ?";
		  $this->bindParam($this->FilterValues[$x][2], $this->FilterValues[$x][3]);
		}
	  }
	}
	public function storeResult($column,$name) {
	  $this->StoreValues[] = array($column,$name);
	}
	public function bindParam($paramType,$paramValue) {
	  if ($paramType == "t") {
		$paramType = "s";
		$hasTime = strpos($paramValue," ") !== false;
		$paramValue = strtotime($paramValue);
		if ($hasTime) {
		  $paramValue = date('Y-m-d H:i:s',$paramValue);
		} else {
		  $paramValue = date('Y-m-d',$paramValue);
		}
	  }
	  $this->ParamTypes .= $paramType;	
	  $this->ParamValues[] = $paramValue;	
	}
	public function getParams() {
	  return array_merge(array($this->ParamTypes), $this->ParamValues); 
	}
	public function execute() {
	  switch ($this->Action) {
		case "authenticate":
		  if (!$this->Statement)  {
			$this->Statement = "SELECT ";
			if (sizeof($this->StoreValues) > 0) {
			  for ($x=0; $x<sizeof($this->StoreValues); $x++) {
			    if ($x>0) $this->Statement .= ", ";
			    $this->Statement .= $this->StoreValues[$x][0];
			  }
			} else {
			  $this->Statement .= "*";
			}
			$this->Statement .= " FROM " . $this->Table;
			$this->setFilter();
			$this->Statement .= " LIMIT 1";
		  }
		  $query = $this->Connection->Prepare($this->Statement);
		  if ($this->ParamTypes) call_user_func_array(array($query, "bind_param"),$this->paramRefs($this->getParams()));
		  $query->execute();
		  if (method_exists($query,'get_result')) {
			$result = $query->get_result();
			$this->Result = $result->fetch_array(MYSQLI_ASSOC);
		  } else {
			$result = $this->wa_mysqli_stmt_get_result($query);
			$this->Result = $this->wa_mysqli_result_fetch_assoc($result);
		  }
		  $query->close();
		  if ($this->Result) {
			@session_start();
			if (!isset($_SESSION["WA_AUTH_".$this->Name])) $_SESSION["WA_AUTH_".$this->Name] = array();
			for ($x=0; $x<sizeof($this->StoreValues); $x++) {
			  if (!in_array($this->StoreValues[$x][1],$_SESSION["WA_AUTH_".$this->Name])) $_SESSION["WA_AUTH_".$this->Name][] = $this->StoreValues[$x][1];
			  $_SESSION[$this->StoreValues[$x][1]] = $this->Result[$this->StoreValues[$x][0]];
			}
			if (isset($_SESSION["WA_FAIL_".$this->Name])) {
				$this->SuccessRedirect = $_SESSION["WA_FAIL_".$this->Name];
				unset($_SESSION["WA_FAIL_".$this->Name]);
			}
			@session_commit();
			$this->redirect($this->SuccessRedirect);
		  } else {
			$this->logOut();
			$this->redirect($this->FailRedirect);
		  }
		  break;
		case "restrict":
		  @session_start();
		  $_SESSION["WA_FAIL_".$this->Name] = $this->addQuerystring($_SERVER['PHP_SELF']);
		  if (!isset($_SESSION["WA_AUTH_".$this->Name])) {
		    $this->redirect($this->FailRedirect);
		  }
		  @session_commit();
		  break;
		case "checknew":
		  if (!$this->Statement)  {
			$this->Statement = "SELECT Count(*) AS CheckNew";
			$this->Statement .= " FROM " . $this->Table;
			$this->setFilter();
			$this->Statement .= " LIMIT 1";
		  }
		  $query = $this->Connection->Prepare($this->Statement);
		  if ($this->ParamTypes) call_user_func_array(array($query, "bind_param"),$this->paramRefs($this->getParams()));
		  $query->execute();
		  if (method_exists($query,'get_result')) {
			$result = $query->get_result();
			$this->Result = $result->fetch_array(MYSQLI_ASSOC);
		  } else {
			$result = $this->wa_mysqli_stmt_get_result($query);
			$this->Result = $this->wa_mysqli_result_fetch_assoc($result);
		  }
		  $query->close();
		  if ($this->Result && $this->Result['CheckNew'] > 0) {
			if (!$this->FailRedirect) $this->FailRedirect = $this->addQuerystring($_SERVER['PHP_SELF']);
			$this->redirect($this->FailRedirect);
		  }
		  break;
		case "logout":
		  $this->logOut();
		  break;
	  }
	}
	public function redirect($url) {
	  if ($url) {
		header("location: " . $this->addQuerystring($url));
		die();
	  }
	}
	public function addQuerystring($url) {
	   if (empty($_SERVER['QUERY_STRING'])) return $url;
	   if (strpos("?",$url)!==false) return $url . "&" . $_SERVER['QUERY_STRING'];
	   return $url . "?" . $_SERVER['QUERY_STRING'];
	}
	public function logOut() {
	  @session_start();
	  if (isset($_SESSION["WA_AUTH_".$this->Name])) for ($x=0; $x<sizeof($_SESSION["WA_AUTH_".$this->Name]); $x++) {
		unset($_SESSION[$_SESSION["WA_AUTH_".$this->Name][$x]]);
	  }
	  unset($_SESSION["WA_AUTH_".$this->Name]);
	  @session_commit();
	}
	public function paramRefs($arr) {
	  if (strnatcmp(phpversion(),'5.3') >= 0)
	  {
		$refs = array();
		foreach($arr as $key => $value)
		  $refs[$key] = &$arr[$key];
		return $refs;
	  }
	  return $arr;
	}
	private function wa_mysqli_stmt_get_result($stmt)  {
	  $metadata = mysqli_stmt_result_metadata($stmt);
	  $ret = (object) array('nCols'=>'0', 'fields'=>array(), 'stmt'=>'');
	  $ret->nCols = mysqli_num_fields($metadata);
	  $ret->fields = mysqli_fetch_fields($metadata);
	  $ret->stmt = $stmt;
	  mysqli_free_result($metadata);
	  return $ret;
	}
	private function wa_mysqli_result_fetch_assoc(&$result) {
	  $ret = array();
	  $code = "mysqli_stmt_store_result(\$result->stmt); return mysqli_stmt_bind_result(\$result->stmt ";
	  for ($i=0; $i<$result->nCols; $i++) {
		$ret[$result->fields[$i]->name] = NULL;
		$code .= ", \$ret['" .$result->fields[$i]->name ."']";
	  };
	  $code .= ");";
	  if (!eval($code)) { return NULL; };
	  if (!mysqli_stmt_fetch($result->stmt)) { return NULL; };
	  return $ret;
	}
}
?>