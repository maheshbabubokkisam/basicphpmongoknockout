<?php

//This file contains the common database connection code used accross files
//If you have modified username and password for connection, define it here     

$connection 	=	new Mongo('mongodb://localhost');
$database		=	$connection->selectDB('user');
/*
$resultsCollection	=	$database->selectCollection('users_collection');
$resultsCursor 		=	$resultsCollection->find();

echo '<pre>';
while ($resultsCursor->hasNext()) { 
    $friend = $resultsCursor->getNext();
    print_r($friend);
        echo PHP_EOL;
}
echo '</pre>'
*/
?>
