<?php
class IdentityObject
{
	protected $currentfield = null;
	protected $fields = array();
	private $enforce = array();
	private $targetClass;
	
	//
	function __construct( $targetClass ) {
		switch ( $targetClass ) {
		//build  $enforce based on targetClass
		}
		$this->targetClass = $targetClass;
	}
	//String, gets target class name
	function targetClass() {
		return $this->targetClass;
	}
	
	//Array, getter for $enforce
	public function getFields() {
		return $this->enforce;
	}
	
	//IdentityObject, creates new Field object and sets it as current field
	function field($fieldname) {
		if ( ! $this->isVoid() && $this->currentfield->isIncomplete() ) {
			throw new \Exception("Current field incomplete");
		}
		$this->enforceField ($fieldname);
		//if field object exists, set that as current object else create new field, set as current, and place in fields array
		if ( isset( $this->fields[$fieldname] ) ) {
			$this->currentfield = $this->fields[$fieldname];
		} else {
			$this->currentfield = new Field($fieldname);
			$this->fields[$fieldname] = $this->currentfield;
		}
		return $this;
	}
		
	
	//IdentityObject, adds test to current Field object
	private function operator( $symbol , $value ) {
		if ( $this->isVoid() ) {
			throw new \Exception("no field defined");
		}
			$this->currentfield->addTest($symbol,$value);
			return $this;
	}
	
	//IdentityObject, adds equality test to current Field object
	function eq ( $value ) {
		return $this->operator("=" , $value);
	}
	//IdentityObject, adds > test to current Field object
	function gt ( $value ) {
		return $this->operator(">", $value);
	}
	//IdentityObject, adds < test to current Field object
	function lt ( $value ) {
		return $this->operator("<", $value);
	}
	//IdentityObject, adds like test to current Field object and appends wildcard to value
	function lk ( $value ) {
		return $this->operator("LIKE", $value . "%");
	}
	//IdentityObject, adds LIKE test to current Field and appends and prepends wildcard to value
	function cn ( $value ) {
		return $this->operator("LIKE", "%" . $value . "%");
	}
	
	//Boolean returns true if no fields have been added yet
	function isVoid() {
		return empty( $this->fields );
	}
	
	//Void throws exception if name not on list
	function enforceField( $fieldname ) {
		if(! in_array( $fieldname, $this->enforce ) && ! empty( $this->enforce ) ) {
			$forcelist = implode(', ', $this->enforce);
			throw new \Exception("Your field $fieldname is not a legal field ($forcelist)");
		}
	}
	
	//Array returns all comparisons stored in the Field objects in $this->fields
	function getComps() {
		$comparisons = array();
		foreach ($this->fields as $field) {
			$comparisons = array_merge( $comparisons, $field->getComps() );
		}
		return $comparisons;
	}
}