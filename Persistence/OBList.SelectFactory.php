<?php
class SelectFactory
{
	function newSelect(IdentityObject $obj) {
		$table = $obj->targetClass();
		//add join functionality
		$fields = implode( ',', $obj->getObjectFields());
		$core = "SELECT $fields FROM $table";
		list($where, $values) = $this->buildWhere( $obj );
		return array( $core . " " . $where, $values);
	}

	function buildWhere(IdentityObject $obj) {
		if ( $obj->isVoid() ) {
			return array( "", array() );
		}
		$compstrings = array();
		$values = array();
		foreach ( $obj->getComps() as $comp ) {
			$comstrings[] = "{$comp['name']} {$comp['operator']} ?";
			$values[] = $comp['value'];
		}
		$where = "WHERE " . implode(" AND ", $compstrings);
		return array($where, $values);
	}
}
	