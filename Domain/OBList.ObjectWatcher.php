<?php
namespace OBList\Domain;

class ObjectWatcher {
	private $all = array();
	private $dirty = array();
	private $newList = array();
	private $memcache;
	//private $delete = array();
	private static $instance = null;
	
	private function __construct(){
		$this->memcache = MyMemcache::instance();
		$this->dirty = $this->memcache->get('dirty');
		$this->newList = $this->memcache->get('newList');
	}
	//ObjectWatcher singleton instantiation
	static function instance(){
		if ( is_null( self::$instance ) ) {
			self::$instance = new ObjectWatcher();
		}
		return self::$instance;
	}
	
	//string unique identifier class . id
	function globalKey( DomainObject $obj ) {
		$key = get_class( $obj ).".".$obj->getId();
		return $key;
	}
	//void add object to ObjectWatcher register under array key globalKey
	static function add( DomainObject $obj ) {
		$inst = self::instance();
		$inst->all[$inst->globalKey( $ obj )] = $obj;
	}
	
	//DomainObject returns null if not found
	static function exists( $className, $id) {
		$inst = self::instance();
		$key = $className . "." . $id;
		$inst->dirty = $inst->memcache->get('dirty');
		if( isset($inst->dirty[$key]) ) {
			return $inst->dirty[$key];
		}
		if( isset($inst->all[$key]) ) {
			return $inst->all[$key];
		}
		return null;
	}
	
	/*
	static function addDelete( DomainObject $obj ) {
		$inst = self::intance();
		$self->delete[$self->globalKey( $obj )] = $obj;
	}
	*/
	
	static function addDirty( DomainObject $obj ) {
		//instantiate ObjectWatcher
		$inst = self::instance();
		//replace dirty array with cached dirty array
		$inst->dirty = $inst->memcache->get('dirty');
		//adds item if absent
		if ( ! in_array ( $obj, $inst->dirty, true ) ) {
			$inst->dirty[$inst->globalKey( $obj )] = $obj;
			$inst->memcache->replace('dirty', $inst->dirty);
			return true;
		}
		else{
			return false;
		}
		$inst->add( $obj );
	}
	//boolean returns false if item locked or is not dirty, updates cached version and returns true if unlocked
	static function updateDirty ( DomainObject $obj ) {
		//instantiate ObjectWatcher
		$inst = self::instance();
		//replace dirty array with cached dirty array
		$inst->dirty = $inst->memcache->get('dirty');
		//locks array or returns false
		if ($inst->memcache->lock($inst->globalKey( $obj ), 60) ){
			//if in array, updates with new variable
			if ( in_array ( $obj, $inst->dirty, true ) ) {
				$inst->dirty[$inst->globalKey( $obj )] = $obj;
				$inst->memcache->replace('dirty', $inst->dirty);
			}
			else {
				$inst->memcache->unlock($inst->globalKey ($obj ));
				return false;
			}
			//unlocks key
			$inst->memcache->unlock($inst->globalKey ($obj ));
			return true;
		}
		else{
			$inst->memcache->unlock($inst->globalKey ($obj ));
			return false;
		}
		$inst->add( $obj );
	}
	
//acquires the dirty version of an object
	static function getDirty ( DomainObject $obj ) {
		$inst = self::instance();
		$inst->dirty = $this->memcache->get('dirty');
		if (in_array ( $obj, $inst->dirty, true) ) {
			$inst->add( $inst->dirty[$self->globalKey( $obj )] );
			return $inst->dirty[$self->globalKey( $obj )];
		}
		return null;
	}
	
	static function addNew ( DomainObject $obj ) {
		$inst = self::instance();
		$inst->newList = $inst->memcache->get('newList');
		$inst->newList[] = $obj;
		$inst->newList = $inst->memcache->replace('newList');
	}
	
	static function addClean ( DomainObject $obj ) {
		$inst = self::instance();
		$inst->dirty = $inst->memcache->get('dirty');
		$inst->newList = $inst->memcache->get('newList');
		//unset ( $self->delete[$self->globalKey( $obj )] );
		unset ( $inst->dirty[$self->globalKey( $obj )] );
		$self->newList = array_filter( $self->newList, function($a) use ($obj) { return !( $a === $obj ); } );
	}
	
	function performOperations() {


		$this->newList = $this->memcache->get('newList');
		$this->dirty = $this->memcache->get('dirty');
		foreach( $this->newList as $key=>$obj ) {
			//insert method, maybe setId in all
		}
		foreach( $this->dirty as $key=>$obj ) {
			//update method
		}
		
		/*
		foreach( $this->delete as $key=>$obj ) {
			//delete method
		}
		
		$this->delete = array();
		*/
		
		$this->dirty = array();
		$this->newList = array();
		$this->memcache->replace('newList', $this->newList);
		$this->memcache->replace('dirty', $this->dirty);
	}
}