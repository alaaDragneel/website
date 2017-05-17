<?php

	$dsn = "mysql:host=127.0.0.1;dbname=dezique;";

	$user = "root";

	$pass = "";

	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try{

		$conn = new PDO($dsn, $user, $pass, $option);

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e){

		echo 'field to connect' . $e->getMessage();
	}