<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

class MongoExceptionTable extends MongoException {
	function __construct($message,$variables = array(), $code = 0) {
		$message = vsprintf($message,$variables);
		MongoException::__construct($message, $code);
	}
}
?>