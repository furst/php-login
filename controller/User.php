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

			$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

			if (isset($_POST['stay'])) {
				$this->adminView->setExtraMessage();
				$_SESSION['isLoggedIn'] = true;
				setcookie(self::$loginSessionUsername, $username, time()+60);
				setcookie(self::$loginSessionPassword, sha1($password), time()+60);
				$this->user->write(time()+60);
			} else {
				$this->adminView->setMessage();
				session_regenerate_id();
				$_SESSION['isLoggedIn'] = true;
			}

			$this->mainView->title('Inloggad')->content($this->adminView->getContent());
		} else {
			$this->loginForm->setErrorMessage();
			$this->mainView->title('Ej inloggad')->content($this->loginForm->getForm());
		}
	}

	public function logout($withMessage = true) {
		unset($_SESSION['isLoggedIn']);
		setcookie(self::$loginSessionUsername, '', time()-3600);
		setcookie(self::$loginSessionPassword, '', time()-3600);

		if ($withMessage) {
			$this->loginForm->setInfoMessage();
		}

		Redirect::to('index.php');
	}

	public function isLoggedIn() {

		if (isset($_SESSION['HTTP_USER_AGENT'])) {
			if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {
				return;
			}
		}

		if (isset($_SESSION['REMOTE_ADDR'])) {
			if ($_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']) {
				return;
			}
		}

		$username = $this->getCookieValue(self::$loginSessionUsername);
		$password = $this->getCookieValue(self::$loginSessionPassword);

		if(isset($_SESSION['isLoggedIn'])) {
			if ($_SESSION['isLoggedIn']) {
				$this->mainView->title('Inloggad')->content($this->adminView->getContent());
				exit();
			}
		} elseif(isset($_COOKIE[self::$loginSessionUsername]) && isset($_COOKIE[self::$loginSessionPassword])) {
			if($username == $this->user->dbUsername && $password == sha1($this->user->dbPassword)) {
				if ($this->user->getCookieDate() < time()) {
					$this->loginForm->setCookieMessage();
					$this->logout(false);
				}
				$this->adminView->setCookieMessage();
				$this->mainView->title('Inloggad')->content($this->adminView->getContent());
				$_SESSION['isLoggedIn'] = true;
				exit();
			} else {
				$this->loginForm->setCookieMessage();
				$this->logout(false);
			}
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