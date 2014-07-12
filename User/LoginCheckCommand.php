<?php
class LoginCheckCommand(Request $request)
{
	function execute(Request $request) {
		$user_id = $request->get['user_id'];
		$username = $request->get['username'];
		$password = $request->get['password'];
		$loginstring = $request->get['loginstring'];
		$sessionArray = $_SESSION['user'];
		if (isset($sessionArray[$loginstring]) {
			$user = $sessionArray[$loginstring];
			if ($user->loginCheck($user_id, $username, $password, $loginstring) {
				return true;
			}
			
	