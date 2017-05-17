<?php

	//connect file
	include "db.php";

	//Routes

	$tpl 	= "includes/templates/"; //templetes directory
	$lang 	= 'includes/languages/'; //language directory
	$func	= 'includes/functions/'; //language directory
	$css 	= "layout/css/"; //css directory
	$js 	= "layout/js/"; //js directory

	//include the important file

	include $func . "functions.php";
	include $tpl 	. "header.php";

	//include alla navbar expect the one with nonavbar variable

	if (!isset($noNavbar)){ include $tpl 	. "navbar.php";	}