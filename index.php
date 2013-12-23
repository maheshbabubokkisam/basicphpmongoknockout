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
									<input tabindex="2" id="txtContactNo" name="txtContactNo" type="number" size="10" required placeholder="Enter Contact No." class="form-control input-md" pattern="[0-9]{10}" data-bind="value: txtContactNo" />
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
									<button tabindex="8" type="reset" id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
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
		<script type="text/javascript" src="js/knockout.validation.js"></script>
		
		<script type="text/javascript">
		jQuery(function() {			
		
			//  If we are calling directly from php we can use this
			//	var initialData = [<?php //echo $userDetailsObj; ?>];
			//	var initialData = [ { name: "Optimistic Snail", sales: 420, price: 1.50 }, { name: "Optimistic Snail", sales: 420, price: 1.50 } ]
			
			ko.validation.configure({
				insertMessages: false,
				decorateElement: true,
				// errorElementClass: 'error' 
			});
			
			var vm = '';		
			
			// Create a vew model method
			var myViewModel = function(userDetails) {				
				
				var self = this;	
				
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
				
				/// START VALIDATE AND SAVE	
				self.saveUserDetails = function() {
					self.User = {user_id:self.user_id(), txtUserName:self.txtUserName(), txtContactNo:self.txtContactNo(), txtEmail:self.txtEmail(), radGender:self.radGender(), txtAboutUser:self.txtAboutUser()};										
					ajaxCall('insert', 'php_scripts/user_details.php', self.User);
				};
				/// END VALIDATE AND SAVE
				
				self.loadUserDetails = function() {
					ajaxCall('find', 'php_scripts/user_details.php', '');
				};
				
				// Sort By name 	
				self.sortByName = function() {
					self.items.sort(function(a, b) {
						return a.name < b.name ? -1 : 1;
					});
				};
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
											ajaxCall('delete', 'php_scripts/user_details.php', item.user_id);
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
				/// END GRID VIEW				
			};
			
			vm = new myViewModel( [] );
			ko.applyBindings(vm);			
			
			var ajaxCall	=	function (action, url, dataUser){
				var data = (typeof dataUser == 'object') ? ko.toJS({"data":dataUser}) : ko.toJS( {"data":{'user_id':dataUser} });
				
				$.ajax({
					crossDomain: true,
					type: 'POST',
					url: url+'?action='+action,
					data: data,
					dataType: 'json',
					processdata: true,
					success: function (result) {			
					
						// If action insert then insert user details in DB and update simpleGrid
						if(action == 'insert'){
							// Check weather hiddenUserId is empty or not, 
							// If empty then it is new user details otherwise Update the details							
							if(dataUser.user_id == undefined){
								// Add new user details to items (either insert or update)
								dataUser.user_id = result.userid;
								console.log(vm.items()); console.log(dataUser);				
								vm.items.push(dataUser);
								vm.gridViewModel.currentPageIndex( parseInt( Math.ceil(vm.items().length/vm.gridViewModel.pageSize)-1) );
								vm.actionStatus('<span style="color:green">Successfully inserted details</span>');
							}else{
								// Return user object position from usersArray using user_id/dataUser
								var pos = vm.items().map(function(e) { return e.user_id; }).indexOf(vm.hidUserId());
								
								// flag is the position of object in array
								if(pos >= 0 ){
									//console.log(vm.items()[pos]);console.log(dataUser);
									// Call compare objects method 
									var flag = compareObjects(vm.items()[pos], dataUser);
									//console.log(flag);
									
									if(flag === false) {
										vm.items.remove(vm.items()[pos]);
										vm.items.push(dataUser);
									}
									
									vm.actionStatus('<span style="color:green">Successfully Updated details</span>');
								}
							}
							
							// Reset the form elements after Edit/Add
							vm.hidUserId(''); vm.txtUserName(''); vm.txtContactNo('');
							vm.txtEmail(''); vm.radGender(''); vm.txtAboutUser('');
						}

						// If action delete then delete user details from DB and update simpleGrid
						else if(action == 'delete'){
						
							// Return user object position from usersArray using user_id/dataUser
							var pos = vm.items().map(function(e) { return e.user_id; }).indexOf(dataUser);
							
							vm.items.remove(vm.items()[pos]);
							vm.actionStatus('<span style="color:green">Successfully Deleted details</span>');
						}

						// If action find then load user details and update simpleGrid
						else if(action == 'find'){
							vm.actionStatus('<span style="color:green">Done.</span>');							
							
							var userDetails = $.map(result, function(value, index) {
								return [value];
							});
							
							jQuery.each(userDetails, function(index, item){
								vm.items.push(item);
							});							
							//vm = new myViewModel( userDetails );							
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {						
						vm.actionStatus('<span style="color:red;">Error {Status: '+xhr.status+'}, {Options: '+ajaxOptions+'}, {Error: '+thrownError+'}</span>');
					}
				});
			};
			
			//Returns the object's class, Array, Date, RegExp, Object are of interest to us
			var getClass = function(val) {
				return Object.prototype.toString.call(val).match(/^\[object\s(.*)\]$/)[1];
			};
			 
			//Defines the type of the value, extended typeof
			var whatis = function(val) {			 
				if (val === undefined) { return 'undefined'; }
				if (val === null){	return 'null'; }
			 
				var type = typeof val;
			 
				if (type === 'object') { type = getClass(val).toLowerCase(); }
			 
				if (type === 'number') {
					if (val.toString().indexOf('.') > 0) { return 'float'; }
					else { return 'integer'; }
				}			 
				return type;
			};
			 
			/**
			 *  Compare two Objects
			 *  @parm a (object), b (object)
			 *  @return flag false/true
			 */
			var compareObjects = function(a, b) {
				if (a === b){ return true; }
				for (var i in a) {
					if (b.hasOwnProperty(i)) {
						if (!equal(a[i],b[i])) { return false; }
					} else { return false; }
				}
			 
				for (var i in b) {
					if (!a.hasOwnProperty(i)) { return false; }
				}
				return true;
			};
			
			/**
			 *  Compare two Arrays
			 *  @parm a (array), b (array)
			 *  @return flag false/true
			 */
			var compareArrays = function(a, b) {
				if (a === b) { return true; }
				if (a.length !== b.length) { return false; }
				
				for (var i = 0; i < a.length; i++){
					if(!equal(a[i], b[i])) { return false; }
				};
				return true;
			};
			 
			var _equal = {};
			_equal.array = compareArrays;
			_equal.object = compareObjects;
			_equal.date = function(a, b) { return a.getTime() === b.getTime(); };
			_equal.regexp = function(a, b) { return a.toString() === b.toString(); };
			//	uncoment to support function as string compare
			//	_equal.fucntion =  _equal.regexp; 			 
			 
			/*
			 * Are two values equal, deep compare for objects and arrays.
			 * @param a {any}
			 * @param b {any}
			 * @return {boolean} Are equal?
			 */
			var equal = function(a, b) {
				if (a !== b) {
					var atype = whatis(a), btype = whatis(b);
			 
					if (atype === btype && _equal.hasOwnProperty(atype))
						return _equal[atype](a, b);
			 
					return false;
				}			 
				return true;
			};
			
			// Load user details through AJAX call
			vm.loadUserDetails();			
		});
		</script>
	</body>
</html>	