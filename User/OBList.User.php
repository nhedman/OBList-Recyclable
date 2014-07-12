<?php
class User
{	
	const LIMIT = 5;
	private $id = -1;
	private $username;
	private $email;
	private $password;
	private $salt;
	private $loginAttempts;
	private $loggedIn = false;
	private $role;
	private $domainId;
	private $endpoints = array('email' => '', 'sms' => '', 'mobile' => '');
	private $practice;
	private $preferred;
	private $loginString;

	function __construct( array $array ) {
		$this->email = $email;
		$this->endpoints['email'] = $email;
		$this->preferred = 'email';
	}
	
	function login( $username, $password, $browserstring ) {
		$password = hash('sha512', $password.this->salt);
		$result = array();
		if( (! $this->checkBrute()) && $password == $this->password) {
			//failure, too many login attempts
			$this->loginAttempts++;
			UserMapper::saveUser( $this );
			UserMapper::logAction('Failed login', $this);
			$result['status'] = 'Locked';
			$result['success'] = false;
			$result['user'] = null;
			return $result;
		} elseif ($password == $this->password) {
			//success
			$this->loginString = hash('sha512', $password.$browserstring);
			$this->loggedIn = true;
			SessionHelper::secSessionStart();
			$sessionArray = $_SESSION['users'];
			$sessionArray[$this->loginString] = $user;
			$_SESSION['users'] = $sessionArray;
			UserMapper::saveUser( $this );
			UserMapper::logAction('Successful login', $this);
			$result['status'] = 'Logged in';
			$result['success'] = false;
			$result['user'] = $this;
			return $result;
		} else {
			//failure, wrong password
			$this->loginAttempts++;
			UserMapper::saveUser( $this );
			UserMapper::logAction('Failed login', $this);
			$result['status'] = 'Incorrect username/password';
			$result['success'] = false;
			$result['user'] = null;
			return $result;
		}
	}
	
	function loginCheck( $user_id, $username, $password,  $browserstring, $loginstring ) {
		$loginstringref = hash('sha512', $this->password.$this->browserstring);
		if ( $this->id == $user_id && $this->username == $username && $loginstringref = $loginstring && $this->loggedIn = true) {
			return true;
		} else {
			return false;
		}
	}
	
	function checkBrute() {
		if ( $this->loginAttempts >= User::LIMIT ) {
			//todo notify admin and user
			return true;
		}
		return false;
	}
	
	function setPassword( $newpassword ) {
		if ( true ) { //todo password validation
			$this->password = $newpassword;
			UserMapper::saveUser( $this );
			return true;
		}
		return false;
	}
	
	function resetAttempts() {
		$this->loginAttempts = 0;
		UserMapper::saveUser( $this );
	}
	
	function logout() {
		UserMapper::logAction('Logout', $this);
		// Start secure session
		SessionHelper::secStartSession();
		// mark user as logged out
		$this->loggedIn = false;
		// remove user from session
		$sessionArray = $_SESSION['users'];
		unset($sessionArray[$this->loginString]);
		$_SESSION['users'] = $sessionArray;
	}
}
		
		
	