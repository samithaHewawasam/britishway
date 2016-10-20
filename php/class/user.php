<?php

class user extends database{

	private $name;
	private $ati;
	private $user_name;
	private $password;
	
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getname(){
		return $this->name;
	}
	
	public function setAti($ati){
		$this->ati = $ati;
	}
	
	public function getAti(){
		return $this->ati;
	}
	
	public function setUserName($un){
		$this->user_name = $un;
	}
	
	public function getUserName(){
		return $this->user_name;
	}
	
	public function setPassword($p){
		$this->password = $p;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function login(){
	
		return parent::selectQuery(
			array(
			'query' => "SELECT count(*) success, type FROM user where username = ? and password = ?", 
			'data' => array($this->getUserName(), $this->getPassword())
		));
	
	}

}


?>
