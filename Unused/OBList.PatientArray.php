<?php
class PatientArray extends ObjectArray{
private $patients = array();
protected addMember(Patient $patient){
if( in_array($patient, $this->patients, true) ) {
return;
}
this->patients[] = $patient;
}

protected addMemberArray(PatientArray $patientArray){
foreach($patientArray->patients as $patient){
	$this->addMember($patient);
}
}


//returns patient
protected findMember($patientId){
foreach($patientArray as $patient){
	if ($patientId == $patient->id){
		return $patient;
	}
}
}

//returns patientArray
protected findMemberArray(array $patientIdArray){
$foundArray = new PatientArray;
foreach ($patientIdArray as $patientId){
	$foundArray->addMember($this->findMember($patientId));
}
return $foundArray;
}

protected removeMember(Patient $patient){
	$this->patients = array_udiff($this->patients, array($patient), function( $a, $b) {return ($a === $b)?0:1;});
}
	

	