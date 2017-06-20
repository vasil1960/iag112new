<?php
//session_start();
class Session 
{
	public function __construct($pdo, $sid=NULL)
	{
		$this->pdo   = $pdo;
		$this->sid   = $sid;
	}

	public function accessUserRules()
	{
		$sth = $this->pdo->prepare("SELECT * FROM nug.sessions WHERE ID = $this->sid");
		$sth->execute();
		$access = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		// ActiveSession, Access112
		if((int)$access[0]['ActiveSession'] == 1)
		{
			If((int)$access[0]['Access112'] == 1)
			{
				return "User";
			}
		
			If((int)$access[0]['Access112'] == 2)
			{
				return "Editor";
			}
		
			If((int)$access[0]['Access112'] == 3)
			{
				return "InsertEditor";
			}
		} else {
			return header("Location: login.php"); /* Redirect browser */
			exit();
		}	
	}
	
	

	public static function accessLogos($password)
	{
		if(md5($password) === "a01743b09a8956a055e6a9240a2baf63")
		{
			return(true);
		} 
		
		return(false);
	}
}