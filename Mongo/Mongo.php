<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

require_once("Mongo/MongoConfig.php");
$Mongo = new MongoConfig();
$Mongo->setModelBase("Model_");
$Mongo->setPatchModel("Models/");
$Mongo->setBase(dirname(__FILE__));
//$Mongo->setConnection($db,$host,$user,$pass);

$Mongo->setConnection("teste","ds051788.mongolab.com:51788/teste","teste","teste");

?>