<?php
//including common mongo connection file
include('../mongo_connection.php');
/*
//error handler function
function customError($errno, $errstr){
	echo "<b>Error:</b> [$errno] $errstr";
}
//set error handler
set_error_handler("customError");*/

// Selecting users_collection
$collection = $database->selectCollection('users_collection');

if($_REQUEST['action'] == 'insert') {
	// Getting post text from the AJAX POST parameters
	$data		=	$_POST['data'];

	// Generating a new post id
	
	$user_id	= ( isset($data['user_id']) && $data['user_id'] != '' ) ? new MongoId($data['user_id']) : new MongoId();
	
	// Generating post timestamp from the user id
	// The statement should differ based on the date format needed and time zone 
	$timestamp	=	date('D, d-M-Y', $user_id->getTimestamp()+19800);
	$details	=	array( 'name' => $data['txtUserName'], 'contact_no' => $data['txtContactNo'], 'email' => $data['txtEmail'], 'gender' => $data['radGender'], 'comments' => $data['txtAboutUser'], 'timestamp'=>$timestamp);
	
	try {
		if(isset($data['user_id']) && $data['user_id'] != ''){	
			// UPDATE
			$collection->update( array( '_id' => $user_id), array( '$set' => $details ) );		
		}else{
			// Creates document for inserting new post			
			$collection->insert(array ( '_id'=> $user_id, 'name' => $data['txtUserName'], 'contact_no' => $data['txtContactNo'], 'email' => $data['txtEmail'], 'gender' => $data['radGender'], 'comments' => $data['txtAboutUser'], 'timestamp'=>$timestamp));
		}
		echo json_encode(array('userid'=>$user_id->{'$id'}), JSON_FORCE_OBJECT);
	} catch(MongoCursorException $e) {
		echo $e->getMessage();
		echo $e->getCode();		
	}
	
}elseif( $_REQUEST['action'] == 'delete' ){
	// Getting post text from the AJAX POST parameters
	$data		=	$_POST['data'];

	try {
		$collection->remove(array("_id" => new MongoId($data['user_id']) ), array("justOne" => true));
		echo json_encode(array('status'=>true), JSON_FORCE_OBJECT);		
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
			// this step useful when we are calling directly from php	
			//$userDetailsObj .=	"{user_id:'".$user['_id']->{'$id'}."', txtUserName:'".$user['name']."', txtContactNo:'".$user['contact_no']."', txtEmail:'".$user['email']."', radGender:'".$user['gender']."', txtAboutUser:'".$user['comments']."'},";
			// this step is useful for AJAX return variable 
			$userDetailsObj[] =	 array('user_id'=>$user['_id']->{'$id'}, 'txtUserName'=>$user['name'], 'txtContactNo'=>$user['contact_no'], 'txtEmail'=>$user['email'], 'radGender'=>$user['gender'], 'txtAboutUser'=>$user['comments'] );			
		}		
		header('Content-Type: application/json');		
		echo json_encode( $userDetailsObj, JSON_FORCE_OBJECT );		
	} catch(MongoCursorException $e) {
		echo $e->getMessage();
		echo $e->getCode();
	}	
}
?>