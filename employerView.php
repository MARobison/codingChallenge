<?php
session_start();
include('DAO.php');
$dao = new DAO();
$_SESSION['employer'] = '123456'
?>
<!DOCTYPE html>
<html>
<head>
	<title>Employer View</title>
	<link rel="icon" href="favIcon.png" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="employerView.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>

<br>
	<div id="iconHolder">
		<img src="paylocityImage.png" class="paylocityImage" alt="Paylocity Logo">
	</div>
	<h1 id="banner">
		Employer View
	</h1>
	
<div id=leftdiv>
<h3>Employees</h3>
<button class="" ng-click="createNewEmployee()">&#9998; Create New Employee</button>
<br>
<body ng-app="myApp" ng-controller="employeeCtrl">
<form ng-hide="hideform" method="post" action="employerView.php">
  <h3 ng-show="edit">Create New Employee:</h3>
    <label>Company Id:</label>
    <input type="text" name="companyId" ng-model="companyId" ng-disabled="!edit" placeholder="Company Id">
  <br>
    <label>First Name:</label>
    <input type="text" name="firstName" ng-model="firstName" ng-disabled="!edit" placeholder="First Name">
  <br>
    <label>Last Name:</label>
    <input type="text" name="lastName" ng-model="lastName" ng-disabled="!edit" placeholder="Last Name">
  <br>
    <label>Number of Dependents:</label>
    <input type="text" name="numDep" ng-model="numDep" placeholder="Number of Dependents">
  <br>
		<label>Depdent First Name:</label>
    <input type="text" name="depFirstName" ng-model="depFirstName" ng-disabled="!edit" placeholder="Dependent First Name">
  <br>
    <label>Dependent Last Name:</label>
    <input type="text" name="depLastName" ng-model="depLastName" ng-disabled="!edit" placeholder="Dependent Last Name">
  <br>
		<label>Age of Dependent:</label>
		<input type="text" name="depAge" ng-model="depAge" placeholder="Age of Dependent">
	<br>
	<button name="saveDep" type="submit" ng-disabled="incomplete"> Submit </button>
	</form>
	<br>
<?php
$dao = new DAO();
	if(isset($_POST['saveDep'])){
		$dao->addNewEmployee();
		$dao->calculateBenefitCost();
		$dao->checkForDepedents();
		$dao->employeeBenefitsDiscount();
		$dao->overallPaycheck();
		header("location: employerView.php");
		exit;
	}
	$employee = $dao->showEmployeeData($_SESSION['employer']);
	print "<table>
	<tr>
	<th>Company Id</th>
	<th>First Name</th>
	<th>Last Name</th>
	<th>Salary</th>
	<th>Benefits Cost</th>
	<th>Number of Dependents</th>
	<th>Yearly Paycheck after benefit deductions</th>
	</tr>";

	foreach ($employee as $employees){
		print	"<tr>
		<td>" . $employees['companyId'] . "</td>
		<td>" . $employees['firstname'] . "</td>
		<td>" . $employees['lastname'] . "</td>
		<td>" . $employees['salary'] . "</td>
		<td>" . $employees['benefitsCosts'] . "</td>
		<td>" . $employees['dependents'] . "</td>
		<td>" . $employees['paycheck'] . "</td>
		</tr>";
	}
	print	"</table>";
?>

<br>
</div>

<script src= "myEmployees.js"></script>

</body>
</html>
