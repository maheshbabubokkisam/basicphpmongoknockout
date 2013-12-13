<?php
	$connection = new Mongo();
	$database = $connection->selectDB('persondetails');

	$data = $_POST['data'];
	print_r($data);
?>