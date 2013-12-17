<?php
//including common mongo connection file
include('../mongo_connection.php');

// Selecting users_collection
$collection = $database->selectCollection('users_collection');

// Generating a new post id
$user_id	=	new MongoId();

if($_REQUEST['action'] == 'insert') {
	// Getting post text from the ajax POST parameters
	$data		=	$_POST['data'];

	// Generating post timestamp from the user id
	// The statement should differ based on the date format needed and time zone 
	$timestamp	=	date('D, d-M-Y', $user_id->getTimestamp()+19800);

	// Creates document for inserting new post
	$new_user_mongo = array ( '_id'=> $user_id,
							  'name' => $data['txtUserName'],
							  'contact_no' => $data['txtContactNo'],
							  'email' => $data['txtEmail'],
							  'gender' => $data['radGender'],
							  'comments' => $data['txtAboutUser'],
							  'timestamp'=>$timestamp
							);
	try {						
		$collection->insert($new_user_mongo);
	} catch(MongoCursorException $e) {
		echo $e->getMessage();
		echo $e->getCode();		
	}
	
}elseif( $_REQUEST['action'] == 'delete' ){
	// Getting post text from the ajax POST parameters
	$data		=	$_POST['data'];

	try {
		$collection->remove(array("_id" => new MongoId($data['userid']) ), array("justOne" => true));
	} catch(MongoCursorException $e) {
		echo $e->getMessage();
		echo $e->getCode();
	}
}elseif( $_REQUEST['action'] == 'find' ){
	try {
		// Retrieving all the posts in the collection
		// If you want to retrieve specific posts based on user, relations, etc. put filter condition in find 
		$users_cursor=$collection->find()->sort(array('_id'=>-1));
		
		$userDetailsObj	=	'';					
		
		//Iterating over all the retrieved posts
		while ($users_cursor->hasNext()) { 
			$user = $users_cursor->getNext();
			$userDetailsObj	.=	"{user_id:'".$user['_id']."', txtUserName:'".$user['name']."', txtContactNo:'".$user['contact_no']."', txtEmail:'".$user['email']."', radGender:'".$user['gender']."', txtAboutUser:'".$user['comments']."'},";
		}
		echo $userDetailsObj;
	} catch(MongoCursorException $e) {
		echo $e->getMessage();
		echo $e->getCode();
	}	
}
?>