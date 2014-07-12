<?php
class NewUserFactory
{
	function createUser( $email ) {
		$array = UserMapper::getNewUser( $email );
		$user = new NewUser( array $array );
		return $user;
	}

	function newNewUser( $email, $role, $expiration=86400 ) {
		if(filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
			$array['email'] = $email;
			$array['role'] = $role;
			//defaults to 24 hours
			$array['expiraton'] = time() + $expiration;
			$user = New NewUser( $email, $role );
			$user->code = $this->randomString();
			return $user;
			}
		else{
			return false;
			}
	}
	
	static function randomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}