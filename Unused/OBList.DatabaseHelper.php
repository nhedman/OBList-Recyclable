<?php
abstract class DatabaseHelper
{
protected const HOST = "localhost"; // The host you want to connect to.
protected const USER = "oblistuser"; // The database username.
protected const PASSWORD = "73Bw*XgrgmUwW"; // The database password.
protected const DATABASE = "oblist"; // The database name.
private $connection;

__construct(){
	$this->connection = new pdo(HOST, USER, PASSWORD, DATABASE);
}

__destruct(){
	unset($this->connection);
}

abstract function newObject();
abstract function saveObject();
abstract function deleteObject();
abstract function getObject();
abstract function getArray();
}