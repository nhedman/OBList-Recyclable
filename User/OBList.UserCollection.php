<?php
namespace \controller\user\;
class UserCollection extends \model\domain\Collection {
	protected $mapper;
	protected $total = 0;
	protected $raw = array();
	private $result;
	private $cursor = 0;
	private $objects = array();
	
	function add (User $user) {
		$class = $this->targetClass();
		if (!($object instanceof $class)) {
			throw new Exception("This object collects $class objects");
		}
		//$this->notifyAccess;
		$this->objects[$this->total] = $object;
		$this->total++;
	}
	
	function targetClass() {
		return 'User';
		}
	
}