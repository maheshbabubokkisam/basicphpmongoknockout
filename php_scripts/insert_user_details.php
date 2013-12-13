<?php
session_start();
/*Code written by Ashish Trivedi*/

//including common mongo connection file
include('../mongo_connection.php');

//generating a new post id
$user_id	=	new MongoId();

//getting post text from the ajax POST parameters
$data		=	$_POST['data'];
$username	=	$data['txtUserName'];
$contactno	=	$data['txtContactNo'];
$email		=	$data['txtEmail'];
$gender		=	$data['radGender'];
$comments	=	$data['txtAboutUser'];

//generating post timestamp from the post id 
//the statement should differ based on the date format needed and time zone 
$timestamp	=	date('D, d-M-Y', $user_id->getTimestamp()+19800);

//selecting posts_collection
$collection = $database->selectCollection('users_collection');

//creates document for inserting new post
$new_user_mongo = array ( '_id'=> $user_id,
						  'name' => $username,
						  'contact_no' => $contactno,
						  'email' => $email,
						  'gender' => $gender,
						  'comments' => $comments,
						  'timestamp'=>$timestamp
						  );
$collection->insert($new_user_mongo);
?>