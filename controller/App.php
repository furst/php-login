<?php

namespace controller;

require_once('view/MainView.php');
require_once('view/LoginForm.php');
require_once('view/AdminView.php');
require_once('controller/User.php');
require_once('controller/Redirect.php');

class App {

	/**
	 * Run the application
	 */
	public function run() {

		$mainView = new \view\MainView();
		$adminView = new \view\AdminView();
		$loginForm = new \view\LoginForm();
		$user = new \controller\User($mainView, $loginForm, $adminView);

		if ($adminView->userWantsToLogout()) {
			$user->logout();
		}

		$user->isLoggedIn();

		if ($loginForm->submitLogin()) {
			$loginForm->checkMessage();
			$user->loginAttempt();
			exit();
		}

		$mainView->title('Ej inloggad')->content($loginForm->getForm());
	}
}