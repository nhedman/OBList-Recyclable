<?php
class LoginCommand extends Command
{
	function execute(Request $request) {
		$username = $request->get('user');
		$password = $request->get('password');
		$browserstring = $request->get('browserstring');
		$user = \user\model\UserMapper::getUserByUsername($username);
		$result = $user->login($username, $password, $browserstring);
	}
}
			