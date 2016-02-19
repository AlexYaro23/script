<?php

require_once 'config.php';

$view = new View();

$view->header();

if (isset($_POST['submit'])) {
	
    $view->back();

	$main = new Controller();

	$main->readfile($_FILES["file"]["tmp_name"]);
	$main->fillDataWithIdAndType();

	$main->updateSeo();
} else {
	$view->form();
}

$view->footer();