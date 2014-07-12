<?php
class PatientDatabaseHelper extends DatabaseHelper
{
const INSERT = "INSERT INTO patients (lastName,firstName,dob,email) VALUES (:lastName, :firstName, :dob, :email)";
const UPDATE = "UPDATE patients SET lastName=:lastName, firstName=:firstName, dob=:dob, email=:dob...WHERE id=? LIMIT 1";
const DELETE = "DELETE FROM patients WHERE id=? LIMIT 1";
const SELECT = "SELECT * FROM patients WHERE id=:id LIMIT 1";
const SELECT_ARRAY = "SELECT * FROM patients WHERE id LIKE CONCAT(:id,'%') AND lastName LIKE CONCAT(:lastName,'%') AND firstName LIKE CONCAT(:firstName,'%') AND email LIKE CONCAT(:email,'%') AND gravida LIKE CONCAT(:gravida,'%') AND para LIKE CONCAT(:gravida,'%')";


//new object, returns int entry ID
private function newObject(Patient $patient){
//prepare statement
$stmt = $this->connection->prepare(INSERT);
//bind named values
$stmt->connection->bindValue(':lastName', $patient->lastName, PDO::PARAM_STR);
$stmt->connection->bindValue(':firstName', $patient->firstName, PDO::PARAM_STR);
$stmt->connection->bindValue(':dob', $patient->dob, PDO::PARAM_STR);
$stmt->connection->bindValue(':email', $patient->email, PDO::PARAM_STR);
//execute
if($stmt->execute()){
//return stmt id
	$insertId = $this->conneciton->lastInsertId();
	return $insertId;
}
else{
	return 0;
}
}

//save object, boolean returns true on success, false on failure
private function saveObject(Patient $patient){
//prepare statement
$stmt = $this->connection->prepare(UPDATE);
//bind named values
$stmt->connection->bindValue(':lastName', $patient->lastName, PDO::PARAM_STR);
$stmt->connection->bindValue(':firstName', $patient->firstName, PDO::PARAM_STR);
$stmt->connection->bindValue(':dob', $patient->dob, PDO::PARAM_STR);
$stmt->connection->bindValue(':email', $patient->email, PDO::PARAM_STR);
$stmt->connection->bindValue(':gravida', $patient->gravida, PDO::PARAM_STR);
$stmt->connection->bindValue(':para', $patient->para, PDO::PARAM_STR);
//execute
return $stmt->execute();
}

//load object, returns associative array
private function getObject($patient){
//prepare statement
$stmt = $this->connection->prepare(SELECT . ' LIMIT 1');
//bind named values
if (get_class($patient)=='Patient')
{
$stmt->connection->bindValue(':id', $patient->id, PDO::PARAM_INT);
}
else{
$stmt->connection->bindValue(':id', $patient, PDO::PARAM_INT);
}
//execute
$stmt->execute();
//fetch
$patientRow = $stmt->fetch(PDO::FETCH_ASSOC));
return $patientRow;
}

//delete object, boolean returns true on success, false on failure
private function deleteObject(Patient $patient){
//prepare statement
$stmt = $this->connection->prepare(DELETE);
//bind named values
$stmt->connection->bindValue(':id', $patient->id, PDO::PARAM_INT);
//execute
return $stmt->execute();
}

//load array, returns array. search terms as arguments
private function getArray($idString='', $lastNameString='', $firstNameString='', $dobString='', $emailString='', $gravida='', $para=''){
//prepare statement
$stmt = $this->connection->prepare(SELECT_ARRAY);
//bind named values
$stmt->connection->bindValue(':id', $idString, PDO::PARAM_INT);
$stmt->connection->bindValue(':lastName', $lastNameString, PDO::PARAM_STR);
$stmt->connection->bindValue(':firstName', $firstNameString, PDO::PARAM_STR);
$stmt->connection->bindValue(':dob', $dobString, PDO::PARAM_STR);
$stmt->connection->bindValue(':email', $emailString, PDO::PARAM_STR);
$stmt->connection->bindValue(':gravida', $patient->gravida, PDO::PARAM_STR);
$stmt->connection->bindValue(':para', $patient->para, PDO::PARAM_STR);
//other properties go here
//execute
$stmt->execute();
}
}