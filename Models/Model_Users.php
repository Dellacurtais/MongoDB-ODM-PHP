<?php
/*
	Generator MongoRones 1.0
	Author: Maicon
	Site: http::/maikweb.com.br
*/

class Model_Users extends MongoTable {
	public $id;
	public $Nome;
	public $Email;
	public $User;
	public $Senha;
	public $Clube;
	public $Cpf;
	public $Extra;

	public function SetValidation() {
		$this->hasValid("Nome","varchar");
		$this->hasValid("Email","email");
		$this->hasValid("User","onlyAlphanumeric");
		$this->hasValid("Senha","varchar");
		$this->hasValid("Clube","varchar");
		$this->hasValid("Cpf","cpf");
		$this->hasValid("Extra","varchar");
	}
	
	public function SetMany(){
		$this->hasMany('Andress','User');
	}

	public function SetIndex() {
		$this->hasIndex("Email","unique");
		$this->hasIndex("User","unique");
		$this->hasIndex("Cpf","unique");
	}


}

?>