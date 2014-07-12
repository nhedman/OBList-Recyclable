<?php
class Request {
    private $url_elements;
    private $verb;
    private $parameters = array();
	private $command;
	private $error = '';
	private $response;
 
    public function __construct() {
        $this->verb = $_SERVER['REQUEST_METHOD'];
        $this->url_elements = explode('/', $_SERVER['PATH_INFO']);
		$this->parseIncomingParams();
		$this->format = 'json';
		if (isset($this->paramaters['format']) {
			$this->format = $this->paramaters['format'];
		}
	}
	
	function parseIncomingParams() {
		switch ($this->verb) {
			case 'post';
			
	}
	
	function get($key) {
		if( isset($parameters[$key]) ) {
			return $parameters[$key];
	}
		