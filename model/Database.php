<?php
namespace Model;
use \PDO;
class Database
{
	public $pdo = null;
	public function __construct()
	{
		try{
			$this->pdo= new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS,array(PDO::ATTR_PERSISTENT => true));
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		} catch(\PDOException $e){
			throw new \Exception("Ga bisa connect ke database");
			// print "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
			//   die();

		}
	}
}
?>
