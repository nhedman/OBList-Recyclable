<?php
class Patient extends DomainObject{
//string
protected $lastName;
//string
protected $firstName;
//integer
private $id;
//date
protected $dob;
//string
protected $email;
//integer
protected $para;
//integer
protected $gravida;
//PregnancyCollection
protected $pregnancies;

//constructor, returns Patient
public function __construct (array $array)
{
$this->lastName = $array['lastName'];

$this->firstName = $array['firstName'];
//Set date of birth as MySQL intelligible date
$dobString = (string) $array['dob'];

$this->dob = date("Y-m-d", strtotime($dobString));

$this->email = $array['email'];
if (isset($array['para']) {
	$this->para = $para;
}
if (isset($array['gravida']) {
	$this->gravida = $gravida;
}
if (! isset($array['id']) {
	$this->markNew();
} else {
	$this->add()
}
}

//add new, constructs patient and marks as new
public function addNew($lastName, $firstName, $dob, $email)
{
$array = array();
$array['lastName'] = $lastName;
$array['firstName'] = $firstName
$array['dob'] = $dob;
$array['email'] = $email;
$patient = new Patient($array);
$patient->markNew();
}

//load patient from db and instantiate as Patient object, returns patient
public function load($id)
{
//select code $patientRow = ..
$patient = new Patient ($patientRow);
//lazy load pregnancy collection
return $patient;
}

//destruct and delete via DBH void
public function delete()
{
//stub
}

//get lastName
public getLastName()
{
return $this->lastName;
}

//get firstName
public getFirstName()
{
return $this->firstName;
}

//get id, integer
public getId()
{
return $this->id;
}

//get dob, takes php date format argument, returns formatted date as date
public getDob($format) 
{
$dobString = (string) $this->dob;
$dob = date($format, strtotime($dobString));
return $dob;
}

//get age in years, integer
public getAge()
{
$age = (date("md", date("U", mktime(0, 0, 0, $this->dob[1], $this->dob[2], $this->dob[0]))) > date("md") ? ((date("Y")-$this->dob[0])-1):(date("Y")-$this->dob[0]));
return (int) $age;
}

//integer get para 
public getPara()
{
return $this->para;
}

//integer get gravida
public getGravida()
{
return $this->gravida;
}

//setter methods, void. automatically save to dbh
public setLastName($lastName)
{
$this->lastName = $lastName;
$this->markDirty();
}

public setFirstName($firstName)
{
$this->firstName = $firstName;
$this->markDirty();
}

public setDob($dob)
{
$dobString = (string) $dob;
$this->dob = date($format, strtotime($dobString));
$this->markDirty();
}

public setEmail($email)
{
$this->email = $email;
$this->markDirty();
}

public setPara($para)
{
$this->para = $para;
$this->markDirty();
}

//set
public setGravida ($gravida)
{
$this->gravida = $gravida;
$this->markDirty();
}

//void increment/decrement para and gravida
public incrementPara()
{
$this->para = $this->para + 1;
$this->markDirty();
}

public decrementPara()
{
$this->para = $this->para - 1;
$this->markDirty();
}

public incrementGravida()
{
$this->gravida = $this->gravida + 1;
$this->markDirty();
}

public decrementGravida()
{
$this->gravida = $this->gravida - 1;
$this->markDirty();
}

}