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
		$user = new \controller\User($mainView, $loginForm, $adminView);

		if (isset($_GET['logout'])) {
			$user->logout();
		}

		$user->isLoggedIn();

		if (isset($_POST['submit'])) {
			$loginForm->checkMessage();
			$user->loginAttempt();
			exit();
		}

		$mainView->title('Ej inloggad')->content($loginForm->getForm());
	}
}