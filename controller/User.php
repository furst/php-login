<?php

namespace controller;

require_once('view/MainView.php');
require_once('view/AdminView.php');
require_once('model/User.php');
require_once('controller/Redirect.php');

class User {

	public static $loginSessionUsername = 'username';
	public static $loginSessionPassword = 'password';

	private $mainView;
	private $loginForm;
	private $adminView;
	private $user;

	public function __construct(\view\MainView $mainView, \view\LoginForm $loginForm, \view\AdminView $adminView, \model\User $user) {
		$this->mainView = $mainView;
		$this->loginForm = $loginForm;
		$this->adminView = $adminView;
		$this->user = $user;
	}

	public function loginAttempt($username, $password) {

		if ($username == $this->user->dbUsername && $password == $this->user->dbPassword) {

			if (isset($_POST['stay'])) {
				$this->adminView->setExtraMessage();
				$_SESSION[self::$loginSessionUsername] = $username;
				setcookie(self::$loginSessionUsername, $username, time()+60*60*24*365);
				setcookie(self::$loginSessionPassword, sha1($password), time()+60*60*24*365);
			} else {
				$this->adminView->setMessage();
				$_SESSION[self::$loginSessionUsername] = $username;
			}

			$this->mainView->title('Inloggad')->content($this->adminView->getContent());
		} else {
			$this->loginForm->setErrorMessage();
			$this->mainView->title('Ej inloggad')->content($this->loginForm->getForm());
		}
	}
}