<?php
/*
	MongoDB Experimental Mini ORM
	Version 1.0
	Author Maicon (maiconphpnet@gmail.com)
*/

class MongoException extends Exception {
	function __construct($message, $code = 0) {
		Exception::__construct($message, $code);
	}
}
?>