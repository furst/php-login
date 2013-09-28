<?php

namespace controller;

require_once('view/MainView.php');
require_once('view/LoginForm.php');
require_once('controller/User.php');

class App {

	public function run() {
		$mainView = new \view\MainView();
		$adminView = new \view\AdminView();
		$loginForm = new \view\LoginForm();
		$user = new \model\User();

		$loginSessionUsername = \controller\User::$loginSessionUsername;
		$loginSessionPassword = \controller\User::$loginSessionPassword;

		if (isset($_COOKIE[$loginSessionUsername])) {
			$username = $_COOKIE[$loginSessionUsername];
		} else {
			$username = '';
		}
		if (isset($_COOKIE[$loginSessionPassword])) {
			$password = $_COOKIE[$loginSessionPassword];
		} else {
			$password = '';
		}

		if (isset($_GET['logout'])) {
			unset($_SESSION[$loginSessionUsername]);
			setcookie($loginSessionUsername, '', time()-3600);
			setcookie($loginSessionPassword, '', time()-3600);
			$loginForm->setInfoMessage();
			Redirect::to('/Plugg/PHP-kursen/labb1/');
		}

		if(isset($_SESSION[$loginSessionUsername])) {
			$mainView->title('Inloggad')->content($adminView->getContent());
			exit();
		} elseif ($username == $user->dbUsername && $password == sha1($user->dbPassword)) {
			$adminView->setCookieMessage();
			$mainView->title('Inloggad')->content($adminView->getContent());
			$_SESSION[$loginSessionUsername] = $_COOKIE[$loginSessionUsername];
			exit();
		}

		if (isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$loginForm->checkMessage();
			$user = new \controller\User($mainView, $loginForm, $adminView, $user);
			$user->loginAttempt($username, $password);
			exit();
		}

		$mainView->title('Ej inloggad')->content($loginForm->getForm());
	}
}