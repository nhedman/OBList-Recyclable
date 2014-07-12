<?php
abstract class DomainObjectFactory
{
	abstract function createObject( array $array );
}