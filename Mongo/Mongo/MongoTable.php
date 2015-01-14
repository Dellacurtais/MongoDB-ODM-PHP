<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

class MongoTable extends MongoProperty{
	private $_djsagdsa; //_conect
	private $_dhsagh; //_Model
	private $_Shgdshaff; //_Collection
	public $_SHgd; //_Data
	public $_Uhwjbxsa; //_Validation
	public $_Jbbcsah; //_Error
	public $_SGDSBC; //_Parent
	public $Parent = 1;
	
	public function __construct() {
		$this->_djsagdsa = $GLOBALS['MongoSettings']['connect'];
		$getc = get_class($this);
		list($Null,$this->_dhsagh) = explode($GLOBALS['MongoSettings']['ModelBase'],$getc);
		unset($null);
				
		if (!$this->_dhsagh) {
			throw new MongoExceptionTable( "Modelo Inválido. Padrão %s", array($GLOBALS['MongoSettings']['ModelBase'].'Exemplo') );
		}else{
			$this->_Shgdshaff = $this->_dhsagh;
			$this->_dhsagh = $getc;
		}
		
		$this->SetValidation();
		$this->SetMany();
	}
		
	public function set($var, $value){
		$this->$var = $value;
	}
	
	public function findBy($var, $value, $limit = null, $skip = null, $sort = null){
		$Condtions = array();
		$Idvar = array("id","Id","ID","iD");
		$var = in_array($var,$Idvar) ? "_id" : $var;
		$value = $var == "_id" ? new MongoId($value) : $value;
		$Condtions['Param'] = array($var => $value);
		
		if (is_numeric($limit)){
			$Condtions['Limit'] = (int)$limit;
		}
		if (is_numeric($skip)){
			$Condtions['Skip'] = (int)$skip;
		}
		if (is_numeric($sort)){
			$Condtions['Sort'] = (int)$sort;
		}		
		$this->_SHgd = $this->_djsagdsa->Find($this->_Shgdshaff,$Condtions);
		$Array = array();
		
		if ($this->_SHgd)
			$i = 0;
			foreach($this->_SHgd as $key=>$Value){
				if ($this->Parent && !empty($this->_SGDSBC)){
					foreach ($this->_SGDSBC as $Model=>$Param){
						$Models = $GLOBALS['MongoSettings']['ModelBase'].$Model;
						$Find = new $Models();
						$_parm = "findBy".$Param;
						$Value["_".$Model] =  $Find->$_parm($Value['_id']);			
					}
				}
				$Array[$i] = $Value;
				$i++;
			}
					
		return $Array;
	}
	
	public function findOneBy($var, $value){
		$Idvar = array("id","Id","ID","iD");
		$var = in_array($var,$Idvar) ? "_id" : $var;
		$StringId = $value;
		$value = $var == "_id" ? new MongoId($value) : $value;
		
		$this->_SHgd = $this->_djsagdsa->FindOne($this->_Shgdshaff,array($var => $value));
		
		if ($this->_SHgd)
			foreach($this->_SHgd as $key=>$Value){
				if ($Value instanceof MongoId){
					$this->id = $Value;
				}else{
					$this->$key = $Value;
				}
			}	
				if ($this->Parent && !empty($this->_SGDSBC)){
					foreach ($this->_SGDSBC as $Model=>$Param){
						$Models = $GLOBALS['MongoSettings']['ModelBase'].$Model;
						$Find = new $Models();
						$_parm = "findOneBy".$Param;
						$Model = "_".$Model;
						$SeTParent = $Find->$_parm($this->id);
						$this->$Model =  $SeTParent;
						$this->_SHgd[$Model] = $this->$Model;
					}
				}
				
		return $this->_SHgd;
	}
	
	public function find($param = null, $limit = null, $skip = null, $sort = null){
		$Condtions = array();
		if (is_array($param)){
			foreach($param as $k=>$v){
				$Idvar = array("id","Id","ID","iD");
				$var = in_array($k,$Idvar) ? "_id" : $k;
				if ($var == "_id"){
					unset($param[$k]);
					$param[$var] = new MongoId($v);
				}
			}
			$Condtions['Param'] = $param;
		}
		if (is_numeric($limit)){
			$Condtions['Limit'] = $limit;
		}
		if (is_numeric($skip)){
			$Condtions['Skip'] = $skip;
		}
		if (is_numeric($sort)){
			$Condtions['Sort'] = $sort;
		}		
		$this->_SHgd = $this->_djsagdsa->Find($this->_Shgdshaff,$Condtions);
		$Array = array();
		
		if ($this->_SHgd)
			foreach($this->_SHgd as $key=>$Value){		
				if ($this->Parent && !empty($this->_SGDSBC)){
					foreach ($this->_SGDSBC as $Model=>$Param){
						$Models = $GLOBALS['MongoSettings']['ModelBase'].$Model;
						$Find = new $Models();
						$_parm = "findBy".$Param;
						$Dados =  $Find->$_parm($Value['_id']);
						if (!empty($Dados)) $Value["_".$Model] = $Dados;			
					}
				}
				
				$Array[(string)$Value['_id']] = $Value;
			}
		
		return $Array;
	}
	
	public function select($_id){
		$Array = iterator_to_array($this->_SHgd);
		if (!isset($Array[$_id]))
			throw new MongoExceptionTable( "Não foi encotrado nenhum dado com o ID %s.", array($_id) );
			
		foreach($Array[$_id] as $key=>$Value){
			if ($Value instanceof MongoId){
				$this->id = $Value;
			}else{
				$this->$key = $Value;
			}
		}		
	}
	
	public function save(){
		$Update = false;
		if ($this->id instanceof MongoId || $this->_id instanceof MongoId){
			$Update = true;
			if (empty($this->id) && !empty($this->_id)){
				$this->id = $this->_id;
			}
		}
				
		$Vars = $this->setingVars();
		if (!empty($this->_Jbbcsah)){
			return false;
		}
		
		if ($Update){
			$this->_djsagdsa->Update($this->_Shgdshaff,array('_id' => $this->id), $Vars);
			$Id['_id'] = $this->id;
		}else{
			$Id = $this->_djsagdsa->Insert($this->_Shgdshaff, $Vars);
		}
		
		if ($this->Parent && !empty($this->_SGDSBC)){
			foreach ($this->_SGDSBC as $Model=>$Param){
				$Models = "_".$Model;
				$Model = $GLOBALS['MongoSettings']['ModelBase'].$Model;				
				if (isset($this->$Models) && is_array($this->$Models)){
					$Save = new $Model();
					foreach ($this->$Models as $key=>$Val){
						$Save->$key = $Val;
					}
					$Save->$Param = $Id['_id'];
					$this->_SHgd[$Models] = $this->$Models;			
					if (!$Save->save()){
						$Var = print_r($Save->_Jbbcsah);
						trigger_error("Warning!".$Var,E_USER_NOTICE);
					}
				}
			}
		}
		return true;
	}
	
	public function remove($id = null, $mode = "w"){
		$Where = array();
		if ($this->id instanceof MongoId){
			$Where['_id'] = $this->id;
			$this->_djsagdsa->Remove($this->_Shgdshaff,$Where,'JustOne');
		}else{
			$Where['_id'] = new MongoId($id);
			if ($Where['_id'] instanceof MongoId){
				$this->_djsagdsa->Remove($this->_Shgdshaff,$Where,$mode);
			}
		}
	}
	
	public function removeBy($Array, $mode = "w"){
		$this->_djsagdsa->Remove($this->_Shgdshaff,$Array,$mode);
	}
	
	public function setingVars(){
		$Vars = array();				
		$Validaton =  new MongoValidation();
		foreach ($this->_Uhwjbxsa as $In=>$Type){
			if (isset($this->$In) && !empty($this->$In)){
				$Valid = $Validaton->Valid($this->$In,$Type);
				if ($Valid){
					$Vars[$In] = $Valid;
				}else{
					$this->_Jbbcsah[$In] = "error";
				}
			}
		}
		
		foreach ($this->uiyewyqueyewuqibcnsabh as $key=>$val){
			if (strpos($key,"_") !== false){				
				if (!isset($this->_SGDSBC[str_replace('_','',$key)])){
					$Vars[$key]	 = $val;
				}
			}else{
				$Vars[$key]	 = $val;
			}
		}
		
		return $Vars;		
	}
	
	public function hasIndex($name,$type,$extra = null){
		$this->_djsagdsa->ensureIndex($this->_Shgdshaff,array($name => 1),$type, $extra);
	}
	
	public function hasValid($name,$type){
		$this->_Uhwjbxsa[$name] = $type;
	}
	
	public function hasMany($name,$param){
		$this->_SGDSBC[$name] = $param;
		$name = "_".$name;
		$this->__set($name);
	}
		
	public function totalData(){
		return $this->_SHgd->count();
	}
	
	public function __call($_Name, $arguments){
		$count = count($arguments);
        if (substr($_Name, 0, 6) == 'findBy') {
            $by = substr($_Name, 6, strlen($_Name));
            $method = 'findBy';
			if ($count < 1 || $count > 4)
				throw new MongoExceptionTable( "Defina um argumento válido para o método 'findBy'." );
        } else if (substr($_Name, 0, 9) == 'findOneBy') {
            $by = substr($_Name, 9, strlen($_Name));
            $method = 'findOneBy';
			if ($count != 1)
				throw new MongoExceptionTable( "Defina um argumento válido para o método 'findOneBy'." );
        } else if (substr($_Name, 0, 3) == 'set') {
            $by = substr($_Name, 3, strlen($_Name));
            $method = 'set';
			if ($count != 1)
				throw new MongoExceptionTable( "Defina um argumento válido para o método 'set'." );
        }
		
		if (!isset($method) || !method_exists($this,$method))
			throw new MongoExceptionTable( "O método %s é inválido.", array($_Name) );
			
		//if (!property_exists($this->_dhsagh,$by))
			//throw new MongoExceptionTable( "Collection %s não foi definido.", array($by) );
		
		switch ($method) {
			case "findBy":
				return $this->$method($by,$arguments[0],$arguments[1],$arguments[2],$arguments[3]);
				break;
			case "findOneBy":
				return $this->$method($by,$arguments[0]);
				break;
			case "set":
				return $this->$method($by,$arguments[0]);
				break;
		}
		
	}
	
	
}

?>