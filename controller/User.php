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

	public function __construct(\view\MainView $mainView, \view\LoginForm $loginForm,
								\view\AdminView $adminView) {
		$this->mainView = $mainView;
		$this->loginForm = $loginForm;
		$this->adminView = $adminView;

		$this->user = new \model\User();
	}

	public function loginAttempt() {

		$username = $_POST['username'];
		$password = $_POST['password'];

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

	public function logout() {
		unset($_SESSION[self::$loginSessionUsername]);
		setcookie(self::$loginSessionUsername, '', time()-3600);
		setcookie(self::$loginSessionPassword, '', time()-3600);

		$this->loginForm->setInfoMessage();

		Redirect::to('index.php');
	}

	public function isLoggedIn() {

		$username = $this->getCookieValue(self::$loginSessionUsername);
		$password = $this->getCookieValue(self::$loginSessionPassword);

		if(isset($_SESSION[self::$loginSessionUsername])) {
			$this->mainView->title('Inloggad')->content($this->adminView->getContent());
			exit();
		} elseif ($username == $this->user->dbUsername
					&& $password == sha1($this->user->dbPassword)) {
			$this->adminView->setCookieMessage();
			$this->mainView->title('Inloggad')->content($this->adminView->getContent());
			$_SESSION[self::$loginSessionUsername] = $_COOKIE[self::$loginSessionUsername];
			exit();
		}
	}

	public function getCookieValue($cookieHolder) {
		if (isset($_COOKIE[$cookieHolder])) {
			return $_COOKIE[$cookieHolder];
		} else {
			return '';
		}
	}
}