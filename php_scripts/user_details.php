<?php
//including common mongo connection file
include('mongo_connection.php');
/*
//error handler function
function customError($errno, $errstr){ echo "<b>Error:</b> [$errno] $errstr";}
//set error handler
set_error_handler("customError");
*/
// Selecting users_collection
$collection = $database->selectCollection('users_collection');

/*
// Bulk data enter
for($i=0; $i<=100; $i++){
	// Generating a new post id	
	$user_id	=  new MongoId();
	$timestamp	=  date('D, d-M-Y', $user_id->getTimestamp()+19800);
	
	$name 		=  'firstname lastname'.$i;
	$email 		=  'firstnamelastname'.$i.'@gmail.com';
	$contacno	=	88888888+$i;
	$genderaray	=	array('male', 'female');	
	$gender		=	$genderaray[rand(0,1)];
	$aboutUser	=	'About User details of'.$name;
	
	$collection->insert(array ( '_id'=> $user_id, 'name' => $name, 'contact_no' => $contacno, 'email' => $email, 'gender' => $gender, 'comments' => $aboutUser, 'timestamp'=>$timestamp));
}die();*/

//$collection->remove();die();
$status	=	false;
$returnData	=	'';
if($_REQUEST['action'] == 'insert') {	
	try {		
		// Getting post text from the AJAX POST parameters
		if( isset($_POST['data']) ) {
			$data		=	$_POST['data'];
			
			if( isset($data['txtUserName']) && $data['txtUserName'] != '' ) { }else{ throw new Exception('User Name is required'); break; }
			if( isset($data['txtContactNo']) && $data['txtContactNo'] != '' ) {} else { throw new Exception('Contact No is required'); break; }
			if( isset($data['txtEmail']) && $data['txtEmail'] != '' ) {} else  { throw new Exception('Email is required'); break; }
			if( isset($data['radGender']) && $data['radGender'] != '' ) {} else  { throw new Exception('Gender is required'); break; }
			if( isset($data['txtAboutUser']) && $data['txtAboutUser'] != '' ) {} else { throw new Exception('About User is required'); break; }
		
			if(isset($data['user_id']) && $data['user_id'] != ''){
				// UPDATE
				// Get user_id object for user_id
				$user_id	= new MongoId($data['user_id']);
				$collection->update( array( '_id' => $user_id), array( '$set' => array( 'name' => $data['txtUserName'], 'contact_no' => $data['txtContactNo'], 'email' => $data['txtEmail'], 'gender' => $data['radGender'], 'comments' => $data['txtAboutUser']) ) );
			}else{
				// INSERT
				// Generate new mongoId for user_id
				$user_id	= new MongoId();
				// Generating post timestamp from the user id
				// The statement should differ based on the date format needed and time zone 				
				$timestamp	=	date('D, d-M-Y', $user_id->getTimestamp()+19800);
				// Creates document for inserting new post
				$collection->insert(array ( '_id'=> $user_id, 'name' => $data['txtUserName'], 'contact_no' => $data['txtContactNo'], 'email' => $data['txtEmail'], 'gender' => $data['radGender'], 'comments' => $data['txtAboutUser'], 'timestamp'=>$timestamp));
				$returnData	=	array('userid'=>$user_id->{'$id'});
			}
			$status		=	true;			
		}else{
			throw new Exception('post data is not set');
		}		
	} catch(MongoCursorException $e) {
		$returnData	=	"Error:".$e->getCode()." AND Message: ".$e->getMessage();
	} catch(Exception $e){
		$returnData	=	"Error:".$e->getCode()." AND Message: ".$e->getMessage();
	}
	
	echo json_encode( array('returnData'=>$returnData, 'status'=>$status) );
	
}elseif( $_REQUEST['action'] == 'delete' ){
	try {
		// Getting post text from the AJAX POST parameters
		if( isset($_POST['data']) ) {
			$data		=	$_POST['data'];
		
			$collection->remove(array("_id" => new MongoId($data['user_id']) ), array("justOne" => true));
			$status	=	true;
		}else{
			throw new Exception('post data is not set');
		}
	} catch(MongoCursorException $e) {
		$returnData	=	"Error:".$e->getCode()." AND Message: ".$e->getMessage();
	} catch(Exception $e){
		$returnData	=	"Error:".$e->getCode()." AND Message: ".$e->getMessage();
	}
	echo json_encode( array('returnData'=>$returnData, 'status'=>$status));
	
}elseif( $_REQUEST['action'] == 'find' ){
	try {
		// Retrieving all the posts in the collection
		// If you want to retrieve specific posts based on user, relations, etc. put filter condition in find 
		$users_cursor=$collection->find()->sort(array('_id'=>-1));
		
		$userDetailsObj	=	'[';	// sending as array no need to add "[" bracket
		
		//Iterating over all the retrieved posts
		while ($users_cursor->hasNext()) { 
			$user = $users_cursor->getNext();
			// this step useful when we are calling directly from php	
			$userDetailsObj .=	'{"user_id":"'.$user['_id']->{'$id'}.'", "txtUserName":"'.$user['name'].'", "txtContactNo":"'.$user['contact_no'].'", "txtEmail":"'.$user['email'].'", "radGender":"'.$user['gender'].'", "txtAboutUser":"'.$user['comments'].'"},';
			
			// this step is useful for AJAX return variable 
			//$userDetailsObj[] =	 array('user_id'=>$user['_id']->{'$id'}, 'txtUserName'=>$user['name'], 'txtContactNo'=>$user['contact_no'], 'txtEmail'=>$user['email'], 'radGender'=>$user['gender'], 'txtAboutUser'=>$user['comments'] );			
		}
		$returnData	=	rtrim($userDetailsObj, ",").']'; // sending as array no need to add "]" bracket
		$status	=	true;
	} catch(MongoCursorException $e) {
		$returnData	=	"Error:".$e->getCode()." AND Message: ".$e->getMessage();
	}
	
	echo json_encode( array('returnData'=>$returnData, 'status'=>$status) );
}

function findId($userId){
	return $collection->find(array("_id" => $userId))->count();
}
?>
