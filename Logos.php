<?php


class Logos 
{
	public $pdo;
	
	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function insertLogos( $action, $lastInsertId = NULL )
	{
		$sth = $this->pdo->prepare("INSERT INTO logos ( action, ip , name, podelenie, username) VALUES( :action, :ip, :name, :podelenie, :username )");
		$sth->execute([
			':action'    => $action ." ". $lastInsertId, 
			':ip'        => $_SERVER['REMOTE_ADDR'],
			':name'      => $this->fullName(),
			':podelenie' => $_SESSION['Podelenie'],
			':username'  => $_SESSION['username']
		]);
	}

	protected function fullName()
	{
		return $_SESSION['Name'] . " " .$_SESSION['Familia'];
	}
}
