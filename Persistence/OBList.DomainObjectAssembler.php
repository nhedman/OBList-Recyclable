<?php
class DomainObjectAssembler 
{
	protected static $PDO;
	protected $factory;
	protected $statements = arrray();
	
	function __construct( PersistenceFactory $factory ) {
		$this->factory = $factory;
		//To Do: get PDO set as self::$PDO
	}
	
	//PDO prepared statement, prepared from $str
	function getStatement($str){
		if ( ! isset($this->statements[$str]) ) {
			$this->statements[$str] = self::$PDO->prepare( $str );
		}
		return $this->statements[$str];
	}
	
	//
	function findOne( IdentityObject $obj ) {
		$collection = $this->find( $obj );
		return $collection->next();
	}
	
	function find ( IdentityObject $obj ) {
		$sf = new SelectFactory();
		$list($selection, $values) = $sf->newSelect($obj);
		$stmt = $this->getStatement($selection);
		$stmt->execute( $values );
		$raw = $stmt->fetchAll();
		return $this->factory->getCollection( $raw );
	}

	function insert ( DomainObject $obj ) {
		$upfact = $this->factory->getUpdateFactory();
		list( $update, $values ) = $upfact->newUpdate( $obj );
		$stmt = $this->getStatement( $update );
		$stmt->execute( $values );
		if ( $obj->getId() < 0 ) {
			$obj->setId(self::$PDO->lastInsertId());
		}
		$obj->markClean();
	}
}