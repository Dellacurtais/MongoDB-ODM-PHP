<?php
/*
	Generator MongoRones 1.0
	Author: Maicon
	Site: http::/maikweb.com.br
*/

class Model_Andress extends MongoTable {
	public $id;
	public $Rua;
	public $Bairro;
	public $Cidade;
	public $Estado;
	public $User;
	
	public function SetValidation() {
		$this->hasValid("Rua","varchar");
		$this->hasValid("Bairro","varchar");
		$this->hasValid("Cidade","varchar");
		$this->hasValid("Estado","varchar");
		$this->hasValid("User","varchar");
	}
	
	public function SetMany(){
	}
	
	public function SetIndex() {
	}
	
	
}

?>