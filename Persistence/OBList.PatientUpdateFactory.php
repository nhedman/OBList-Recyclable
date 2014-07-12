<?php
class PatientUpdateFactory extends UpdateFactory
{
	//String
	function updateObject(DomainObject $object) {
		$id = $object->id;
		$cond = array();
		$values = array();
		if ( $id > -1 ) {
			$cond['id'] = $object->id;
		}

		$values['lastName'] = $object->lastName;
		$values['firstName'] = $object->firstName;
		$values['dob'] = $object->dob;
		$values['email'] = $object->email;
		$values['para'] = $object->para;
		$values['gravida'] = $object->gravida;
	
		return $this->buildStatement(strtolower(get_class($object)), $values, $cond );
	}
}

