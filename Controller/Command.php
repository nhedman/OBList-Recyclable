<?php
namespace \controller\
abstract class Command
{
	private $roles = array();
	abstract function execute(Request $request);
	abstract public function getRoles();
}