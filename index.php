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
			.action-status{color:green;}
		</style>
	</head>

	<body>
		<div class="container">
			<header class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner"></div>
			</header>

			<div class="row">
				<div class="span4">
					<br>
					<form class="form-horizontal" id="form">
						<fieldset>
							<!-- Form Name -->
							<legend>Add User details</legend>
							<input type="hidden" id="hidUserId" name="hidUserId" data-bind="value:hidUserId" />
							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtUserName">User Name</label>  
								<div class="col-md-4">
									<input tabindex="1" id="txtUserName" name="txtUserName" type="text" required placeholder="Enter User name" class="form-control input-md" data-bind="value: txtUserName" data-required="true" data-msg_empty="Enter User name" />
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtContactNo">Contact No.</label>  
								<div class="col-md-4">
									<input tabindex="2" id="txtContactNo" name="txtContactNo" type="text" size="10" required placeholder="Enter Contact No." class="form-control input-md" data-bind="value: txtContactNo" />
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="txtEmail">Email</label>
								<div class="col-md-4">
									<input tabindex="3" id="txtEmail" name="txtEmail" type="email" required placeholder="Enter Email" class="form-control input-md" data-bind="value: txtEmail" data-required="true" data-email="true" data-msg_empty="Enter a E-Mail." />
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
									<button tabindex="8" type="reset" id="button2id" name="button2id" class="btn btn-danger" data-bind="click:resetFormDetails">Cancel</button>
								</div>
							</div>
							<div class="action-status" data-bind="html:actionStatus"></div>							
						</fieldset>
					</form>	
				</div>
			</div>

			<div class="row">
				<div class="span4">
					<div class="" data-bind='simpleGrid: gridViewModel, simpleGridTemplate:"custom_grid_template"'></div>
					
					<script type="text/html" id="custom_grid_template">
						<table class="ko-grid" cellspacing="0">
							<thead>
								<tr data-bind="foreach: columns">
									<th data-bind="text: headerText"></th>
								</tr>
							</thead>
							<tbody data-bind="foreach: itemsOnCurrentPage">
							   <tr data-bind="foreach: $parent.columns">

									<!--ko if: typeof rowText == 'object' && typeof rowText.action == 'function'-->
										<!--ko if: actionText == 'Delete'-->
										<td><button class="btn btn-danger" data-bind="click:rowText.action($parent)">Delete</button></td>
										<!-- /ko -->

										<!--ko if: actionText == 'Edit'-->
										<td><button class="btn btn-danger" data-bind="click:rowText.action($parent)">Edit</button></td>
										<!-- /ko -->
								    <!-- /ko -->

								   <!--ko ifnot: typeof rowText == 'object' && typeof rowText.action == 'function'-->
								   <td data-bind="text: typeof rowText == 'function' ? rowText($parent) : $parent[rowText] "></td>
								   <!--/ko-->
								</tr>
							</tbody>
						</table>
					</script>

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

		<script type="text/javascript" src="js/jquery-1.11.0.js"></script>		
		
		<script type="text/javascript" src="js/bootstrap.js"></script>
		
		<script type="text/javascript" src="js/knockout-3.0.0.js"></script>
		<script type="text/javascript" src="js/knockout.simpleGrid.3.0.js"></script>		
		
		<script type="text/javascript">
		jQuery(function() {
			//  If we are calling directly from php we can use this
			//	var initialData = [<?php //echo $userDetailsObj; ?>];
			//	var initialData = [ { name: "Optimistic Snail", sales: 420, price: 1.50 }, { name: "Optimistic Snail", sales: 420, price: 1.50 } ]

			var vm = tmpItemObj = '';
			
			// Create a vew model method
			var myViewModel = function(userDetails) {
		
				var self = this;
				
				// Self Observables
				{
				// To detect and respond to changes of a collection of things
				self.items	=	ko.observableArray(userDetails);

				/// BIND form values
				self.user_id		=	ko.observable();
				self.hidUserId		=	self.user_id;

				self.txtUserName	=	ko.observable();
				self.txtContactNo	=	ko.observable();
				self.txtEmail		=	ko.observable();
				self.radGender		=	ko.observable();
				self.txtAboutUser	=	ko.observable();
				self.actionStatus	=	ko.observable('<span style="color:green">Loading user details...</span>');
				self.ajaxStatus		=	ko.observable('');
				}
				
				// Start validate and save
				self.saveUserDetails = function() {
					self.User = {user_id:self.user_id(), txtUserName:self.txtUserName(), txtContactNo:self.txtContactNo(), txtEmail:self.txtEmail(), radGender:self.radGender(), txtAboutUser:self.txtAboutUser()};										
					ajaxCall('insert', 'php_scripts/user_details.php', self.User);
				};				

				// Reset the form elements
				self.resetFormDetails = function(){					
					self.user_id('');  self.hidUserId(''); self.txtUserName(''); self.txtContactNo('');
					self.txtEmail(''); self.radGender(''); self.txtAboutUser('');					
				}
				
				// Load User Details when document loaded
				self.loadUserDetails = function() {
					ajaxCall('find', 'php_scripts/user_details.php', '');
				};

				// Sort By name
				self.sortByName = function() {
					self.items.sort(function(a, b) {
						return a.name < b.name ? -1 : 1;
					});
				};
				
				// Start GRID view
				self.gridViewModel = new ko.simpleGrid.viewModel({
					data: self.items,
					columns: [
						{ headerText: "Name", rowText: "txtUserName"},
						{ headerText: "Contact No.", rowText: "txtContactNo" },
						{ headerText: "Email", rowText: 'txtEmail' },
						{ headerText: "Gender", rowText: 'radGender' },
						{ headerText: "About User", rowText: 'txtAboutUser' },
						{ 
							headerText: "",
							rowText: {
								action: function(item){
									return function(){
										if(confirm("Are you sure you want Delete this record")){
											ajaxCall('delete', 'php_scripts/user_details.php', item);
										}
									}
								}
							},
							actionText:"Delete"
						},
						{
							headerText: "",
							rowText: {
								action: function(item){
									return function(){
										tmpItemObj	=	item;
										//console.log('Edit');console.log(item);
										self.hidUserId(item.user_id);
										self.txtUserName(item.txtUserName);
										self.txtContactNo(item.txtContactNo);
										self.txtEmail(item.txtEmail);
										self.radGender(item.radGender);
										self.txtAboutUser(item.txtAboutUser);
									}
								}
							},
							actionText:"Edit"
						}
						
					],
					pageSize: 10
				});
			};

			vm = new myViewModel( [] );
			ko.applyBindings(vm);
			
			var ajaxCall	=	function (action, url, dataUser){
				var data	=	ko.toJS({"data":dataUser});
				vm.actionStatus((action == 'find') ? 'Loading Details...' : '');				
				$.ajax({
					crossDomain: true,
					type: 'POST',
					url: url+'?action='+action,
					data: data,
					dataType: 'json',
					processdata: true,
					success: function (result){
						//	If action insert then insert user details in DB and update simpleGrid
						if(action == 'insert'){
						
							if(result.status) {
								// Check weather hiddenUserId is empty or not, 
								// If empty then it is new user details otherwise Update the details
								if(dataUser.user_id == undefined || dataUser.user_id == ''){
									
									// Add new user details to items 
									dataUser.user_id = result.returnData.userid;
									
									// console.log(vm.items()); console.log(dataUser);
									vm.items.push(dataUser);
									vm.gridViewModel.currentPageIndex( parseInt( Math.ceil(vm.items().length/vm.gridViewModel.pageSize)-1) );
									vm.actionStatus('<span style="color:green">Successfully inserted details</span>');
									
								}
								else{
									vm.items.replace(tmpItemObj, dataUser);
									tmpItemObj = '';
								}
								vm.resetFormDetails();
							}
							else{
								vm.actionStatus('<span style="color:red">'+result.returnData+'</span>');
							}							
						}

						//	If action delete then delete user details from DB and update simpleGrid
						else if(action == 'delete'){
							if(result.status) {
								vm.items.remove(dataUser);
								vm.actionStatus('<span style="color:green">Successfully Deleted details</span>');
							}else{
								vm.actionStatus('<span style="color:red">'+result.returnData+'</span>');
							}
						}

						//	If action find then load user details and update simpleGrid
						else if(action == 'find'){
							vm.actionStatus('<span style="color:green">Done.</span>');
							
							// If we use Array functionality in php then we need this mapping
							//var userDetails = $.map(result, function(value, index) { return [value]; });
							
							// If we use string json then we need to use ko utils parse JSON method
							var userDetails = ko.utils.parseJson(result.returnData);
							jQuery.each(userDetails, function(index, item){ vm.items.push(item); });							
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						vm.actionStatus('<span style="color:red;">Error {Status: '+xhr.status+'}, {Options: '+ajaxOptions+'}, {Error: '+thrownError+'}</span>');
					}
				});
			};

			// Load user details through AJAX call
			vm.loadUserDetails();
		});
		</script>
	</body>
</html>	