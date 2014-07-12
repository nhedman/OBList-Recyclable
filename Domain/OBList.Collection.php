<?php
abstract class Collection implements \Iterator {
	protected $mapper;
	protected $total = 0;
	protected $raw = array();
	private $result;
	private $cursor = 0;
	private $objects = array();
	
	function __construct (array $raw=null, Mapper $mapper=null) {
		if (! is_null( $raw ) && ! is_null( $mapper ) ) {
			$this->raw = $raw;
			$this->total = count($raw);
		}
		$this->mapper = $mapper;
	}
	
	function add (/*needs class path */DomainObject $object) {
		$class = $this->targetClass();
		if (!($object instanceof $class)) {
			throw new Exception("This object collects $class objects");
		}
		//$this->notifyAccess;
		$this->objects[$this->total] = $object;
		$this->total++;
	}
	
	abstract function targetClass();
	
	/*
	protected function notifyAccess() {
	//deliberately blank
	}
	*/
	
	//get object in row $rowNum,  returns object
	private function getRow( $rowNum ) {
		//$this->notifyAccess();
		//return null if row number is greater than array length
		if ( $rowNum >= $this->total || $num < 0 ) {
			return null;
		}
		//return object if object already generated for collection
		if ( isset( $this->objects[$rowNum] ) ){
			return $this->objects[$rowNum];
		}
		//generate and return object if present in raw but not objects
		if ( isset ($this->raw[$rowNum] ) ){
			$this->objects[$rowNum] = $this->mapper->createObject($this->raw[$rowNum]);
			return $this->objects[$rowNum];
		}
	}
	//required Iterator functions
	//void rewind sets cursor to 0
	public function rewind() {
		$this->cursor = 0;
	}
	
	//get object at current cursor position returns object
	public function current() {
		return $this->getRow($this->cursor);
	}
	
	//integer return current cursor position
	public function key() {
		return $this->cursor();
	}
	
	//object increments cursor, returns object  
	public function next() {
		$row = $this->getRow( $this->cursor );
		if ($row) {$this->cursor++;}
		return $row;
	}
	
	public function valid() {
		return ( ! is_null ( $this->current() ) );
	}
	
}
	