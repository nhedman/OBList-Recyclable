<?php
namespace OBList\Domain;

class MyMemcache extends Memcache {

const HOST = 'localhost';
const PORT = 11211;

	
	public static function instance (){
		if ( is_null( self::$instance ) ) {
			self::$instance = new Memcache();
		}
		self::$instance->connect(HOST, PORT);
		return self::$instance;
	}
	//boolean returns true and locks if unlocked else returns false
	static function lock ($key, $duration) {
		$inst = self::instance();
		return ($inst->add($key, '1', false, $duration));
	}
	
	
	static function getLocked($key) {
		if($this->get($key))
		{
			return true;
		}
		return false;
	}
	
	//remove lock from registry. why 
	static function unlock ($key) {
		$this->connect(HOST, PORT);
		$inst = self::instance();
		$inst->delete($key);
	}