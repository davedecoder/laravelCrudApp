<!DOCTYPE html>
<html lang="en-US" ng-app="crudApp">
	<head>
		<title>Test 2</title>
		<link rel="stylesheet" href="<?= asset('css/bootstrap.min.css')?> ">
		<link rel="stylesheet" href="<?= asset('css/bootstrap-theme.min.css')?> ">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css">
		<link rel="stylesheet" href="<?= asset('css/styles.css')?> ">
	</head>	
	<body>
		<h2>Clients Database</h2>
		<div ng-controller="clientsController">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Last Name</th>
						<th>Second Last Name</th>
						<th>Email</th>
						<th>Birth</th>
						<th>State of Birth</th>
						<th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">Add New Client</button></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="client in clients">
						<td>{{client.id}} </td>
						<td>{{client.name}} </td>
						<td>{{client.last_name}} </td>
						<td>{{client.second_last_name}}</td>
						<td>{{client.email}} </td>
						<td>{{client.birth | date : 'yyyy-mm-dd'}} </td>
						<td>{{client.birth_state}} </td>
						<td>
							<button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', client.id)">Edit</button>
							<button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(client.id)">Delete</button>
						</td>
					</tr>
				</tbody>
			</table>

			<!--modal-->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
							<h4 class="modal-title" id="myModalLabel">{{form_title}}</h4>
						</div>
						<div class="modal-body">
							<form name="frmClients" class="form-horizontal" novalidate="">
								<div class="form-group error">
									<label for="name" class="col-sm-3 control-label">Name</label>
									<div class="col-sm-9">
										<input 
										type="text" 
										class="form-control-has-error" 
										id="name" 
										name="name"
										placeholder="Name" 
										value="{{name}}" 
										ng-model="client.name" 
										ng-required="true">
										<span class="help-inline" ng-show="frmClients.name.$invalid && frmClients.name.$touched">Name field is required</span>
									</div>
								</div>
								<div class="form-group error">
									<label for="last_name" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-9">
										<input 
										type="text" 
										class="form-control-has-error" 
										id="last_name" 
										name="last_name"
										placeholder="Last Name" 
										value="{{last_name}}" 
										ng-model="client.last_name" 
										ng-required="true">
										<span class="help-inline" ng-show="frmClients.last_name.$invalid && frmClients.last_name.$touched">Last Name field is required</span>
									</div>
								</div>
								<div class="form-group error">
									<label for="second_last_name" class="col-sm-3 control-label">Second Last Name</label>
									<div class="col-sm-9">
										<input 
										type="text" 
										class="form-control-has-error" 
										id="second_last_name" 
										name="second_last_name"
										placeholder="Second Last Name" 
										value="{{second_last_name}}" 
										ng-model="client.second_last_name" 
										>
									</div>
								</div>
								<div class="form-group error">
									<label for="email" class="col-sm-3 control-label">Email</label>
									<div class="col-sm-9">
										<input 
										type="email" 
										class="form-control-has-error" 
										id="email" 
										name="email"
										placeholder="Email" 
										value="{{email}}" 
										ng-model="client.email" 
										ng-required="true">
										<span class="help-inline" ng-show="frmClients.email.$invalid && frmClients.email.$touched">Valid Email field is required</span>
									</div>
								</div>
								<div class="form-group">
		                            <label for="birth" class="col-sm-3 control-label">Birth</label>
									<div class="col-sm-6">
										<p class="input-group">
								          <input 
								          type="text" 
								          class="form-control" 
								          uib-datepicker-popup="{{format}}" 
								          ng-model="angularDatePicker" 
								          is-open="popup1.opened"  
								          ng-required="true" 
								          close-text="Close" 
								          alt-input-formats="altInputFormats" />
								          <span class="input-group-btn">
								            <button type="button" class="btn btn-default" ng-click="open1()"><i class="glyphicon glyphicon-calendar"></i></button>
								          </span>
								        </p>
									</div>
		                        </div>								
								<div class="form-group error">
									<label for="birth_state" class="col-sm-3 control-label">Birth State</label>
									<div class="col-sm-4">
										<input type="text" autocomplete="off" ng-model="state" uib-typeahead="state.estado for state in mexicanStates | filter:$viewValue | limitTo:20" class="form-control">										
										<div ng-messages="selected_state.length > 1" ng-if="frmClients.birth_state.$touched">
            								<div class="error-message" ng-message="required">Please enter a valid address</div>
            								<div class="error-message" ng-message="autocomplete-required">Please enter a valid address from dropdown</div>
        								</div>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalState, id)" ng-disabled="frmClients.$invalid">Save changes</button>
                        </div>
					</div>
				</div>				
			</div>
		</div>
	<script src="<?= asset('js/underscore-min.js') ?>"></script>
	<script src="<?= asset('app/lib/angular/angular.min.js') ?>"></script>
	<script src="<?= asset('app/lib/angular/angular-route.min.js') ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angucomplete-alt/2.4.1/angucomplete-alt.min.js"></script>
	<script src="<?= asset('js/jquery-3.1.1.min.js') ?>"></script>
	<script src="<?= asset('js/bootstrap.min.js') ?>"></script>
	<script src="<?= asset('js/ui-bootstrap-2.5.0.min.js') ?>"></script>	
	<script src="<?= asset('app/app.js') ?>"></script>	
	<script src="<?= asset('app/controllers/clients.js') ?>"></script>	
	</body>
</html>