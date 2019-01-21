<?php

class DAO {
private $servername = "127.0.0.1";
private $database = "paylocity";
private $username = "root";
private $password = "";



function getConnection(){
  try {
    $conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  }
  catch(PDOException $e)
  {
    echo "Connection failed: " . $e->getMessage();
  }
  throw new Exception("user not found");

  }

function lookForEmployee($companyId){
  $conn = $this->getConnection();
  $query = $conn->prepare("SELECT companyId, firstName, lastName FROM employee WHERE companyId='" . $companyId . "'");
  $query->setFetchMode(PDO::FETCH_ASSOC);
  $query->bindParam(':companyId', $companyId);
  $query->execute();
  return $query->fetchAll();
}

function addNewEmployee(){
  $conn = $this->getConnection();
  $query = $conn->prepare("INSERT INTO employee (companyId, firstName, lastName, dependents) VALUES ('" . $_POST["companyId"] . "','" . $_POST["firstName"] . "','" . $_POST["lastName"] . "','" . $_POST["numDep"] ."')");
  $query->bindParam(':companyId', $_POST["companyId"]);
  $query->bindParam(':firstname',  $_POST["firstName"]);
  $query->bindParam(':lastname',  $_POST["lastName"]);
  $query->bindParam(':dependents',  $_POST["numDep"]);
  $query->execute();
  }

  function calculateBenefitCost(){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT dependents FROM employee WHERE companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->execute();
		$numDependents = $query->fetchAll();
    $dependentCost = 500;
    $benefitsTotalCost = 1000;

    foreach($numDependents as $dependent){
      $convertDependent = $dependent['dependents'];
      $benefitsTotalCost += $dependentCost*$convertDependent;
    }
    $query = $conn->prepare("UPDATE employee SET benefitsCosts='". $benefitsTotalCost ."' WHERE companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->bindParam(':benefitsCosts', $benefitsTotalCost);
    $query->execute();
  }

  function overallPaycheck(){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT benefitsCosts, salary FROM employee WHERE companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->execute();
    $paycheck = $query->fetchAll();
    foreach($paycheck as $subPaycheck){
      $convertBenefits = $subPaycheck['benefitsCosts'];
      $convertSalary = $subPaycheck['salary'];
      $totalPaycheck = $convertSalary-$convertBenefits;
    }
    $query = $conn->prepare("UPDATE employee SET paycheck='". $totalPaycheck ."' WHERE companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->bindParam(':paycheck', $totalPaycheck);
    $query->execute();
  }

  function checkForDepedents(){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT dependents FROM employee WHERE companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->execute();
    $numDependents = $query->fetchAll();
    foreach($numDependents as $dependents){
      $isDependent = $dependents['dependents'];
    }
    if($isDependent > '0' &&  !empty($_POST['depFirstName'])){
        $query = $conn->prepare("INSERT INTO dependents (companyId, firstName, lastName, age) VALUES ('" . $_POST["companyId"] . "','" . $_POST["depFirstName"] . "','" . $_POST["depLastName"] . "','" . $_POST["depAge"] ."')");
        $query->bindParam(':companyId', $_POST["companyId"]);
        $query->bindParam(':firstName',  $_POST["depFirstName"]);
        $query->bindParam(':lastName',  $_POST["depLastName"]);
        $query->bindParam(':age',  $_POST["depAge"]);
        $query->execute();
    }
    return false;
  }

  function showEmployeeData($employer){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT companyId, firstname, lastname, salary, benefitsCosts, dependents, paycheck FROM employee WHERE employerId= :employerId ORDER BY companyId");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':employerId',  $employer);
    $query->execute();
    return $query->fetchAll();
  }

  function employeeBenefitsDiscount(){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT employee.companyId, employee.firstname AS employeeName, employee.benefitsCosts, dependents.firstName AS dependentName FROM employee INNER JOIN dependents ON employee.companyId=dependents.companyId WHERE employee.companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->execute();
    $firstNameDisc = $query->fetchAll();
    $benDisc = 0.10;
    $benefitsConvert = 1000;
    foreach($firstNameDisc as $firstNameDiscs){
      $convertDependent = substr($firstNameDiscs['dependentName'], 0, 1);
      $convertEmployee = substr($firstNameDiscs['employeeName'], 0, 1);
      $benefitsConvert = $firstNameDiscs['benefitsCosts'];
      if($convertEmployee == 'A' || $convertEmployee == 'a'|| $convertDependent == 'A' || $convertDependent == 'a'){
        $benefitsConvert -= $benDisc*$benefitsConvert;
      }
    }
    $query = $conn->prepare("UPDATE employee SET benefitsCosts='". $benefitsConvert ."' WHERE companyId='" . $_POST["companyId"] . "'");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->bindParam(':companyId',  $_POST["companyId"]);
    $query->bindParam(':benefitsCosts', $benefitsConvert);
    $query->execute();
  }

}

?>
