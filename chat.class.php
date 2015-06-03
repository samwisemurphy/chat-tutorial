<?php 
require_once('config.php');
require_once('error_handler.php');

class Chat {

	private $mysqli;

	//Constructor open database connection 

	function __construct() {
		$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	}

	//Destrcutor closes database connection 
	function __destruct() {
		$this->mysqli->close();
	}


	



}


?>