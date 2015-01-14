<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/
class MongoConfig {	
	public $_VersionModule = "1.0";
			
	public function setConnection($db,$host,$user,$pass){
		spl_autoload_extensions(".php");
		spl_autoload_register(function ($class) {
			$class = str_replace('\\', '/', $class . '.php');
			$File = $GLOBALS['MongoSettings']['Patch']."/Mongo/".$class;
			$FileModel = $GLOBALS['MongoSettings']['PatchModel'].$class;
			if (file_exists($File)){
				require_once($File);
			}else if (file_exists($FileModel)){
				require_once($FileModel);
			}
		});
		$GLOBALS['MongoSettings']['connect'] = new MongoDbConnect($db,$host,$user,$pass);
	}
	
	public function setPatchModel($patch){
		$GLOBALS['MongoSettings']['PatchModel'] = $patch;		
	}
	
	public function setModelBase($model){
		$GLOBALS['MongoSettings']['ModelBase'] = $model;		
	}
	
	public function setBase($base){
		$GLOBALS['MongoSettings']['Patch'] = $base;
	}
}

?>