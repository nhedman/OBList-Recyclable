<?php
abstract class UpdateFactory {
	//this will build queries in the child classes
	abstract function updateObject();
	
	//Array returns array(query, terms) used in concrete newUpdate
	protected function buildStatment($table, array $fields, array $conditions) {
		$terms = array();
		if (! is_null( $conditions )) {
			$query = "UPDATE $table SET ";
			$query .= implode( " = ?,", array_keys( $fields ) )." = ?";
			$terms = array_values( $fields );
			$cond = array();
			$query .= " WHERE ";
			foreach ( $conditions as $key=>$val ) {
				$cond[]="$key = ?";
				$terms[]=$val;
			}
			$query .= implode( " AND ", $cond );
		} else {
			$query = "INSERT INTO $table (";
			$query .= implode(",", array_keys( $fields ) );
			$query .= ") VALUES (";
			foreach ( $fields as $value ) {
				$terms[] = $value;
				$qs[] = '?';
			}
			$query .= implode( ",", $qs );
			$query .= ")";
		}
		return $array ($query, $terms);
	}
	
}	