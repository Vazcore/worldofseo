<?php
	/**
	* DataBase class
	*/
	require_once "classes/Settings.php";
	class Bd
	{	
		private $base;
		
		function __construct()
		{
			$this->base = new mysqli(Settings::db_host, Settings::db_user, Settings::db_pass, Settings::db_name);
			if($this->base->connect_errno){				
				die("Ошибка подключения к БД!");
			}

		}

		public function get_link(){
			return $this->base;
		}


	}
?>