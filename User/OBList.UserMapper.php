<?php
class UserMapper
{
	protected static $PDO;
	private static $selectUserStmt = 'SELECT * FROM user WHERE username = ?';
	private static $selectObjectStmt = 'SELECT * FROM user WHERE role = ? AND domainId = ?';
	private static $insertStmt = 'INSERT INTO user (username, email, password, salt, loginAttempts, role, domainId, endpoints, preferred) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
	private static $updateStmt = 'UPDATE user SET username=?, email=?, password=?, salt=?, loginAttempts=?, role=?, domainId=?, endpoints=?, preferred=? WHERE id=?'; 
	
	private function selectUserStmt() {
		return Self::$PDO->prepare($selectUserStmt);
	}
	
	function __construct() {
		if ( ! isset(self::$PDO) ) {
			
	function getUserByUsername($username) {
		$this->selectUserStmt()->prepare();
		$this->selectUserStmt()->execute($username);
		$array = $this->selectUserstmt()->fetch();
		$user = UserFactory::createUser($array);
		return $user;
	}
		
	function saveUser(User $user) {
		
		if ( $user->id > 0 ) {
			$updateArray = array($user->username, $user->email, $user->password, $user->salt, $user->loginAttempts, $user->role, $user->domainId, serialize($user->endpoints), $user->preferred);
			$this->insertStmt()->prepare();
			$this->insertStmt()->execute($updateArray);
		} else {
			$updateArray = array($user->username, $user->email, $user->password, $user->salt, $user->loginAttempts, $user->role, $user->domainId, serialize($user->endpoints), $user->preferred, $user->id);
			$this->updateStmt()->prepare();
			$this->updateStmt()->execute($updateArray);
		}
	}

	function getUserFromObject(\OBList\Model\Domain\DomainObject $obj) {
		$role = get_class($obj);
		$whereArray = array($role, $obj->id);
		$this->selectObjectStmt()->prepare();
		$this->selectObjectStmt()->execute($whereArray);
		$array = $this->selectObjectStmt()->fetch();
		if ($array) {
			$user = new User($array);
			return $user;
		}
		return null;
	}

	function getNewUser($email) {
		$this->selectNewUserStmt()->prepare();
		$this->selectNewUserStmt()->execute($email);
		$array = $this->selectNewUserStmt()->fetch;
		$user = new NewUser($array);
		return $user;
	}
	
	function deleteNewUser(NewUser $newuser) {
		$id = $newuser->id;
		$this->deleteNewUserStmt()->prepare();
		$this->deleteNewUserStmt()->execute($id);
	}

	function saveNewUser(NewUser $user) {
		if ( $user->id > 0 ) {
			$updateArray = array($user->email, $user->role, $user->domainId, $user->expiration, $user->code);
			$this->insertStmt()->prepare();
			$this->insertStmt()->execute($updateArray);
		} else {
			$updateArray = array($user->email, $user->role, $user->domainId, $user->expiration, $user->code, $user->id);
			$this->updateStmt()->prepare();
			$this->updateStmt()->execute($updateArray);
		}

	function getUsersByRole($role) {
		$result = new UserCollection;
		$this->selectByRoleStmt()->prepare();
		$this->selectByRoleStmt()->execute($role);
		while ($row = $this->selectByRoleStmt()->fetch()) {
			$user = new User($array);
			$result->add($user);
		}
		return $result;
	}

	function logAction($action, User $user) {
		$id = $user->id;
		$time = time();
		$this->logActionStmt->prepare();
		$this->logActionStmt->execute($id, $action, $time);
	}
}