<?php 

class Connection 
{
	public static function makeconnection()
	{
		try {
			return new PDO('mysql:host=172.16.4.34;dbname=iag112new;charset=utf8','cotaivo','taniami');
			 
		} catch (PDOException $e) {
			die($e->getMessage());	
		} 	
	}	
}