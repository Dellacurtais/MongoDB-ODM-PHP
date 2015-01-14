<?php
	require_once("Mongo/Mongo.php");	
	$User = new Model_Users();
	//Use Parent
	$User->Parent = 1; // 1: true 0:false
	
	//Defined Coluns
	$User->Nome = "Ex Of Name";
	$User->Email = "test@gmail.com";
	$User->User = "James";
	$User->Senha = sha1('123456');
	$User->Clube = json_encode(array("Chelsea","Man. City","Barcelona"));
	$User->Cpf = "980.098.827-20";
	
	// News Coluns
	$User->Macaca = "";
	
	//Parent Model
	$User->_Andress = array();
	$User->_Andress['Rua'] = "Rua da Couves";
	$User->_Andress['Bairro'] = "Pq. Esplanada";
	$User->_Andress['Cidade'] = "Valparaiso";
	$User->_Andress["Estado"] = "GO";
	
	//Salvar
	$User->save();
	
	// Find All
	$Find = $User->find();	
	echo "<pre>";
	print_r($Find);
	echo "</pre>";
	
	/*$Find = $User->find(
		Codition,
		limit,
		skip,
		sort
	);*/
	
	// Find One
	$Find = $User->findOneByNome("Ex Of Name");
	echo "<pre>";
	print_r($Find);
	echo "</pre>";
	
	// Find All By
	$Find = $User->findByNome("Ex Of Name");	
	echo "<pre>";
	print_r($Find);
	echo "</pre>";
	
	//Update Data (findByNome("Ex Of Name"))
	$User->Nome = "Update Name";
	$User->save();
	
	/*$Find = $User->findOneBy 'NameofColun' (
		Value,
		limit,
		skip,
		sort
	);*/
	
	
?>