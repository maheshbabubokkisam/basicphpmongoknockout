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
		<title>Knockout JS Validation Tests</title>
		<style type="text/css">
			label { display: block; }
			.validationMessage { color: Red; }
			.customMessage { color: Orange; }   

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

    <div id="workbench">
	
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
	
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/knockout-3.0.0.js"></script>		
		<script type="text/javascript" src="js/knockout.simpleGrid.3.0.js"></script>
		<script type="text/javascript" src="js/knockout.validation.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		
        <script type="text/javascript">
            ko.validation.rules.pattern.message = 'Invalid.';

            var captcha = function (val) {
                return val == 11;
            };

            var mustEqual = function (val, other) {
                return val == other;
            };

            var viewModel = function(userDetails){
			
				items:  ko.observableArray(userDetails),
				
				sortByName:  function() {
					self.items.sort(function(a, b) {						
						return a.txtUserName < b.txtUserName ? -1 : 1;
					});
				},
		
				gridViewModel: new ko.simpleGrid.viewModel({
					data: self.items,
					columns: [
						{ headerText: "Name", rowText: "txtUserName" },
						{ headerText: "Contact No.", rowText: "txtContactNo" },
						{ headerText: "Email", rowText: 'txtEmail' },
						{ headerText: "Gender", rowText: 'radGender' },
						{ headerText: "About User", rowText: 'txtAboutUser' },						
					],
					pageSize: 10
				}),			
			
			
                firstName: ko.observable().extend({ minLength: 2, maxLength: 10 }),
                lastName: ko.observable().extend({ required: true }),
                emailAddress: ko.observable().extend({  // custom message
                    required: { message: 'Please supply your email address.' }
                }),
                age: ko.observable().extend({ min: 1, max: 100 }),
                location: ko.observable(),
                subscriptionOptions: ['Technology', 'Music'],
                subscription: ko.observable().extend({ required: true }),
                password: ko.observable(),
                captcha: ko.observable().extend({  // custom Anonymous validator
                    validation: { validator: captcha, message: 'Please check.' }
                }),
                submit: function () {
                    if (viewModel.errors().length == 0) {
                        alert('Thank you.');
                    } else {
                        alert('Please check your submission.');
                        viewModel.errors.showAllMessages();
                    }
                }
            };

            viewModel.confirmPassword = ko.observable().extend({
                validation: { validator: mustEqual, message: 'Passwords do not match.', params: viewModel.password }
            }),

            viewModel.errors = ko.validation.group(viewModel);

            viewModel.requireLocation = function () {
                viewModel.location.extend({ required: true });
            };      
        </script>
        <script id="customMessageTemplate" type="text/html">
            <em class="customMessage" data-bind='validationMessage: field'></em>
        </script>
        <fieldset>
            <legend>User: <span id="errorCount" data-bind='text: errors().length'></span> errors</legend>
            <label>First name: <input id="firstNameTxt" data-bind='value: firstName'/></label>
            <label>Last name: <input id="lastNameTxt" data-bind='value: lastName'/></label>    
            <div data-bind='validationOptions: { messageTemplate: "customMessageTemplate" }'>
                <label>Email: <input id="emailAddressTxt" data-bind='value: emailAddress' required pattern="@"/></label>
                <label>Location: <input id="locationTxt" data-bind='value: location'/></label>
                <label>Age: <input id="testAgeInput" data-bind='value: age' required/></label>
            </div>
            <label>
                Subscriptions: 
                <select data-bind='value: subscription, options: subscriptionOptions, optionsCaption: "Choose one..."'></select>
            </label>
            <label>Password: <input data-bind='value: password' type="password"/></label>
            <label>Retype password: <input data-bind='value: confirmPassword' type="password"/></label>
            <label>10 + 1 = <input data-bind='value: captcha'/></label>
        </fieldset>
        <button type="button" data-bind='click: submit'>Submit</button>
        <br />
        <br />
        <button type="button" data-bind='click: requireLocation'>Make 'Location' required</button>
        <script type="text/javascript">
            $(function () {
                var initialData = [<?php echo $userDetailsObj; ?>];
				ko.applyBindings(viewModel(initialData), $('#workbench')[0]);			
            });
        </script>
    </div>
</body>
</html>