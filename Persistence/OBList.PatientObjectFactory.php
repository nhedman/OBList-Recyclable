<?php
class PatientObjectFactory extends DomainObjectFactory
{
	function createObject( array $array ) {
		if ( isset($array['id']) ) {
			$existing = ObjectWatcher::exists( 'Patient' , $array['id'] );
			if( ! is_null( $existing ) ) {
				return $existing;
			}
		}
		$obj = new Patient($array);
		return $obj;
	}
}
	