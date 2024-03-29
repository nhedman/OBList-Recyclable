<?php
class Field
{
	protected $name=null;
	protected $comps=array();
	
	function __construct($name) {
		$this->name = $name;
	}
	
	function addTest( $operator, $value ) {
		$this->comps[] = array('name'=>$this->name, 'operator'=>$operator, 'value'=>$value);
	}
	
	function getComps() {
		return $this->comps;
	}
	
	function isIncomplete() {
		return empty($this->comps);
	}
}