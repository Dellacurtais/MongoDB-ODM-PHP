<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

class MongoDbConnect {	
	public $_Db;	
		
	public function __construct($db,$host,$user,$pass){
		$Conect = new MongoClient("mongodb://".$user.":".$pass."@".$host);
		$this->_Db = $Conect->selectDB($db);
	}
	
	public function ensureIndex($Collection,$Parans,$Type,$Expire = null){
		switch ($Type){
			case "unique" :
			 $Type = array("unique" => true);
			break;
			case "dropDups" :
			 $Type = array("dropDups" => true);
			break;
			case "sparse" :
			 $Type = array("sparse" => true);
			break;
			case "expire" :
			 $Expire = (int)$Expire == 0 ? array("expireAfterSeconds" => 86400) : array("expireAfterSeconds" => $Expire);
			 $Type = $Expire;
			break;
			default:
				throw new MongoExceptionTable( "Não foi possivel definir o index na Collection %s", array($Collection) );
			break;
		}
		$ensure = $this->_Db->$Collection;
		$ensure->ensureIndex($Parans,$Type);
	}
	
	public function Insert($Collection,$Parans){
		array_walk_recursive($Parans, array($this,'bindValue'));	
		if (empty($Collection)){
			exit("Error, Collection não definida");
		}
		
		$Insert = $this->_Db->$Collection;
		$Insert->insert($Parans);
		return $Parans;
	}
	
	public function Update($Collection,$Where,$Parans){
		array_walk_recursive($Where, array($this,'bindValue'));
		array_walk_recursive($Parans, array($this,'bindValue'));
		
		if (empty($Collection)){
			exit("Error, Collection não definida.");
		}
		
		$Parans = array('$set' => $Parans);
		$Insert = $this->_Db->$Collection;
		$Insert->update($Where, $Parans);
	}
		
	public function Remove($Collection,$Where,$Parans){
		array_walk_recursive($Where, array($this,'bindValue'));
		$Parans = $this->Method_remove($Parans);
		
		if (empty($Collection)){
			exit("Error, Collection não definida.");
		}
		
		if (!$Parans){
			exit("Error, Parametros inválidos.");
		}
				
		$Insert = $this->_Db->$Collection;
		$Insert->remove($Where, $Parans);
	}
	
	public function Find($Collection, $Query = null){
		array_walk_recursive($Query, array($this,'bindValue'));		
		$Collect = new MongoCollection($this->_Db,$Collection);
		if (is_array($Query)){
			if (isset($Query['Param']) && is_array($Query['Param'])){
				$Return = $Collect->find($Query['Param']);
			}else{
				$Return = $Collect->find();
			}
			if (isset($Query['Limit'])){
				$Return->limit($Query['Limit']);
			}
			if (isset($Query['Skip'])){
				$Return->skip($Query['Skip']);
			}
			if (isset($Query['Sort'])){
				$Return->sort($Query['Sort']);
			}	
		}else{
			$Return = $Collect->find();
		}
		return $Return;
	}
	
	public function FindOne($Collection,$Parans){
		array_walk_recursive($Parans, array($this,'bindValue'));
		$Collect = new MongoCollection($this->_Db,$Collection);		
		return $Collect->findOne($Parans);
	}
	
	public function bindValue(&$Item,&$key){
		if (!$Item instanceof MongoId){
			$key = (string)$key;
			$Item = (string)$Item;
		}
		return;
	}
	
	public function Method_remove($Method){
		switch ($Method){
			case "JusOne" :
			 return array("JusOne" => true);
			break;
			case "w" :
			 return array("w" => 1);
			break;
		}
	}
}

?>