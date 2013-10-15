<?php

namespace controller;

require_once('view/MainView.php');
require_once('view/LoginView.php');
require_once('view/AdminView.php');
require_once('controller/User.php');
require_once('controller/Redirect.php');

class App {

	/**
	 * Run the application
	 */
	public function run() {

		$mainView = new \view\MainView();
		$loginView = new \view\LoginView();
		$user = new \controller\User($mainView, $loginView);

		if ($loginView->userWantsToLogout()) {
			if ($user->isLoggedIn()) {
				$user->logout();
			}
		} else {
			$user->loggedInUser();
		}

		if ($loginView->submitLogin()) {
			$loginView->errorMessage();
			$user->loginAttempt();
			exit();
		}

		$mainView->content($loginView->getForm());
	}
}