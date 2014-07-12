<?php
namespace OBList\Domain;

abstract class DomainObject {
	private $id = -1;
	
	function __construct ( $id = null ) {
		if ( is_null ( $id ) ) {
			$this->markNew();
		}
		else{
			$this->id = $id;
		}
	}
	
	function getId() {
		return $this->id;
	}
	
	function setId( $id ) {
		$this->id = $id;
		markDirty();
	}
	
	function getCollection ($type){
		return array();
	}
	
	function collection() {
		return self::getCollection ( get_class ( $this ) );
	}
	
	function markDirty() {
		ObjectWatcher::addDirty( $this );
	}
	
	//DomainObject returns dirty version if exists else returns $this
	function getDirty() {
		if(ObjectWatcher::getDirty( $this ))
		{
			return ObjectWatcher::getDirty( $this );
		}
		return $this;
	}
	
	function isDirty() {
		if(ObjectWatcher::getDirty( $this ))
		{
			return true;
		}
		return false;
	}
	
	function markNew() {
		ObjectWatcher::addNew( $this );
	}
	
	function add() {
		ObjectWatcher::add( $this );
	}
	
	function markDeleted() {
		ObjectWatcher::addDelete( $this );
	}
	
	function markClean() {
		ObjectWatcher::addClean( $this );
	}
	
	function lock($duration){
		$key = get_class( $this ).".".$this->getId();
		MyMemcache::lock( $key, $duration );
	}
	
	function unlock(){
		$key = get_class( $this ).".".$this->getId();
		MyMemcache::unlock( $key );
	}
	
	function setId( $id ) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}
	
	function finder() {
		return self::getFinder ( get_class( $this ) );
	}
	
	static function getFinder ( $type=null ) {
		if ( is_null( $type ) ) {
			return HelperFactory::getFinder( get_called_class() );
		}
		return HelperFactory::getFinder( $type );
	}
	
}