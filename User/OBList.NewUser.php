<?php
class NewUser extends User
{
	private $email;
	private $code;
	private $expiraton;
	
	__construct( array $array ) {
		$this->id = $array['id'];
		$this->email = $array['email'];
		$this->code = $array['code'];
		$this->expiration = $array['expiration'];
		$this->role = $array['role'];
	}

	function verify( $email, $code ) {
		$curtime = time();
		if ( strtolower($email) == strtolower($this->email) && $code == $this->code && $curtime < $this->expiraton ) {
			return true;
		}
		return false;
	}
	
	function register( $username, $password ) {
		//returns if valid
		$passwordRegex = "/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{8,20})/";
		//returns if valid
		$userRegex = "/[\w\d]{6,30}$/";
		if ( preg_match($passwordRegex,$password) > 0 ) {
			if( preg_match($userRegex,$user) > 0 ) {
				// Create a random salt
				$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
				// Create salted password (Careful not to over season)
				$passwordHash = hash('sha512', $password.$random_salt);
				$this->password = $passwordHash;
				$this->salt = $random_salt;
				$this->username = $username;
				UserMapper::saveUser( $this );
				$result=true;
				return $result;
			} else {
				$result = "Invalid username";
		} else {
			$result = "Invalid password";
		}
	}
	
	function resetExpiration($expiration=86400) {
		$this->expiration = time() + $expiration;
	}
	
	function sendInvitation() {
		$code = $this->code;
		$msg->subject = "Registration at mOB-GYN.com";
		$msg->body = "You've been invited to register as user at mOB-GYN.com";
		//email to $this->email
	}
}
	//Client code for function registration( $email, $code )
	//$nu = NewUserFactory::CreateUser( $email );
	//if ( $nu->verify( $email, $code ) ) {
	//	$nu->register( $username, $password );
	