<?php
//including common mongo connection file
include('mongo_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<link href="" media="screen" rel="stylesheet" />		
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<style>
			body {padding-top: 40px;padding-bottom: 40px;background-color: #eee;}
			.form-signin {max-width: 330px;padding: 15px;margin: 0 auto;}
			.form-signin .form-signin-heading, .form-signin .checkbox {	margin-bottom: 10px; }
			.form-signin .checkbox {font-weight: normal;}
			.form-signin .form-control {position: relative;font-size: 16px;height: auto;padding: 10px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}
			.form-signin .form-control:focus {z-index: 2;}
			.form-signin input[type="text"] {margin-bottom: -1px;border-bottom-left-radius: 0;border-bottom-right-radius: 0;}
			.form-signin input[type="password"] {margin-bottom: 10px;border-top-left-radius: 0;border-top-right-radius: 0;}		
			
			/* KO Grid */
			.ko-grid { margin-bottom: 1em; width: 100%; border: 1px solid silver; background-color:White; }
			.ko-grid th { text-align:left; background-color: Black; color:White; }
			.ko-grid td, th { padding: 0.4em; }
			.ko-grid tr:nth-child(odd) { background-color: #DDD; }
			.ko-grid-pageLinks { margin-bottom: 1em; }
			.ko-grid-pageLinks a { padding: 0.5em; }
			.ko-grid-pageLinks a.selected { background-color: Black; color: White; }
			.liveExample { height:20em; overflow:auto } /* Mobile Safari reflows pages slowly, so fix the height to avoid the need for reflows */

			li { list-style-type: disc; margin-left: 20px; }
			
		</style>
	</head>
	
	<body>
		<div class="container">
			<header class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
				</div>
			</header>

			<div class="row">
				<div class="span4">
					<br>
					<form class="form-horizontal" data-bind="jqValidation: validationContext">
						<fieldset>			
							<!-- Form Name -->
							<legend>Add User details</legend>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtUserName">User Name</label>  
								<div class="col-md-4">
									<input tabindex="1" id="txtUserName" name="txtUserName" type="text" placeholder="Enter User name" class="form-control input-md" data-bind="value: txtUserName" data-required="true" data-msg_empty="Enter User name" />
								</div>
							</div>
							
							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtContactNo">Contact No.</label>  
								<div class="col-md-4">
									<input tabindex="2" id="txtContactNo" name="txtContactNo" type="text" placeholder="Enter Contact No." class="form-control input-md" data-bind="value: txtContactNo" />
								</div>
							</div>
							
							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtEmail">Email</label>
								<div class="col-md-4">
									<input tabindex="3" id="txtEmail" name="txtEmail" type="text" placeholder="Enter Email" class="form-control input-md" data-bind="value: txtEmail" data-required="true" data-email="true" data-msg_empty="Enter a E-Mail." />
								</div>
							</div>

							<!-- Multiple Radios -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="radGender">Gender</label>
								<div class="col-md-4">
									<div class="radio">
										<label for="radios-0"><input tabindex="4" type="radio" name="radGender" id="radios-0" value="male" data-bind="checked: radGender">Male</label>
									</div>
									<div class="radio">									
										<label for="radios-1"><input tabindex="5" type="radio" name="radGender" id="radios-1" value="female" data-bind="checked: radGender">Female</label>
									</div>
								</div>
							</div>
							
							<!-- Textarea -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtAboutUser">About User</label>
								<div class="col-md-4">                     
									<textarea class="form-control" tabindex="6" id="txtAboutUser" name="txtAboutUser" data-bind="value:txtAboutUser">NA</textarea>
								</div>
							</div>
							
							<!-- Button (Double) -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="button1id"></label>
								<div class="col-md-8">
									<button tabindex="7" type="submit" id="button1id" name="button1id" class="btn btn-success" data-bind="click:saveUserDetails">Submit</button>
									<button tabindex="8" type="reset" id="button2id" name="button2id" class="btn btn-danger" data-bind="click:resetForm">Cancel</button>
								</div>
							</div>
							<div class="form-group" data-bind="html:insertStatus"></div>
						</fieldset>
					</form>	
				</div>
			</div>
			
			<div class="row">
				<div class="span4">
					<?php
					//Selecting the users_collection
					$collection = $database->selectCollection('users_collection');					
					
					// Retrieving all the posts in the collection
					// If you want to retrieve specific posts based on user, relations, etc. put filter condition in find 
					$users_cursor=$collection->find()->sort(array('_id'=>-1));
					
					$userDetailsObj	=	'';					
					//Iterating over all the retrieved posts
					while ($users_cursor->hasNext()) { 
						$user = $users_cursor->getNext();
						$userDetailsObj	.=	"{user_id:'".$user['_id']."', txtUserName:'".$user['name']."', txtContactNo:'".$user['contact_no']."', txtEmail:'".$user['email']."', radGender:'".$user['gender']."', txtAboutUser:'".$user['comments']."'},";
					}					
					?>
					<div class="" data-bind='simpleGrid: gridViewModel'></div>
					<button class="btn btn-success" data-bind='click: sortByName'>Sort by name</button>					
				</div>
			</div>
		</div>	
		
		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/knockout-3.0.0.js"></script>		
		<script type="text/javascript" src="js/knockout.simpleGrid.3.0.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		
		<script type="text/javascript">
			
			var initialData = [<?php echo $userDetailsObj; ?>];
			//var initialData = [ { name: "Optimistic Snail", sales: 420, price: 1.50 }, { name: "Optimistic Snail", sales: 420, price: 1.50 } ]
			
			//function validateAndSaveUserDetails(userDetails) {
			var validateAndSaveUserDetails = function(userDetails) {
				var self = this;
				self.items = ko.observableArray(userDetails);			
				
				self.sortByName = function() {
					self.items.sort(function(a, b) {
						return a.name < b.name ? -1 : 1;
					});
				};
			
				self.gridViewModel = new ko.simpleGrid.viewModel({
					data: self.items,
					columns: [
						{ headerText: "Name", rowText: "txtUserName" },
						{ headerText: "Contact No.", rowText: "txtContactNo" },
						{ headerText: "Email", rowText: 'txtEmail' },
						{ headerText: "Gender", rowText: 'radGender' },
						{ headerText: "About User", rowText: 'txtAboutUser' }
					],
					pageSize: 10
				});
	
				self.txtUserName = ko.observable('');
				self.txtContactNo = ko.observable('');
				self.txtEmail = ko.observable('');
				self.radGender = ko.observable('');				
				self.txtAboutUser = ko.observable('');
				self.insertStatus = ko.observable('<span style="color:green">Hi</span>');
				
				self.saveUserDetails = function() {	
					self.User = {txtUserName:self.txtUserName(), txtContactNo:self.txtContactNo(), txtEmail:self.txtEmail(), radGender:self.radGender(), txtAboutUser:self.txtAboutUser()};				
					var data = ko.toJS({"data":self.User});
					
					$.ajax({
						crossDomain: true,
						type: 'POST',
						url: "php_scripts/insert_user_details.php",						
						data: data,
						processdata: true,
						success: function (result) {
							self.items.push(self.User);
							self.insertStatus('<span style="color:green">Success</span>');							
							self.gridViewModel.currentPageIndex( parseInt( Math.ceil(self.items().length/self.gridViewModel.pageSize)-1) );
							//self.sortByName();
						},
						error: function (xhr, ajaxOptions, thrownError) {
							self.insertStatus('<span style="color:red">Hi please try again.'+xhr.status+'</span>');
							alert(thrownError);
						}
					});
				};
				
				self.resetForm = function() {};
			};
			
			ko.applyBindings(new validateAndSaveUserDetails(initialData));
		</script>

	</body>
</html>	