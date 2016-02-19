<?php

include_once "libs/db.php";
include_once "libs/FileReader.php";
include_once "libs/Controller.php";
include_once "libs/Model.php";
include_once "libs/Log.php";
include_once "libs/View.php";


define('DB_HOST', 'localhost');
define('DB_USER', 'homestead');
define('DB_PASSWORD', 'secret');
define('DB_DATABASE', 'tehnik');
define('FILEPATH', 'csv/seo.csv');

function dd($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die();
}

function prepareStr($str) {
	return "'" . $str . "'";
}